<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators;

use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\GeneratedCode;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Timatic\SDK\Generator\TestGenerators\Traits\MockDataGeneratorTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\SchemaExtractorTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\TestValueGeneratorTrait;

class CollectionRequestTestGenerator
{
    use MockDataGeneratorTrait;
    use SchemaExtractorTrait;
    use TestValueGeneratorTrait;

    protected ApiSpecification $specification;

    protected GeneratedCode $generatedCode;

    public function __construct(ApiSpecification $specification, GeneratedCode $generatedCode)
    {
        $this->specification = $specification;
        $this->generatedCode = $generatedCode;
    }

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
        return __DIR__.'/stubs/pest-collection-request-test-func.stub';
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

        // Replace fixture with inline mock data
        $mockResponseBody = $this->generateMockResponseBody($endpoint);
        $functionStub = preg_replace(
            "/MockResponse::fixture\('[^']+'\)/",
            "MockResponse::make($mockResponseBody, 200)",
            $functionStub
        );

        return $functionStub;
    }

    /**
     * Generate mock data for collection response
     */
    protected function generateMockData(Endpoint $endpoint): array
    {
        // Try to determine the schema for this endpoint
        $schema = $this->getResponseSchemaForEndpoint($endpoint);

        if ($schema) {
            // Generate mock data based on schema
            $attributes = $this->generateMockAttributes($schema);
            $resourceType = $this->getResourceTypeFromSchema($schema);

            // Generate 2-3 items for collections
            return [
                'data' => [
                    [
                        'type' => $resourceType,
                        'id' => 'mock-id-1',
                        'attributes' => $attributes,
                    ],
                    [
                        'type' => $resourceType,
                        'id' => 'mock-id-2',
                        'attributes' => $this->generateMockAttributes($schema),
                    ],
                ],
            ];
        }

        // Fallback: generic mock data
        $resourceName = NameHelper::resourceClassName($endpoint->collection);
        $resourceType = NameHelper::safeVariableName($resourceName);

        return [
            'data' => [
                ['type' => $resourceType, 'id' => 'mock-id-1', 'attributes' => ['name' => 'Mock item 1']],
                ['type' => $resourceType, 'id' => 'mock-id-2', 'attributes' => ['name' => 'Mock item 2']],
            ],
        ];
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
}
