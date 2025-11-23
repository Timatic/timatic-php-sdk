<?php

namespace Timatic\SDK\Generator\TestGenerators\Traits;

use Crescat\SaloonSdkGenerator\Data\Generator\GeneratedCode;

trait DtoAssertions
{
    /**
     * The GeneratedCode instance (must be provided by the class using this trait)
     */
    protected GeneratedCode $generatedCode;

    /**
     * Generate DTO assertions based on the DTO class from generatedCode
     */
    protected function generateDtoAssertions(array $mockData): string
    {
        // Get attributes from the mock data
        $attributes = $mockData['data'][0]['attributes'] ?? $mockData['data']['attributes'] ?? [];

        if (empty($attributes)) {
            return '        // No attributes to validate';
        }

        $assertions = [];

        foreach ($attributes as $key => $value) {
            // Skip arrays completely
            if (is_array($value)) {
                continue;
            }

            $assertion = $this->generateAssertionForValue($key, $value);
            $assertions[] = $assertion;
        }

        // If no valid assertions after filtering, return comment
        if (empty($assertions)) {
            return '        // No simple attributes to validate (arrays skipped)';
        }

        return implode("\n", $assertions);
    }

    /**
     * Get DTO properties from generated code
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
     * Generate mock attributes from DTO properties
     */
    protected function generateMockAttributesFromDto(string $dtoClassName): array
    {
        $properties = $this->getDtoPropertiesFromGeneratedCode($dtoClassName);

        if (empty($properties)) {
            return ['name' => 'Mock value'];
        }

        $attributes = [];

        foreach ($properties as $propInfo) {
            $propName = $propInfo['name'];

            // Skip ID and timestamps - these are typically read-only
            if (in_array($propName, ['id', 'createdAt', 'updatedAt', 'deletedAt'])) {
                continue;
            }

            $attributes[$propName] = $this->generateMockValueForDtoProperty($propName, $propInfo['type']);
        }

        return $attributes;
    }

    /**
     * Generate a mock value for a DTO property based on its type
     */
    protected function generateMockValueForDtoProperty(string $propertyName, string $typeName): mixed
    {
        // Normalize type name (remove nullable prefix)
        $typeName = ltrim($typeName, '?');

        // DateTime fields
        if (str_contains($typeName, 'Carbon') || str_contains($typeName, 'DateTime')) {
            return '2025-11-22T10:40:04.065Z';
        }

        // Type-based generation (handle explicit types first)
        if ($typeName === 'bool') {
            return true;
        }

        if ($typeName === 'int') {
            return 42;
        }

        if ($typeName === 'float') {
            return 3.14;
        }

        if ($typeName === 'array') {
            return [];
        }

        // String type - apply name-based heuristics
        if ($typeName === 'string') {
            // ID fields
            if (str_ends_with($propertyName, 'Id')) {
                return 'mock-id-123';
            }

            // Email fields
            if (str_contains($propertyName, 'email') || str_contains($propertyName, 'Email')) {
                return 'test@example.com';
            }

            return 'Mock value';
        }

        // This should never be reached with the current OpenAPI spec
        throw new \RuntimeException("Unexpected type '{$typeName}' for property '{$propertyName}'");
    }

    /**
     * Generate an assertion for a specific attribute value
     */
    protected function generateAssertionForValue(string $key, mixed $value): string
    {
        // Handle different value types
        if (is_bool($value)) {
            $expected = $value ? 'true' : 'false';

            return "        ->{$key}->toBe({$expected})";
        }

        if (is_int($value)) {
            return "        ->{$key}->toBe({$value})";
        }

        if (is_null($value)) {
            return "        ->{$key}->toBeNull()";
        }

        // Check if it's a datetime string
        if (is_string($value) && $this->isDateTimeString($value)) {
            return "        ->{$key}->toEqual(new Carbon(\"{$value}\"))";
        }

        // Default: string value
        $escapedValue = addslashes($value);

        return "        ->{$key}->toBe(\"{$escapedValue}\")";
    }

    /**
     * Check if a string is a datetime format
     */
    protected function isDateTimeString(string $value): bool
    {
        // Check for ISO 8601 format (e.g., 2025-11-22T10:40:04.065Z)
        return (bool) preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/', $value);
    }
}
