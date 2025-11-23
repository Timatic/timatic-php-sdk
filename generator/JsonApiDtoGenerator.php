<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Generator;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Crescat\SaloonSdkGenerator\Helpers\Utils;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Timatic\SDK\Hydration\Attributes\DateTime;
use Timatic\SDK\Hydration\Attributes\Property;
use Timatic\SDK\Hydration\Model;

class JsonApiDtoGenerator extends Generator
{
    protected array $generated = [];

    public function generate(ApiSpecification $specification): PhpFile|array
    {
        if ($specification->components) {
            foreach ($specification->components->schemas as $className => $schema) {
                $this->generateModelClass(NameHelper::safeClassName($className), $schema);
            }
        }

        return $this->generated;
    }

    protected function generateModelClass(string $className, Schema $schema): PhpFile
    {
        $modelName = NameHelper::dtoClassName($className);

        $classType = new ClassType($modelName);
        $classFile = new PhpFile;
        $namespace = $classFile
            ->addNamespace("{$this->config->namespace}\\{$this->config->dtoNamespaceSuffix}");

        // Extend Model instead of Spatie Data
        $classType->setExtends(Model::class)
            ->setComment($schema->title ?? '')
            ->addComment('')
            ->addComment(Utils::wrapLongLines($schema->description ?? ''));

        // Extract properties from JSON:API structure
        $properties = $this->extractJsonApiProperties($schema);

        // Add properties to the class
        foreach ($properties as $propertyName => $propertySpec) {
            $this->addPropertyToClass($classType, $namespace, $propertyName, $propertySpec);
        }

        // Add imports
        $namespace->addUse(Model::class);
        $namespace->addUse(Property::class);

        $namespace->add($classType);

        $this->generated[$modelName] = $classFile;

        return $classFile;
    }

    /**
     * Extract properties from JSON:API schema structure
     *
     * @return Schema[]
     */
    protected function extractJsonApiProperties(Schema $schema): array
    {
        // Check if this is a JSON:API schema with attributes at root level
        if (isset($schema->properties['attributes'])) {
            $attributesSchema = $schema->properties['attributes'];

            if ($attributesSchema instanceof Schema && isset($attributesSchema->properties)) {
                // Return the flattened attributes properties
                return $attributesSchema->properties;
            }
        }

        // Fallback to regular properties if not JSON:API structure
        return $schema->properties ?? [];
    }

    protected function addPropertyToClass(
        ClassType $classType,
        $namespace,
        string $propertyName,
        Schema|Reference $propertySpec
    ): void {
        $type = $this->convertOpenApiTypeToPhp($propertySpec);
        $name = NameHelper::safeVariableName($propertyName);

        // Create public property with #[Property] attribute
        $property = $classType->addProperty($name)
            ->setPublic()
            ->setType($type)
            ->setNullable(true);

        // Add #[Property] attribute
        $property->addAttribute(Property::class);

        // Check if this is a datetime field by format OR by naming pattern
        $isDateTime = ($propertySpec instanceof Schema && $propertySpec->format === 'date-time')
            || $this->looksLikeDateTimeField($propertyName);

        if ($isDateTime) {
            $property->addAttribute(DateTime::class);
            $namespace->addUse(DateTime::class);

            // Change type to Carbon if datetime
            if (! str_contains($type, 'Carbon')) {
                $property->setType('null|\\Carbon\\Carbon');
            }
        }

        // Add comment with description if available
        if ($propertySpec instanceof Schema && $propertySpec->description) {
            $property->addComment($propertySpec->description);
        }
    }

    protected function looksLikeDateTimeField(string $name): bool
    {
        $patterns = [
            '_at$',      // snake_case: created_at, updated_at, started_at, ended_at, etc.
            'At$',       // camelCase: createdAt, updatedAt, startedAt, endedAt, etc.
            '_date$',    // snake_case: birth_date, start_date, etc.
            'Date$',     // camelCase: birthDate, startDate, etc.
            '^date_',    // snake_case: date_created, date_modified, etc.
            '^date[A-Z]', // camelCase: dateCreated, dateModified, etc.
            '_time$',    // snake_case: start_time, end_time, etc.
            'Time$',     // camelCase: startTime, endTime, etc.
            '^time_',    // snake_case: time_started, time_ended, etc.
            '^time[A-Z]', // camelCase: timeStarted, timeEnded, etc.
        ];

        foreach ($patterns as $pattern) {
            if (preg_match("/{$pattern}/", $name)) {
                return true;
            }
        }

        return false;
    }

    protected function convertOpenApiTypeToPhp(Schema|Reference $schema): string
    {
        if ($schema instanceof Reference) {
            return Str::afterLast($schema->getReference(), '/');
        }

        if (is_array($schema->type)) {
            return collect($schema->type)->map(fn ($type) => $this->mapType($type))->implode('|');
        }

        return $this->mapType($schema->type, $schema->format);
    }

    protected function mapType(string $type, ?string $format = null): string
    {
        return match ($type) {
            'integer' => 'int',
            'string' => 'string',
            'boolean' => 'bool',
            'object' => 'object',
            'number' => match ($format) {
                'float' => 'float',
                'int32', 'int64' => 'int',
            },
            'array' => 'array',
            'null' => 'null',
        };
    }
}
