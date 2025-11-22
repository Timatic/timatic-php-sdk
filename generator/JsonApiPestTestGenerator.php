<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\Parameter;
use Crescat\SaloonSdkGenerator\Generators\PestTestGenerator;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Timatic\SDK\Generator\TestGenerators\CollectionRequestTestGenerator;
use Timatic\SDK\Generator\TestGenerators\DeleteRequestTestGenerator;
use Timatic\SDK\Generator\TestGenerators\MutationRequestTestGenerator;
use Timatic\SDK\Generator\TestGenerators\SingularGetRequestTestGenerator;
use Timatic\SDK\Generator\TestGenerators\Traits\MockDataGeneratorTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\OpenApiSpecLoaderTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\SchemaExtractorTrait;

class JsonApiPestTestGenerator extends PestTestGenerator
{
    use MockDataGeneratorTrait;
    use OpenApiSpecLoaderTrait;
    use SchemaExtractorTrait;

    protected CollectionRequestTestGenerator $collectionTestGenerator;

    protected MutationRequestTestGenerator $mutationTestGenerator;

    protected SingularGetRequestTestGenerator $singularGetTestGenerator;

    protected DeleteRequestTestGenerator $deleteTestGenerator;

    public function __construct()
    {
        $this->collectionTestGenerator = new CollectionRequestTestGenerator;
        $this->mutationTestGenerator = new MutationRequestTestGenerator;
        $this->singularGetTestGenerator = new SingularGetRequestTestGenerator;
        $this->deleteTestGenerator = new DeleteRequestTestGenerator;
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
        return __DIR__.'/TestGenerators/stubs/pest-resource-test.stub';
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

        // Delegate to SingularGetRequestTestGenerator for singular GET requests
        if ($this->singularGetTestGenerator->isSingularGetRequest($endpoint)) {
            return $this->singularGetTestGenerator->getStubPath();
        }

        // Delegate to DeleteRequestTestGenerator for DELETE requests
        if ($this->deleteTestGenerator->isDeleteRequest($endpoint)) {
            return $this->deleteTestGenerator->getStubPath();
        }

        throw \Exception('Unmatched request type');
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
            return $this->collectionTestGenerator->replaceStubVariables($functionStub, $endpoint);
        }

        // Delegate to MutationRequestTestGenerator for mutation requests
        if ($this->mutationTestGenerator->isMutationRequest($endpoint)) {
            return $this->mutationTestGenerator->replaceStubVariables($functionStub, $endpoint);
        }

        // Delegate to SingularGetRequestTestGenerator for singular GET requests
        if ($this->singularGetTestGenerator->isSingularGetRequest($endpoint)) {
            return $this->singularGetTestGenerator->replaceStubVariables($functionStub, $endpoint);
        }

        // Delegate to DeleteRequestTestGenerator for DELETE requests
        if ($this->deleteTestGenerator->isDeleteRequest($endpoint)) {
            return $this->deleteTestGenerator->replaceStubVariables($functionStub, $endpoint);
        }

        throw new \Exception('Unmatched request type');
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
}
