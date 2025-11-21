<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\Parameter;
use Crescat\SaloonSdkGenerator\Generators\PestTestGenerator;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;

class JsonApiPestTestGenerator extends PestTestGenerator
{
    protected CollectionRequestTestGenerator $collectionTestGenerator;

    protected MutationRequestTestGenerator $mutationTestGenerator;

    protected ?array $openApiSpec = null;

    public function __construct()
    {
        $this->collectionTestGenerator = new CollectionRequestTestGenerator;
        $this->mutationTestGenerator = new MutationRequestTestGenerator;
    }

    /**
     * Load and cache the OpenAPI specification
     */
    protected function getOpenApiSpec(): array
    {
        if ($this->openApiSpec === null) {
            $specPath = __DIR__.'/../openapi.json';
            if (file_exists($specPath)) {
                $this->openApiSpec = json_decode(file_get_contents($specPath), true);
            } else {
                $this->openApiSpec = [];
            }
        }

        return $this->openApiSpec;
    }

    /**
     * Skip generating Pest.php - we have a custom version
     */
    protected function shouldGeneratePestFile(): bool
    {
        return false;
    }

    /**
     * Skip generating TestCase.php - we have a custom version
     */
    protected function shouldGenerateTestCaseFile(): bool
    {
        return false;
    }

    /**
     * Filter out PUT requests - not supported in JSON:API
     */
    protected function shouldIncludeEndpoint(Endpoint $endpoint): bool
    {
        return ! $endpoint->method->isPut();
    }

    /**
     * Use our custom JSON:API test stub
     */
    protected function getTestStubPath(): string
    {
        return __DIR__.'/stubs/pest-resource-test.stub';
    }

    /**
     * Use our custom JSON:API test function stub
     */
    protected function getTestFunctionStubPath(Endpoint $endpoint): string
    {
        // Delegate to CollectionRequestTestGenerator for collection requests
        if ($this->collectionTestGenerator->isCollectionRequest($endpoint)) {
            return $this->collectionTestGenerator->getStubPath();
        }

        // Delegate to MutationRequestTestGenerator for mutation requests
        if ($this->mutationTestGenerator->isMutationRequest($endpoint)) {
            return $this->mutationTestGenerator->getStubPath();
        }

        return __DIR__.'/stubs/pest-resource-test-func.stub';
    }

    /**
     * Add "Request" suffix to match JsonApiRequestGenerator behavior
     */
    protected function getRequestClassName(Endpoint $endpoint): string
    {
        $className = NameHelper::requestClassName($endpoint->name ?: NameHelper::pathBasedName($endpoint));

        if (! str_ends_with($className, 'Request')) {
            $className .= 'Request';
        }

        return $className;
    }

    protected function getMethodName(Endpoint $endpoint, string $requestClassName): string
    {
        // Strip "Request" suffix if present to match actual Resource method names
        $methodBaseName = str_ends_with($requestClassName, 'Request')
            ? substr($requestClassName, 0, -7)
            : $requestClassName;

        return NameHelper::safeVariableName($methodBaseName);
    }

    /**
     * Place tests in tests/Requests/ directory
     */
    protected function getTestPath(string $resourceName): string
    {
        return "tests/Requests/{$resourceName}Test.php";
    }

    /**
     * Hook: Transform path parameter names (e.g., budget -> budgetId)
     */
    protected function getTestParameterName(Parameter $parameter, Endpoint $endpoint): string
    {
        $name = parent::getTestParameterName($parameter, $endpoint);

        // Check if this is a path parameter
        if (in_array($parameter, $endpoint->pathParameters, true)) {
            return $name.'Id';
        }

        return $name;
    }

    /**
     * Hook: Replace additional stub variables
     */
    protected function replaceAdditionalStubVariables(
        string $functionStub,
        Endpoint $endpoint,
        string $resourceName,
        string $requestClassName
    ): string {
        // Delegate to CollectionRequestTestGenerator for collection requests
        if ($this->collectionTestGenerator->isCollectionRequest($endpoint)) {
            $functionStub = $this->collectionTestGenerator->replaceStubVariables($functionStub, $endpoint);
        }

        // Delegate to MutationRequestTestGenerator for mutation requests
        if ($this->mutationTestGenerator->isMutationRequest($endpoint)) {
            $functionStub = $this->mutationTestGenerator->replaceStubVariables($functionStub, $endpoint);

            // Return early - mutation generator handles everything
            return $functionStub;
        }

        // Generate mock data for GET requests (without validation)
        if ($endpoint->method->isGet()) {
            // Replace fixture with inline mock data
            // Match both the template variable and actual fixture names
            $mockResponseBody = $this->generateMockResponseBody($endpoint);
            $functionStub = preg_replace(
                "/MockResponse::fixture\('[^']+'\)/",
                "MockResponse::make($mockResponseBody, 200)",
                $functionStub
            );
        } else {
            // For non-GET requests (POST, PATCH, DELETE), use simple 200 response
            $functionStub = preg_replace(
                "/MockResponse::fixture\('[^']+'\)/",
                'MockResponse::make([], 200)',
                $functionStub
            );
        }

        return $functionStub;
    }

