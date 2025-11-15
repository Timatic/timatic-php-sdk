<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Generators\RequestGenerator;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Saloon\PaginationPlugin\Contracts\Paginatable;
use Timatic\SDK\Foundation\Model;

class JsonApiRequestGenerator extends RequestGenerator
{
    protected function generateRequestClass(Endpoint $endpoint): PhpFile
    {
        // Use parent generation for most of the class
        $phpFile = parent::generateRequestClass($endpoint);

        // Get the class and namespace
        $namespace = array_values($phpFile->getNamespaces())[0];
        $classType = array_values($namespace->getClasses())[0];

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
        }

        return $phpFile;
    }

    protected function isMutationRequest(Endpoint $endpoint): bool
    {
        return $endpoint->method->isPost()
            || $endpoint->method->isPatch()
            || $endpoint->method->isPut();
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

    protected function addModelDataParameter(ClassType $classType, $namespace): void
    {
        // Get constructor
        $constructor = $classType->getMethod('__construct');

        // Add data parameter with fully qualified type
        $constructor->addPromotedParameter('data')
            ->setType('\\Timatic\\SDK\\Foundation\\Model|array')
            ->setProtected();

        // Add defaultBody method
        $defaultBody = $classType->addMethod('defaultBody')
            ->setProtected()
            ->setReturnType('array')
            ->addBody('return $this->data instanceof Model')
            ->addBody('    ? $this->data->toJsonApi()')
            ->addBody('    : [\'data\' => $this->data];');
    }
}
