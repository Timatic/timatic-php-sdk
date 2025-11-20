<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Generators\RequestGenerator;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Concerns\HasFilters;
use Timatic\SDK\Foundation\Model;

class JsonApiRequestGenerator extends RequestGenerator
{
    public function generate($specification): array
    {
        // Filter out PUT endpoints before generating
        $filteredSpec = clone $specification;
        $filteredSpec->endpoints = array_filter(
            $specification->endpoints,
            fn ($endpoint) => ! $endpoint->method->isPut()
        );

        return parent::generate($filteredSpec);
    }

    protected function generateRequestClass(Endpoint $endpoint): PhpFile
    {
        // Use parent generation for most of the class
        $phpFile = parent::generateRequestClass($endpoint);

        // Get the class and namespace
        $namespace = array_values($phpFile->getNamespaces())[0];
        $classType = array_values($namespace->getClasses())[0];

        // Add "Request" suffix to class name
        $originalName = $classType->getName();
        if (! str_ends_with($originalName, 'Request')) {
            $classType->setName($originalName.'Request');
        }

        // Add Model import
        $namespace->addUse(Model::class);

        // For POST/PUT/PATCH without body parameters, add Model data parameter
        if ($this->isMutationRequest($endpoint) && empty($endpoint->bodyParameters)) {
            $this->addModelDataParameter($classType, $namespace);
        }

        // For GET collection requests, add Paginatable interface
        if ($this->isCollectionRequest($endpoint)) {
            $namespace->addUse(Paginatable::class);
            $classType->addImplement(Paginatable::class);

            // Check if this request has filter parameters before adding HasFilters trait
            $hasFilters = $this->hasFilterParameters($classType);

            if ($hasFilters) {
                $namespace->addUse(HasFilters::class);
                $classType->addTrait(HasFilters::class);
            }

            // Remove filter parameters from constructor, keep only include
            $this->removeFilterParameters($classType);
        }

        return $phpFile;
    }

    protected function isMutationRequest(Endpoint $endpoint): bool
    {
        // Only POST and PATCH are supported mutation methods
        return $endpoint->method->isPost()
            || $endpoint->method->isPatch();
    }

    protected function isCollectionRequest(Endpoint $endpoint): bool
    {
        // Collection requests are GET requests without an ID parameter in the path
        if (! $endpoint->method->isGet()) {
            return false;
        }

        // Check if the path contains a parameter (like {id}, {budget}, etc.)
        // Collection endpoints typically don't have path parameters
        return empty($endpoint->pathParameters);
    }

    protected function hasFilterParameters(ClassType $classType): bool
    {
        if (! $classType->hasMethod('__construct')) {
            return false;
        }

        $constructor = $classType->getMethod('__construct');
        $parameters = $constructor->getParameters();

        foreach ($parameters as $paramName => $parameter) {
            if (str_starts_with($paramName, 'filter')) {
                return true;
            }
        }

        return false;
    }

    protected function addModelDataParameter(ClassType $classType, $namespace): void
    {
        // Get constructor
        $constructor = $classType->getMethod('__construct');

        // Add data parameter with Model|array|null type to match Resource signature
        $constructor->addPromotedParameter('data')
            ->setType('\\Timatic\\SDK\\Foundation\\Model|array|null')
            ->setProtected()
            ->setNullable();

        // Add defaultBody method
        $defaultBody = $classType->addMethod('defaultBody')
            ->setProtected()
            ->setReturnType('array')
            ->addBody('return $this->data ? $this->data->toJsonApi() : [];');
    }

    protected function removeFilterParameters(ClassType $classType): void
    {
        $hasInclude = false;

        // Remove filter parameters from constructor
        if ($classType->hasMethod('__construct')) {
            $constructor = $classType->getMethod('__construct');
            $parameters = $constructor->getParameters();

            foreach ($parameters as $paramName => $parameter) {
                if (str_starts_with($paramName, 'filter')) {
                    $constructor->removeParameter($paramName);
                }
            }

            // Check if include parameter still exists after removing filters
            $hasInclude = $constructor->hasParameter('include');

            // Remove PHPDoc for filter parameters
            $comment = $constructor->getComment();
            if ($comment) {
                // Remove all @param lines that start with filter
                $lines = explode("\n", $comment);
                $filteredLines = array_filter($lines, function ($line) {
                    return ! preg_match('/@param.*\$filter/', $line);
                });

                // If only the opening /** and closing */ remain, remove the entire comment
                $filteredLines = array_values($filteredLines);
                if (count($filteredLines) <= 2) {
                    $constructor->setComment(null);
                } else {
                    $constructor->setComment(implode("\n", $filteredLines));
                }
            }
        }

        // Update or remove defaultQuery
        if ($classType->hasMethod('defaultQuery')) {
            $defaultQuery = $classType->getMethod('defaultQuery');

            if ($hasInclude) {
                // If include parameter exists, only return that
                $defaultQuery->setBody('return array_filter([\'include\' => $this->include]);');
            } else {
                // If no include parameter, remove defaultQuery entirely
                $classType->removeMethod('defaultQuery');
            }
        }
    }
}
