<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators\Traits;

use cebe\openapi\spec\Schema;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Illuminate\Support\Str;

trait TestDataGeneratorTrait
{
    /**
     * Generate a test/mock value based on property name and type information
     *
     * @param  string  $propertyName  The property name
     * @param  Schema|array|string|null  $typeInfo  Schema object, spec array, type string, or null
     * @return mixed Actual PHP value (string, int, bool, array, etc.)
     */
    protected function generateValue(string $propertyName, Schema|array|string|null $typeInfo = null): mixed
    {
        // Extract type and format from various input formats
        [$type, $format, $example] = $this->extractTypeInfo($typeInfo);

        // Use example if available
        if ($example !== null) {
            return $example;
        }

        // DateTime fields (by format or name)
        if ($format === 'date-time' || str_contains($propertyName, 'At') || str_contains($propertyName, 'Date')) {
            return '2025-01-15T10:30:00Z';
        }

        // ID fields
        if (str_ends_with($propertyName, 'Id')) {
            return Str::snake($propertyName).'-123';
        }

        // Email fields
        if (str_contains($propertyName, 'email') || str_contains($propertyName, 'Email')) {
            return 'test@example.com';
        }

        // Boolean fields (by type or name prefix)
        if ($type === 'boolean' || $type === 'bool' || str_starts_with($propertyName, 'is') || str_starts_with($propertyName, 'has')) {
            return true;
        }

        // Numeric fields
        if ($type === 'integer' || $type === 'int') {
            return 42;
        }

        if ($type === 'number' || $type === 'float') {
            return 3.14;
        }

        // Array/Object fields
        if ($type === 'array' || $type === 'object') {
            return [];
        }

        // Common string property names
        if ($type === 'string' || $type === null) {
            if ($propertyName === 'title') {
                return 'test title';
            }
            if ($propertyName === 'description') {
                return 'test description';
            }
            if ($propertyName === 'name') {
                return 'test name';
            }

            return 'test value';
        }

        return 'test value';
    }

    /**
     * Format a value as PHP code string for test generation
     *
     * @param  mixed  $value  The value to format
     * @return string PHP code representation
     */
    protected function formatAsCode(mixed $value): string
    {
        if (is_string($value)) {
            $escapedValue = addslashes($value);

            return "'{$escapedValue}'";
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        if (is_array($value)) {
            return '[]';
        }

        if (is_null($value)) {
            return 'null';
        }

        // Fallback
        return "'{$value}'";
    }

    /**
     * Format a value for use in assertions (alias for formatAsCode for backward compatibility)
     */
    protected function formatValueForAssertion(string $value): string
    {
        // If value is already quoted or a keyword, return as-is
        if (
            (str_starts_with($value, "'") && str_ends_with($value, "'")) ||
            $value === 'true' ||
            $value === 'false' ||
            is_numeric($value)
        ) {
            return $value;
        }

        // Wrap in quotes
        return "'{$value}'";
    }

    /**
     * Extract type, format, and example from various input formats
     *
     * @return array{0: ?string, 1: ?string, 2: mixed} [type, format, example]
     */
    private function extractTypeInfo(Schema|array|string|null $typeInfo): array
    {
        if ($typeInfo instanceof Schema) {
            return [
                $typeInfo->type ?? null,
                $typeInfo->format ?? null,
                $typeInfo->example ?? null,
            ];
        }

        if (is_array($typeInfo)) {
            return [
                $typeInfo['type'] ?? null,
                $typeInfo['format'] ?? null,
                $typeInfo['example'] ?? null,
            ];
        }

        if (is_string($typeInfo)) {
            // Normalize type name (remove nullable prefix)
            $normalizedType = ltrim($typeInfo, '?');

            // Check for DateTime type hints
            if (str_contains($normalizedType, 'Carbon') || str_contains($normalizedType, 'DateTime')) {
                return ['string', 'date-time', null];
            }

            return [$normalizedType, null, null];
        }

        return [null, null, null];
    }

    /**
     * Extract example data from OpenAPI spec for an endpoint
     */
    protected function extractExampleFromSpec(Endpoint $endpoint): ?array
    {
        $operation = $this->findOperationByEndpoint($endpoint);
        if (! $operation) {
            return null;
        }

        // Get the 200 response
        $response = $operation->responses['200'] ?? $operation->responses[200] ?? null;
        if (! $response) {
            return null;
        }

        // Get JSON content
        $mediaType = $response->content['application/json'] ?? null;
        if (! $mediaType) {
            return null;
        }

        // Try to find examples in this order:
        // 1. MediaType-level example
        if ($mediaType->example !== null) {
            return $mediaType->example;
        }

        // 2. MediaType-level examples array (use first one)
        if ($mediaType->examples && is_array($mediaType->examples)) {
            $firstExample = reset($mediaType->examples);
            if ($firstExample && isset($firstExample->value)) {
                return $firstExample->value;
            }
        }

        // 3. Schema-level example
        if ($mediaType->schema && $mediaType->schema->example !== null) {
            return $mediaType->schema->example;
        }

        return null;
    }

    /**
     * Generate mock attributes based on schema properties
     */
    protected function generateMockAttributes(Schema $schema): array
    {
        $attributes = [];

        // Extract the actual properties from the schema
        $properties = $this->extractPropertiesFromSchema($schema);

        if (empty($properties)) {
            return ['name' => 'Mock value'];
        }

        foreach ($properties as $propName => $propSchema) {
            $attributes[$propName] = $this->generateValue($propName, $propSchema);
        }

        return $attributes;
    }

    /**
     * Generate the complete mock response body for an endpoint
     */
    protected function generateMockResponseBody(Endpoint $endpoint): string
    {
        // Try to extract example from OpenAPI spec first
        $example = $this->extractExampleFromSpec($endpoint);

        if ($example !== null) {
            // Use example from spec
            $mockData = $example;
        } else {
            // Generate fallback mock data
            $mockData = $this->generateMockData($endpoint);
        }

        // Format as PHP array syntax for the stub
        return $this->formatArrayAsPhp($mockData);
    }

    /**
     * Format an array as PHP code string
     */
    protected function formatArrayAsPhp(array $data, int $indent = 0): string
    {
        $indentStr = str_repeat('    ', $indent);
        $lines = [];

        foreach ($data as $key => $value) {
            $keyStr = is_string($key) ? "'$key'" : $key;

            if (is_array($value)) {
                $lines[] = $indentStr."    $keyStr => ".$this->formatArrayAsPhp($value, $indent + 1).',';
            } elseif (is_string($value)) {
                $escapedValue = addslashes($value);
                $lines[] = $indentStr."    $keyStr => '$escapedValue',";
            } elseif (is_bool($value)) {
                $lines[] = $indentStr."    $keyStr => ".($value ? 'true' : 'false').',';
            } elseif (is_null($value)) {
                $lines[] = $indentStr."    $keyStr => null,";
            } else {
                $lines[] = $indentStr."    $keyStr => $value,";
            }
        }

        if (empty($lines)) {
            return '[]';
        }

        return "[\n".implode("\n", $lines)."\n$indentStr]";
    }
}
