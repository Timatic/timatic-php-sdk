<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\Parameter;
use Crescat\SaloonSdkGenerator\Generators\RequestGenerator;
use Crescat\SaloonSdkGenerator\Helpers\MethodGeneratorHelper;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Concerns\Model;
use Timatic\SDK\Generator\TestGenerators\Traits\DtoHelperTrait;
use Timatic\SDK\Hydration\Facades\Hydrator;

class JsonApiRequestGenerator extends RequestGenerator
{
    use DtoHelperTrait;

    /**
     * Hook: Filter out PUT requests - not supported in JSON:API
     */
    protected function shouldIncludeEndpoint(Endpoint $endpoint): bool
    {
        return ! $endpoint->method->isPut();
    }

    /**
     * Hook: Add "Request" suffix to class names
     */
    protected function getRequestClassName(Endpoint $endpoint): string
    {
        $className = parent::getRequestClassName($endpoint);

        if (! str_ends_with($className, 'Request')) {
            $className .= 'Request';
        }

        return $className;
    }

    /**
     * Hook: Transform path parameter names (e.g., budget -> budgetId)
     */
    protected function getConstructorParameterName(string $originalName, bool $isPathParam = false): string
    {
        if ($isPathParam) {
            return $originalName.'Id';
        }

        return $originalName;
    }

    /**
     * Hook: Customize request class for collection requests
     */
    protected function customizeRequestClass(ClassType $classType, $namespace, Endpoint $endpoint): void
    {
        if ($this->isCollectionRequest($endpoint)) {
            // Add Paginatable interface to all collection requests
            $namespace->addUse(Paginatable::class);
            $classType->addImplement(Paginatable::class);

            // Add HasFilters trait if collection has filter parameters in the endpoint
            if ($this->hasFilterParameters($endpoint)) {
                $namespace->addUse(HasFilters::class);
                $classType->addTrait(HasFilters::class);
            }
        }

        // Add hydration support to GET, POST, and PATCH requests
        if ($this->shouldHaveHydration($endpoint)) {
            $this->addHydrationSupport($classType, $namespace, $endpoint);
        }
    }

    /**
     * Hook: Customize constructor for mutation requests
     */
    protected function customizeConstructor($classConstructor, ClassType $classType, $namespace, Endpoint $endpoint): void
    {
        if (! $this->isMutationRequest($endpoint)) {
            return;
        }

        $namespace->addUse(Model::class);

        $dataParam = new Parameter(
            type: 'Timatic\\SDK\\Concerns\\Model|array|null',
            nullable: true,
            name: 'data',
            description: 'Request data',
        );

        MethodGeneratorHelper::addParameterAsPromotedProperty($classConstructor, $dataParam);

        $classType->addMethod('defaultBody')
            ->setProtected()
            ->setReturnType('array')
            ->addBody('return $this->data ? $this->data->toJsonApi() : [];');
    }

    /**
     * Hook: Filter out filter* query parameters (handled by HasFilters trait)
     */
    protected function shouldIncludeQueryParameter(string $paramName): bool
    {
        return ! str_starts_with($paramName, 'filter');
    }

    /**
     * Hook: Generate defaultQuery method with custom JSON:API logic
     */
    protected function generateDefaultQueryMethod(\Nette\PhpGenerator\ClassType $classType, $namespace, array $queryParams, Endpoint $endpoint): void
    {
        // If we have any query parameters (likely just 'include'), use array_filter
        if (! empty($queryParams)) {
            $classType->addMethod('defaultQuery')
                ->setProtected()
                ->setReturnType('array')
                ->addBody("return array_filter(['include' => \$this->include]);");
        }
    }

    // Helper methods for JSON:API logic

    protected function isMutationRequest(Endpoint $endpoint): bool
    {
        // Only POST and PATCH are supported mutation methods
        return $endpoint->method->isPost()
            || $endpoint->method->isPatch();
    }

    protected function isCollectionRequest(Endpoint $endpoint): bool
    {
        // Collection requests are GET requests without path parameters
        return $endpoint->method->isGet() && empty($endpoint->pathParameters);
    }

    protected function hasFilterParameters(Endpoint $endpoint): bool
    {
        foreach ($endpoint->queryParameters as $param) {
            if (str_starts_with($param->name, 'filter')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if request should have hydration support
     */
    protected function shouldHaveHydration(Endpoint $endpoint): bool
    {
        // Add hydration to GET, POST, and PATCH requests
        return $endpoint->method->isGet()
            || $endpoint->method->isPost()
            || $endpoint->method->isPatch();
    }

    /**
     * Add hydration support to request class
     */
    protected function addHydrationSupport(ClassType $classType, $namespace, Endpoint $endpoint): void
    {
        // Determine DTO class name from endpoint
        $dtoClassName = $this->getDtoClassName($endpoint);

        // Add imports
        $namespace->addUse(Hydrator::class);
        $namespace->addUse(Response::class);
        $namespace->addUse("Timatic\\SDK\\Dto\\{$dtoClassName}");

        // Add $model property - use the imported class name with ::class
        $classType->addProperty('model')
            ->setProtected()
            ->setValue(new \Nette\PhpGenerator\Literal("{$dtoClassName}::class"));

        // Add createDtoFromResponse method
        $method = $classType->addMethod('createDtoFromResponse')
            ->setReturnType('mixed');

        $param = $method->addParameter('response');
        $param->setType(Response::class);

        // Use appropriate hydration method based on request type
        if ($this->isCollectionRequest($endpoint)) {
            // Collection: use hydrateCollection
            $method->addBody('return Hydrator::hydrateCollection(');
            $method->addBody('    $this->model,');
            $method->addBody('    $response->json(\'data\'),');
            $method->addBody('    $response->json(\'included\')');
            $method->addBody(');');
        } else {
            // Single resource: use hydrate
            $method->addBody('return Hydrator::hydrate(');
            $method->addBody('    $this->model,');
            $method->addBody('    $response->json(\'data\'),');
            $method->addBody('    $response->json(\'included\')');
            $method->addBody(');');
        }
    }
}
