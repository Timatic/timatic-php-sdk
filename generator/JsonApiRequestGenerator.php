<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\Generator\Parameter;
use Crescat\SaloonSdkGenerator\Generators\RequestGenerator;
use Crescat\SaloonSdkGenerator\Helpers\MethodGeneratorHelper;
use Nette\PhpGenerator\ClassType;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Foundation\Model;

class JsonApiRequestGenerator extends RequestGenerator
{
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
        if (! $this->isCollectionRequest($endpoint)) {
            return;
        }

        // Add Paginatable interface to all collection requests
        $namespace->addUse(Paginatable::class);
        $classType->addImplement(Paginatable::class);

        // Add HasFilters trait if collection has filter parameters in the endpoint
        if ($this->hasFilterParameters($endpoint)) {
            $namespace->addUse(HasFilters::class);
            $classType->addTrait(HasFilters::class);
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
            type: 'Timatic\\SDK\\Foundation\\Model|array|null',
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
}
