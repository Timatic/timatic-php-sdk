<?php

declare(strict_types=1);

namespace Timatic\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Generator;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use ReflectionClass;
use Timatic\Factories\Factory;
use Timatic\Hydration\Attributes\DateTime;

class JsonApiFactoryGenerator extends Generator
{
    protected array $generated = [];

    public function generate(ApiSpecification $specification): PhpFile|array
    {
        if ($specification->components) {
            foreach ($specification->components->schemas as $className => $schema) {
                $dtoClassName = NameHelper::dtoClassName(NameHelper::safeClassName($className));
                $this->generateFactoryClass($dtoClassName);
            }
        }

        return $this->generated;
    }

    protected function generateFactoryClass(string $dtoClassName): PhpFile
    {
        $factoryName = $dtoClassName.'Factory';

        $classType = new ClassType($factoryName);
        $classFile = new PhpFile;
        $namespace = $classFile->addNamespace("{$this->config->namespace}\\Factories");

        // Extend base Factory
        $classType->setExtends(Factory::class);

        // Add imports
        $namespace->addUse(Factory::class);
        $dtoFullClass = "{$this->config->namespace}\\{$this->config->dtoNamespaceSuffix}\\{$dtoClassName}";
        $namespace->addUse($dtoFullClass);

        // Get DTO properties
        $properties = $this->getDtoProperties($dtoFullClass);

        // Add definition() method
        $definitionMethod = $classType->addMethod('definition')
            ->setReturnType('array')
            ->setProtected();

        $definitionBody = $this->generateDefinitionBody($properties, $namespace);
        $definitionMethod->setBody($definitionBody);

        // Add modelClass() method
        $modelClassMethod = $classType->addMethod('modelClass')
            ->setReturnType('string')
            ->setProtected();

        $modelClassMethod->setBody("return {$dtoClassName}::class;");

        $namespace->add($classType);

        $this->generated[$factoryName] = $classFile;

        return $classFile;
    }

    /**
     * Get DTO properties using reflection
     *
     * @return array<array{name: string, type: ?string, isDateTime: bool}>
     */
    protected function getDtoProperties(string $dtoFullClass): array
    {
        if (! class_exists($dtoFullClass)) {
            return [];
        }

        $reflection = new ReflectionClass($dtoFullClass);
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            // Skip 'id' and 'type' properties from Model base class
            if (in_array($property->getName(), ['id', 'type'])) {
                continue;
            }

            // Skip static and private properties
            if ($property->isStatic() || $property->isPrivate()) {
                continue;
            }

            // Check if property has DateTime attribute
            $isDateTime = ! empty($property->getAttributes(DateTime::class));

            // Get property type
            $type = $property->getType();
            $typeName = null;
            if ($type) {
                $typeName = $type instanceof \ReflectionNamedType ? $type->getName() : (string) $type;
            }

            $properties[] = [
                'name' => $property->getName(),
                'type' => $typeName,
                'isDateTime' => $isDateTime,
            ];
        }

        return $properties;
    }

    /**
     * Generate the body of the definition() method
     */
    protected function generateDefinitionBody(array $properties, $namespace): string
    {
        $lines = ['return ['];

        foreach ($properties as $property) {
            $propertyName = $property['name'];
            $fakerCall = $this->generateFakerCall($propertyName, $property['type'], $property['isDateTime']);

            $lines[] = "    '{$propertyName}' => {$fakerCall},";
        }

        $lines[] = '];';

        // Add Carbon import if we have datetime properties
        $hasDateTime = collect($properties)->contains('isDateTime', true);
        if ($hasDateTime) {
            $namespace->addUse('Carbon\\Carbon');
        }

        return implode("\n", $lines);
    }

    /**
     * Generate appropriate Faker call for a property
     */
    protected function generateFakerCall(string $propertyName, ?string $propertyType, bool $isDateTime): string
    {
        $lowerName = strtolower($propertyName);

        // Handle DateTime properties
        if ($isDateTime || $propertyType === 'Carbon\\Carbon') {
            return 'Carbon::now()->subDays($this->faker->numberBetween(0, 365))';
        }

        // Handle specific property names (case-insensitive)
        if (str_contains($lowerName, 'email')) {
            return '$this->faker->safeEmail()';
        }

        if (str_ends_with($propertyName, 'Id') || str_ends_with($lowerName, '_id')) {
            return '$this->faker->uuid()';
        }

        if ($lowerName === 'hourlyrate' || $lowerName === 'hourly_rate' || str_contains($lowerName, 'rate')) {
            return "number_format(\$this->faker->randomFloat(2, 50, 150), 2, '.', '')";
        }

        if (str_contains($lowerName, 'description')) {
            return '$this->faker->sentence()';
        }

        if (str_contains($lowerName, 'title')) {
            return '$this->faker->sentence()';
        }

        // Handle by property type
        if ($propertyType) {
            $baseType = ltrim($propertyType, '?\\');

            if ($baseType === 'bool' || $baseType === 'boolean') {
                return '$this->faker->boolean()';
            }

            if ($baseType === 'int' || $baseType === 'integer') {
                // Special cases for specific property names
                if (str_contains($lowerName, 'minute')) {
                    return '$this->faker->numberBetween(15, 480)';
                }

                return '$this->faker->numberBetween(1, 100)';
            }

            if ($baseType === 'float' || $baseType === 'double') {
                return '$this->faker->randomFloat(2, 1, 1000)';
            }
        }

        // Handle by property name patterns
        if (str_ends_with($propertyName, 'Name') && ! str_starts_with($lowerName, 'user')) {
            return '$this->faker->company()';
        }

        if (str_contains($lowerName, 'name')) {
            return '$this->faker->name()';
        }

        if (str_contains($lowerName, 'number')) {
            return '$this->faker->word()';
        }

        // Default to word for strings
        return '$this->faker->word()';
    }
}
