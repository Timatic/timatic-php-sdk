<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators;

use cebe\openapi\spec\Schema;
use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\GeneratedCode;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Illuminate\Support\Str;
use Timatic\SDK\Generator\TestGenerators\Traits\SchemaExtractorTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\TestDataGeneratorTrait;

class MutationRequestTestGenerator
{
    use SchemaExtractorTrait;
    use TestDataGeneratorTrait;

    protected ApiSpecification $specification;

    protected GeneratedCode $generatedCode;

    public function __construct(ApiSpecification $specification, GeneratedCode $generatedCode)
    {
        $this->specification = $specification;
        $this->generatedCode = $generatedCode;
    }

    /**
     * Check if endpoint is a mutation request (POST or PATCH)
     */
    public function isMutationRequest(Endpoint $endpoint): bool
    {
        return $endpoint->method->isPost() || $endpoint->method->isPatch();
    }

    /**
     * Get the stub path for mutation request tests
     */
    public function getStubPath(): string
    {
        return __DIR__.'/stubs/pest-mutation-test-func.stub';
    }

    /**
     * Replace stub variables with mutation-specific content
     */
    public function replaceStubVariables(string $functionStub, Endpoint $endpoint): string
    {
        // Generate DTO instantiation code
        $dtoInstantiation = $this->generateDtoInstantiation($endpoint);
        $functionStub = str_replace('{{ dtoInstantiation }}', $dtoInstantiation, $functionStub);

        // Generate body validation code
        $bodyValidation = $this->generateBodyValidation($endpoint);
        $functionStub = str_replace('{{ bodyValidation }}', $bodyValidation, $functionStub);

        // Generate method arguments (including $dto)
        $methodArguments = $this->generateMethodArguments($endpoint);
        $functionStub = str_replace('{{ mutationMethodArguments }}', $methodArguments, $functionStub);

        return $functionStub;
    }

    /**
     * Generate method arguments for resource method call
     */
    protected function generateMethodArguments(Endpoint $endpoint): string
    {
        $args = [];

        // Add path parameters first (e.g., budgetId for PATCH)
        foreach ($endpoint->pathParameters as $param) {
            $paramName = NameHelper::safeVariableName($param->name);
            // Add 'Id' suffix if not already present
            if (! str_ends_with($paramName, 'Id')) {
                $paramName .= 'Id';
            }
            $args[] = "{$paramName}: 'test string'";
        }

        // Add $dto parameter last - use named argument if there are path params
        if (empty($endpoint->pathParameters)) {
            $args[] = '$dto';
        } else {
            $args[] = 'data: $dto';
        }

        return implode(', ', $args);
    }

    /**
     * Generate DTO instantiation code with sample data
     */
    protected function generateDtoInstantiation(Endpoint $endpoint): string
    {
        $dtoClassName = $this->getDtoClassName($endpoint);
        $properties = $this->generateDtoProperties($endpoint);

        $lines = [];
        $lines[] = "    \$dto = new \\Timatic\\SDK\\Dto\\{$dtoClassName};";
        $lines[] = $properties;
        $lines[] = '    // todo: add every other DTO field';

        return implode("\n", $lines);
    }

    /**
     * Generate DTO property assignments
     */
    protected function generateDtoProperties(Endpoint $endpoint): string
    {
        $dtoClassName = $this->getDtoClassName($endpoint);
        $properties = $this->getDtoPropertiesFromGeneratedCode($dtoClassName);

        if (empty($properties)) {
            return "    \$dto->name = 'test value';";
        }

        $lines = [];

        // Limit to first 4 properties for the test, skip timestamp fields
        $count = 0;
        foreach ($properties as $propInfo) {
            if ($count >= 4) {
                break;
            }

            $propName = $propInfo['name'];

            // Skip read-only/auto-managed fields
            if (in_array($propName, ['id', 'createdAt', 'updatedAt', 'deletedAt'])) {
                continue;
            }

            $value = $this->formatAsCode($this->generateValue($propName, $propInfo['type']));
            $lines[] = "    \$dto->{$propName} = {$value};";
            $count++;
        }

        // Fallback if no properties after filtering
        if (empty($lines)) {
            return "    \$dto->name = 'test value';";
        }

        return implode("\n", $lines);
    }

