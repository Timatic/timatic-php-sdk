<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Generators\RequestGenerator;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use DateTime;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpFile;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method as SaloonHttpMethod;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
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

        return $phpFile;
    }

    protected function isMutationRequest(Endpoint $endpoint): bool
    {
        return $endpoint->method->isPost()
            || $endpoint->method->isPatch()
            || $endpoint->method->isPut();
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
