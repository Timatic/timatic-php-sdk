<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators\Traits;

trait TestValueGeneratorTrait
{
    /**
     * Generate appropriate test value based on property name and spec
     */
    protected function generateTestValueForProperty(string $property, array $spec = []): string
    {
        // Check for example in spec
        if (isset($spec['example'])) {
            $value = $spec['example'];
            if (is_string($value)) {
                return "'{$value}'";
            }
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            if (is_numeric($value)) {
                return (string) $value;
            }
        }

        $type = $spec['type'] ?? 'string';
        $format = $spec['format'] ?? null;

        // DateTime fields
        if ($format === 'date-time' || str_contains($property, 'At') || str_contains($property, 'Date')) {
            return "'2025-01-01T10:00:00Z'";
        }

        // ID properties
        if (str_ends_with($property, 'Id')) {
            return "'test-id-123'";
        }

        // Boolean properties
        if ($type === 'boolean' || str_starts_with($property, 'is') || str_starts_with($property, 'has')) {
            return 'false';
        }

        // Numeric properties
        if ($type === 'integer' || $type === 'number') {
            return '123';
        }

        // String properties with common names
        if ($property === 'title') {
            return "'test title'";
        }
        if ($property === 'description') {
            return "'test description'";
        }
        if ($property === 'name') {
            return "'test name'";
        }

        // Default to string
        return "'test value'";
    }

    /**
     * Format a value for use in assertions
     */
    protected function formatValueForAssertion(string $value): string
    {
        // If value is already quoted, return as-is
        if (str_starts_with($value, "'") && str_ends_with($value, "'")) {
            return $value;
        }

        // Boolean values
        if ($value === 'true' || $value === 'false') {
            return $value;
        }

        // Numeric values
        if (is_numeric($value)) {
            return $value;
        }

        // Wrap in quotes
        return "'{$value}'";
    }
}
