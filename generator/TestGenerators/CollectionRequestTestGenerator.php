<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;

class CollectionRequestTestGenerator
{
    /**
     * Check if endpoint is a GET collection request (implements Paginatable)
     */
    public function isCollectionRequest(Endpoint $endpoint): bool
    {
        // GET requests without path parameters are collection requests
        return $endpoint->method->isGet() && empty($endpoint->pathParameters);
    }

    /**
     * Get the stub path for collection request tests
     */
    public function getStubPath(): string
    {
        return __DIR__.'/stubs/pest-fluent-filter-test-func.stub';
    }

    /**
     * Replace stub variables with collection-specific content
     */
    public function replaceStubVariables(string $functionStub, Endpoint $endpoint): string
    {
        $filterData = $this->generateFilterChainWithData($endpoint);
        $functionStub = str_replace('{{ filterChain }}', $filterData['chain'], $functionStub);

        // Only include filter assertions block if there are filters
        if (! empty($filterData['assertions'])) {
            $filterAssertionBlock = $this->generateFilterAssertionBlock($filterData['assertions']);
            $functionStub = str_replace('{{ filterAssertionBlock }}', $filterAssertionBlock, $functionStub);
        } else {
            $functionStub = str_replace('{{ filterAssertionBlock }}', '', $functionStub);
        }

        // Add non-filter query parameters (like 'include')
        $nonFilterParams = $this->getNonFilterQueryParameters($endpoint);
        $functionStub = str_replace('{{ nonFilterParams }}', $nonFilterParams, $functionStub);

        return $functionStub;
    }

    /**
     * Generate the complete filter assertion block
     */
    protected function generateFilterAssertionBlock(string $assertions): string
    {
        $stub = file_get_contents(__DIR__.'/stubs/pest-filter-assertion-block.stub');

        return str_replace('{{ filterAssertions }}', $assertions, $stub);
    }

    /**
     * Generate a fluent filter chain with 2-3 representative examples and their assertions
     */
    protected function generateFilterChainWithData(Endpoint $endpoint): array
    {
        $filters = [];
        $assertions = [];
        $maxFilters = 3;
        $seenProperties = [];

        // Extract filter parameters from query parameters
        foreach ($endpoint->queryParameters as $parameter) {
            if (count($filters) >= $maxFilters) {
                break;
            }

            // Skip non-filter parameters
            if (! str_starts_with($parameter->name, 'filter[')) {
                continue;
            }

            // Parse filter[property][operator] or filter[property]
            preg_match('/filter\[([^\]]+)\](?:\[([^\]]+)\])?/', $parameter->name, $matches);
            $property = $matches[1] ?? null;
            $operator = $matches[2] ?? null;

            if (! $property) {
                continue;
            }

            // Skip if we already have a filter for this property (avoid duplicates with operators)
            if (isset($seenProperties[$property])) {
                continue;
            }

            // Only add filters without operators (simpler)
            if (! $operator && count($filters) < $maxFilters) {
                $value = $this->generateTestValueForProperty($property);
                $filters[] = "->filter('{$property}', {$value})";

                // Generate assertion for this filter
                $assertions[] = $this->generateFilterAssertion($property, $value);

                $seenProperties[$property] = true;
            }
        }

        return [
            'chain' => implode("\n\t\t", $filters),
            'assertions' => implode("\n\t\t", $assertions),
        ];
    }

    /**
     * Generate a filter assertion for the given property and value
     */
    protected function generateFilterAssertion(string $property, string $value): string
    {
        // Handle both string and boolean values
        if ($value === 'true' || $value === 'false') {
            // Boolean values
            return "expect(\$query)->toHaveKey('filter[{$property}]', {$value});";
        }

        // String values - remove quotes for the assertion
        $assertionValue = trim($value, "'");

        return "expect(\$query)->toHaveKey('filter[{$property}]', '{$assertionValue}');";
    }

    /**
     * Get non-filter query parameters (like 'include')
     */
    protected function getNonFilterQueryParameters(Endpoint $endpoint): string
    {
        $params = [];

        foreach ($endpoint->queryParameters as $parameter) {
            if (! str_starts_with($parameter->name, 'filter[')) {
                $paramName = NameHelper::safeVariableName($parameter->name);
                $value = match ($parameter->type) {
                    'string' => "'test string'",
                    'int', 'integer' => '123',
                    'bool', 'boolean' => 'true',
                    'array' => '[]',
                    default => 'null',
                };
                $params[] = "{$paramName}: {$value}";
            }
        }

        return implode(', ', $params);
    }

    /**
     * Generate appropriate test value based on property name
     */
    protected function generateTestValueForProperty(string $property): string
    {
        // Date/time properties
        if (str_contains($property, 'At') || str_contains($property, 'Date')) {
            return "'2025-01-01'";
        }

        // ID properties
        if (str_ends_with($property, 'Id')) {
            return "'test-id-123'";
        }

        // Boolean properties
        if (str_starts_with($property, 'is') || str_starts_with($property, 'has')) {
            return 'true';
        }

        // Default to string
        return "'test-value'";
    }
}
