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

    public function __construct()
    {
        $this->collectionTestGenerator = new CollectionRequestTestGenerator;
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
            return $this->collectionTestGenerator->replaceStubVariables($functionStub, $endpoint);
        }

        return $functionStub;
    }
}
