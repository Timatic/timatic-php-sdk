<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Data\Generator\Config;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\GeneratedCode;
use Crescat\SaloonSdkGenerator\Data\Generator\Parameter;
use Crescat\SaloonSdkGenerator\Generators\PestTestGenerator;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Nette\PhpGenerator\PhpFile;
use Timatic\SDK\Generator\TestGenerators\CollectionRequestTestGenerator;
use Timatic\SDK\Generator\TestGenerators\DeleteRequestTestGenerator;
use Timatic\SDK\Generator\TestGenerators\MutationRequestTestGenerator;
use Timatic\SDK\Generator\TestGenerators\SingularGetRequestTestGenerator;

class JsonApiPestTestGenerator extends PestTestGenerator
{
    protected CollectionRequestTestGenerator $collectionTestGenerator;

    protected MutationRequestTestGenerator $mutationTestGenerator;

    protected SingularGetRequestTestGenerator $singularGetTestGenerator;

    protected DeleteRequestTestGenerator $deleteTestGenerator;

    protected GeneratedCode $generatedCode;

    /**
     * Override process() to instantiate test generators with ApiSpecification and GeneratedCode
     */
    public function process(
        Config $config,
        ApiSpecification $specification,
        GeneratedCode $generatedCode,
    ): PhpFile|array|null {
        // Store generated code for later use
        $this->generatedCode = $generatedCode;

        // Instantiate test generators with the parsed ApiSpecification and GeneratedCode
        $this->collectionTestGenerator = new CollectionRequestTestGenerator($specification, $generatedCode);
        $this->mutationTestGenerator = new MutationRequestTestGenerator($specification, $generatedCode);
        $this->singularGetTestGenerator = new SingularGetRequestTestGenerator($specification, $generatedCode);
        $this->deleteTestGenerator = new DeleteRequestTestGenerator($specification, $generatedCode);

        // Call parent to continue normal processing
        return parent::process($config, $specification, $generatedCode);
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
     * Filter out PUT requests and endpoints without DTOs
     */
    protected function shouldIncludeEndpoint(Endpoint $endpoint): bool
    {
        if ($endpoint->method->isPut()) {
            return false;
        }

        // Skip endpoints without DTOs (endpoints that don't return data)
        if (! $this->hasDtoForEndpoint($endpoint)) {
            return false;
        }

        return true;
    }

    /**
     * Check if a DTO exists for the endpoint
     */
    protected function hasDtoForEndpoint(Endpoint $endpoint): bool
    {
        $dtoClassName = $this->getDtoClassName($endpoint);

        // Check if this DTO was generated in the current run
        return array_key_exists($dtoClassName, $this->generatedCode->dtoClasses);
    }

    /**
     * Get DTO class name from endpoint
     */
    protected function getDtoClassName(Endpoint $endpoint): string
    {
        // Use collection name to determine DTO
        if ($endpoint->collection) {
            $resourceName = NameHelper::resourceClassName($endpoint->collection);

            // Use Laravel's Str::singular() for correct singular form
            return \Illuminate\Support\Str::singular($resourceName);
        }

        // Fallback: try to parse from endpoint name
        $name = $endpoint->name ?: NameHelper::pathBasedName($endpoint);
        // Remove method prefix (post, patch, get)
        $name = preg_replace('/^(post|patch|get)/i', '', $name);

        // Use Laravel's Str::singular() for correct singular form
        return \Illuminate\Support\Str::singular(NameHelper::resourceClassName($name));
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
}
