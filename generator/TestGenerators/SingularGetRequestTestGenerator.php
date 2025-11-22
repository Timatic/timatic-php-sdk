<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators;

use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\GeneratedCode;
use Timatic\SDK\Generator\TestGenerators\Traits\MockDataGeneratorTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\SchemaExtractorTrait;

class SingularGetRequestTestGenerator
{
    use MockDataGeneratorTrait;
    use SchemaExtractorTrait;

    protected ApiSpecification $specification;

    protected GeneratedCode $generatedCode;

    public function __construct(ApiSpecification $specification, GeneratedCode $generatedCode)
    {
        $this->specification = $specification;
        $this->generatedCode = $generatedCode;
    }

    /**
     * Check if endpoint is a singular GET request (GET with path parameters)
     */
    public function isSingularGetRequest(Endpoint $endpoint): bool
    {
        // GET requests WITH path parameters are singular GET requests
        return $endpoint->method->isGet() && ! empty($endpoint->pathParameters);
    }

    /**
     * Get the stub path for singular GET request tests
     */
    public function getStubPath(): string
    {
        return __DIR__.'/stubs/pest-singular-get-request-test-func.stub';
    }

    /**
     * Replace stub variables with singular GET-specific content
     */
    public function replaceStubVariables(string $functionStub, Endpoint $endpoint): string
    {
        // Generate mock response body
        $mockResponseBody = $this->generateMockResponseBody($endpoint);
        $functionStub = str_replace(
            '{{ mockResponse }}',
            "MockResponse::make($mockResponseBody, 200)",
            $functionStub
        );

        return $functionStub;
    }

    /**
     * Generate mock data for singular GET response
     */
    protected function generateMockData(Endpoint $endpoint): array
    {
        // Try to determine the schema for this endpoint
        $schema = $this->getResponseSchemaForEndpoint($endpoint);

        if (! $schema) {
            throw new \Exception('schema operation not found');
        }

        // Generate mock data based on schema
        $attributes = $this->generateMockAttributes($schema);
        $resourceType = $this->getResourceTypeFromSchema($schema);

        return [
            'data' => [
                'type' => $resourceType,
                'id' => 'mock-id-123',
                'attributes' => $attributes,
            ],
        ];
    }
}