    /**
     * Find an endpoint specification by operation ID
     */
    protected function findEndpointSpecByOperationId(string $operationId): ?array
    {
        $spec = $this->getOpenApiSpec();
        if (empty($spec) || ! isset($spec['paths'])) {
            return null;
        }

        // Search through all paths and methods to find the matching operationId
        foreach ($spec['paths'] as $path => $pathItem) {
            foreach ($pathItem as $method => $operation) {
                // Skip non-operation keys (like parameters, summary, etc.)
                if (! is_array($operation) || ! isset($operation['operationId'])) {
                    continue;
                }

                if ($operation['operationId'] === $operationId) {
                    return $operation;
                }
            }
        }

        return null;
    }

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
                $ref = $schema['$ref'];
                $refPath = str_replace('#/', '', $ref);
                $refParts = explode('/', $refPath);

                // Navigate to the referenced schema
                $referencedSchema = $spec;
                foreach ($refParts as $part) {
                    if (! isset($referencedSchema[$part])) {
                        return null;
                    }
                    $referencedSchema = $referencedSchema[$part];
                }

                // Check for example in referenced schema
                if (isset($referencedSchema['example'])) {
                    return $referencedSchema['example'];
                }
            }
        }

        return null;
    }

    /**
     * Generate mock data based on property types (fallback when no examples exist)
     */
    protected function generateMockData(Endpoint $endpoint): array
    {
        $spec = $this->getOpenApiSpec();
        $isCollection = $this->collectionTestGenerator->isCollectionRequest($endpoint);

        // Try to determine the schema for this endpoint
        $schema = $this->getResponseSchemaForEndpoint($endpoint);

        if ($schema) {
            // Generate mock data based on schema
            $attributes = $this->generateMockAttributes($schema);
            $resourceType = $this->getResourceTypeFromSchema($schema);

            if ($isCollection) {
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

            return [
                'data' => [
                    'type' => $resourceType,
                    'id' => 'mock-id-123',
                    'attributes' => $attributes,
                ],
            ];
        }

        // Fallback: generic mock data
        $resourceName = NameHelper::resourceClassName($endpoint->collection);
        $resourceType = NameHelper::safeVariableName($resourceName);

        if ($isCollection) {
            return [
                'data' => [
                    ['type' => $resourceType, 'id' => 'mock-id-1', 'attributes' => ['name' => 'Mock item 1']],
                    ['type' => $resourceType, 'id' => 'mock-id-2', 'attributes' => ['name' => 'Mock item 2']],
                ],
            ];
        }

        return [
            'data' => [
                'type' => $resourceType,
                'id' => 'mock-id-123',
                'attributes' => ['name' => 'Mock item'],
            ],
        ];
    }

    /**
     * Get the response schema for an endpoint from the OpenAPI spec
     */
    protected function getResponseSchemaForEndpoint(Endpoint $endpoint): ?array
    {
        $spec = $this->getOpenApiSpec();
        if (empty($spec)) {
            return null;
        }

        // Find the endpoint spec by operationId
        $endpointSpec = $this->findEndpointSpecByOperationId($endpoint->name);
        if (! $endpointSpec || ! isset($endpointSpec['responses']['200']['content']['application/json']['schema'])) {
            return null;
        }

        $schema = $endpointSpec['responses']['200']['content']['application/json']['schema'];

        // Handle array responses (collections)
        if (isset($schema['type']) && $schema['type'] === 'array' && isset($schema['items'])) {
            $schema = $schema['items'];
        }

        // Resolve $ref if present
        if (isset($schema['$ref'])) {
            $ref = $schema['$ref'];
            $refPath = str_replace('#/', '', $ref);
            $refParts = explode('/', $refPath);

            $referencedSchema = $spec;
            foreach ($refParts as $part) {
                if (! isset($referencedSchema[$part])) {
                    return null;
                }
                $referencedSchema = $referencedSchema[$part];
            }

            return $referencedSchema;
        }

        return $schema;
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
     * Get the resource type from a schema (e.g., "users", "entries")
     */
    protected function getResourceTypeFromSchema(array $schema): string
    {
        // Try to extract from schema title or description
        if (isset($schema['title'])) {
            return NameHelper::safeVariableName($schema['title']);
        }

        // Try to get from properties.type.example
        if (isset($schema['properties']['type']['example'])) {
            return $schema['properties']['type']['example'];
        }

        // Fallback to generic name
        return 'resources';
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
