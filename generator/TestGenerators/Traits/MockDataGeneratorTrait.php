<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators\Traits;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;

trait MockDataGeneratorTrait
{
    /**
     * Extract example data from OpenAPI spec for an endpoint
     */
    protected function extractExampleFromSpec(Endpoint $endpoint): ?array
    {
        $spec = $this->getOpenApiSpec();
        if (empty($spec)) {
            return null;
        }

        // Find the endpoint spec by operationId
        $endpointSpec = $this->findEndpointSpecByOperationId($endpoint->name);
        if (! $endpointSpec) {
            return null;
        }

        // Try to find examples in this order:
        // 1. Response-level example: responses.200.content.application/json.example
        if (isset($endpointSpec['responses']['200']['content']['application/json']['example'])) {
            return $endpointSpec['responses']['200']['content']['application/json']['example'];
        }

        // 2. Response-level examples array (use first one)
        if (isset($endpointSpec['responses']['200']['content']['application/json']['examples'])) {
            $examples = $endpointSpec['responses']['200']['content']['application/json']['examples'];
            $firstExample = reset($examples);
            if (isset($firstExample['value'])) {
                return $firstExample['value'];
            }
        }

        // 3. Schema-level example
        if (isset($endpointSpec['responses']['200']['content']['application/json']['schema'])) {
            $schema = $endpointSpec['responses']['200']['content']['application/json']['schema'];

            // Check for direct example
            if (isset($schema['example'])) {
                return $schema['example'];
            }

            // Check if schema references a component
            if (isset($schema['$ref'])) {
                $schema = $this->resolveSchemaReference($schema['$ref']);

                // Check for example in referenced schema
                if (isset($schema['example'])) {
                    return $schema['example'];
                }
            }
        }

        return null;
    }

    /**
     * Generate mock attributes based on schema properties
     */
    protected function generateMockAttributes(array $schema): array
    {
        $attributes = [];

        // Check if this is a JSON:API schema with attributes object
        if (isset($schema['properties']['attributes']['properties'])) {
            $properties = $schema['properties']['attributes']['properties'];
        } elseif (isset($schema['properties'])) {
            $properties = $schema['properties'];
        } else {
            return ['name' => 'Mock value'];
        }

        foreach ($properties as $propName => $propSpec) {
            // Skip non-attribute fields
            if (in_array($propName, ['id', 'type', 'attributes', 'relationships'])) {
                continue;
            }

            $attributes[$propName] = $this->getMockValueForProperty($propName, $propSpec);
        }

        return $attributes;
    }

    /**
     * Generate a mock value based on property name and type
     */
    protected function getMockValueForProperty(string $propertyName, array $propertySpec): mixed
    {
        // Check for example in property spec
        if (isset($propertySpec['example'])) {
            return $propertySpec['example'];
        }

        $type = $propertySpec['type'] ?? 'string';
        $format = $propertySpec['format'] ?? null;

        // DateTime fields
        if ($format === 'date-time' || str_contains($propertyName, 'At') || str_contains($propertyName, 'Date')) {
            return '2025-01-15T10:30:00Z';
        }

        // ID fields
        if (str_ends_with($propertyName, 'Id')) {
            return 'mock-id-123';
        }

        // Email fields
        if (str_contains($propertyName, 'email') || str_contains($propertyName, 'Email')) {
            return 'test@example.com';
        }

        // Type-based generation
        return match ($type) {
            'boolean' => true,
            'integer', 'number' => 42,
            'string' => 'Mock value',
            'array' => [],
            'object' => [],
            default => 'Mock value',
        };
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
