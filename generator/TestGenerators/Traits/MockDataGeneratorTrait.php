<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators\Traits;

use cebe\openapi\spec\Schema;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;

trait MockDataGeneratorTrait
{
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
            $attributes[$propName] = $this->getMockValueForPropertySchema($propName, $propSchema);
        }

        return $attributes;
    }

    /**
     * Generate a mock value based on property name and Schema
     */
    protected function getMockValueForPropertySchema(string $propertyName, Schema $propertySchema): mixed
    {
        // Check for example in property schema
        if ($propertySchema->example !== null) {
            return $propertySchema->example;
        }

        $type = $propertySchema->type ?? 'string';
        $format = $propertySchema->format ?? null;

        // DateTime fields
        if ($format === 'date-time' || str_contains($propertyName, 'At') || str_contains($propertyName, 'Date')) {
            return '2025-01-15T10:30:00Z';
        }

        // Type-based generation (handle explicit types first)
        if ($type === 'boolean') {
            return true;
        }

        if ($type === 'integer' || $type === 'number') {
            return 42;
        }

        if ($type === 'array') {
            return [];
        }

        if ($type === 'object') {
            return [];
        }

        // String type - apply name-based heuristics
        if ($type === 'string') {
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

        return 'Mock value';
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
