<?php

declare(strict_types=1);

namespace Timatic\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Generators\ConnectorGenerator;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpFile;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Timatic\Pagination\JsonApiPaginator;
use Timatic\Responses\TimaticResponse;

class JsonApiConnectorGenerator extends ConnectorGenerator
{
    protected function generateConnectorClass(ApiSpecification $specification): ?PhpFile
    {
        // Generate base connector using parent
        $phpFile = parent::generateConnectorClass($specification);

        // Get the namespace and class
        $namespace = array_values($phpFile->getNamespaces())[0];
        /** @var ClassType $classType */
        $classType = array_values($namespace->getClasses())[0];

        // Add HasPagination interface
        $namespace->addUse(HasPagination::class);
        $classType->addImplement(HasPagination::class);

        // Add additional imports for custom methods
        $namespace->addUse(Request::class);
        $namespace->addUse(JsonApiPaginator::class);
        $namespace->addUse(TimaticResponse::class);

        // Keep the empty constructor for test compatibility
        // (PestTestGenerator needs it)

        // Override resolveBaseUrl to use Laravel config
        $resolveBaseUrl = $classType->getMethod('resolveBaseUrl');
        $resolveBaseUrl->setBody('return config(\'timatic.base_url\');');

        // Store all resource methods (to re-add them later in correct order)
        $resourceMethods = [];
        foreach ($classType->getMethods() as $methodName => $method) {
            $resourceMethods[$methodName] = $method;
            $classType->removeMethod($methodName);
        }

        // Add defaultHeaders method (after resolveBaseUrl)
        $this->addDefaultHeaders($classType);

        // Add resolveResponseClass method
        $this->addResolveResponseClassMethod($classType);

        // Add paginate method
        $this->addPaginateMethod($classType);

        // Re-add resource methods after custom configuration methods
        foreach ($resourceMethods as $methodName => $method) {
            $classType->setMethods(array_merge($classType->getMethods(), [$methodName => $method]));
        }

        return $phpFile;
    }

    public function removeEmptyConstructorIfPresent(ClassType $classType): void
    {
        if ($classType->hasMethod('__construct')) {
            $constructor = $classType->getMethod('__construct');
            // Only remove if it's empty (no parameters and no body)
            if (count($constructor->getParameters()) === 0 && empty(trim($constructor->getBody()))) {
                $classType->removeMethod('__construct');
            }
        }
    }

    public function addDefaultHeaders(ClassType $classType): void
    {
        $defaultHeaders = $classType->addMethod('defaultHeaders')
            ->setProtected()
            ->setReturnType('array');

        $defaultHeaders->addBody('$headers = [');
        $defaultHeaders->addBody('    \'Accept\' => \'application/vnd.api+json\',');
        $defaultHeaders->addBody('    \'Content-Type\' => \'application/vnd.api+json\',');
        $defaultHeaders->addBody('];');
        $defaultHeaders->addBody('');
        $defaultHeaders->addBody('if ($token = config(\'timatic.api_token\')) {');
        $defaultHeaders->addBody('    $headers[\'Authorization\'] = "Bearer {$token}";');
        $defaultHeaders->addBody('}');
        $defaultHeaders->addBody('');
        $defaultHeaders->addBody('return $headers;');
    }

    public function addPaginateMethod(ClassType $classType): void
    {
        $paginate = $classType->addMethod('paginate')
            ->setPublic()
            ->setReturnType(JsonApiPaginator::class);

        $paginate->addParameter('request')
            ->setType(Request::class);

        $paginate->setBody('return new ?($this, $request);', [new Literal('JsonApiPaginator')]);
    }

    public function addResolveResponseClassMethod(ClassType $classType): void
    {
        $classType->addMethod('resolveResponseClass')
            ->setPublic()
            ->setReturnType('string')
            ->setBody('return ?;', [new Literal('TimaticResponse::class')]);
    }
}