    /**
     * Get DTO properties from generated code (PhpFile objects)
     *
     * @return array<string, array{name: string, type: ?string}>
     */
    protected function getDtoPropertiesFromGeneratedCode(string $dtoClassName): array
    {
        // Check if DTO exists in generated code
        if (! isset($this->generatedCode->dtoClasses[$dtoClassName])) {
            return [];
        }

        $phpFile = $this->generatedCode->dtoClasses[$dtoClassName];
        $properties = [];

        // Get the first namespace in the file
        $namespace = array_values($phpFile->getNamespaces())[0] ?? null;
        if (! $namespace) {
            return [];
        }

        // Get the first class in the namespace
        $classType = array_values($namespace->getClasses())[0] ?? null;
        if (! $classType) {
            return [];
        }

        // Extract properties from the class
        foreach ($classType->getProperties() as $property) {
            // Skip static properties
            if ($property->isStatic()) {
                continue;
            }

            $type = $property->getType();
            $typeName = null;

            if ($type) {
                $typeName = (string) $type;
            }

            $properties[$property->getName()] = [
                'name' => $property->getName(),
                'type' => $typeName,
            ];
        }

        return $properties;
    }

    /**
     * Generate body validation code
     */
    protected function generateBodyValidation(Endpoint $endpoint): string
    {
        $resourceType = $this->getResourceTypeFromEndpoint($endpoint);
        $dtoClassName = $this->getDtoClassName($endpoint);
        $properties = $this->getDtoPropertiesFromGeneratedCode($dtoClassName);

        if (empty($properties)) {
            return $this->generateFallbackBodyValidation($resourceType, $endpoint);
        }

        $lines = [];

        $lines[] = '    $mockClient->assertSent(function (Request $request) {';
        $lines[] = '        expect($request->body()->all())';
        $lines[] = "            ->toHaveKey('data')";

        // POST calls don't have an ID field in the request
        if ($endpoint->method->isPost()) {
            $lines[] = '            // POST calls dont have an ID field';
        }

        // Generate attribute validations
        $attributeValidations = $this->generateAttributeValidationsFromDto($properties);
        if ($attributeValidations) {
            $lines[] = "            ->data->type->toBe('{$resourceType}')";
            $lines[] = '            ->data->attributes->scoped(fn ($attributes) => $attributes';
            $lines[] = $attributeValidations;
            $lines[] = '            );';
        } else {
            // No attributes to validate, just close the chain
            $lines[] = "            ->data->type->toBe('{$resourceType}');";
        }

        $lines[] = '';
        $lines[] = '        return true;';
        $lines[] = '    });';

        return implode("\n", $lines);
    }

    /**
     * Generate attribute validation chain from DTO properties
     *
     * @param  array<string, array{name: string, type: ?string}>  $properties
     */
    protected function generateAttributeValidationsFromDto(array $properties): string
    {
        $lines = [];

        // Limit to first 4 properties for the test, skip timestamp fields
        $count = 0;
        foreach ($properties as $propInfo) {
            if ($count >= 4) {
                break;
            }

            $propName = $propInfo['name'];

            // Skip read-only/auto-managed fields
            if (in_array($propName, ['id', 'createdAt', 'updatedAt', 'deletedAt'])) {
                continue;
            }

            $value = $this->formatAsCode($this->generateValue($propName, $propInfo['type']));
            $assertionValue = $this->formatValueForAssertion($value);
            $lines[] = "                ->{$propName}->toBe({$assertionValue})";
            $count++;
        }

        return implode("\n", $lines);
    }

    /**
     * Get the DTO class name for an endpoint
     */
    protected function getDtoClassName(Endpoint $endpoint): string
    {
        // Try to extract from endpoint collection name
        if ($endpoint->collection) {
            $resourceName = NameHelper::resourceClassName($endpoint->collection);

            // Use Laravel's Str::singular() for correct singular form
            return Str::singular($resourceName);
        }

        // Fallback: try to parse from endpoint name
        $name = $endpoint->name ?: NameHelper::pathBasedName($endpoint);
        // Remove method prefix (post, patch)
        $name = preg_replace('/^(post|patch)/i', '', $name);

        // Use Laravel's Str::singular() for correct singular form
        return Str::singular(NameHelper::resourceClassName($name));
    }

    /**
     * Generate fallback body validation when schema is not available
     */
    protected function generateFallbackBodyValidation(string $resourceType, Endpoint $endpoint): string
    {
        $lines = [];
        $lines[] = '    $mockClient->assertSent(function (Request $request) {';
        $lines[] = '        expect($request->body()->all())';
        $lines[] = "            ->toHaveKey('data')";

        if ($endpoint->method->isPost()) {
            $lines[] = '            // POST calls dont have an ID field';
        }

        $lines[] = "            ->data->type->toBe('{$resourceType}')";
        $lines[] = '            ->data->attributes->scoped(fn ($attributes) => $attributes';
        $lines[] = "                ->name->toBe('test value')";
        $lines[] = '            );';
        $lines[] = '';
        $lines[] = '        return true;';
        $lines[] = '    });';

        return implode("\n", $lines);
    }
}
