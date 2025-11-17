<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Generators\ResourceGenerator;
use Nette\PhpGenerator\Method;

class JsonApiResourceGenerator extends ResourceGenerator
{
    protected function generateResourceMethod(Endpoint $endpoint, Method $method): void
    {
        parent::generateResourceMethod($endpoint, $method);

        // For POST/PUT/PATCH requests without body parameters, add data parameter
        if ($this->isMutationRequest($endpoint) && empty($endpoint->bodyParameters)) {
            echo "Adding data parameter to {$endpoint->name}\n";
            $this->addDataParameterToMethod($endpoint, $method);
        }
    }

    protected function addDataParameterToMethod(Endpoint $endpoint, Method $method): void
    {
        // Add data parameter to method signature
        $method->addParameter('data')
            ->setType('\\Timatic\\SDK\\Foundation\\Model|array|null')
            ->setDefaultValue(null);

        // Update method body to pass data parameter to request constructor
        $body = $method->getBody();

        // Find the "new RequestName(" pattern and add $data parameter
        if (! empty($endpoint->pathParameters)) {
            // Has path params: new Request($param, null) -> new Request($param, $data)
            $body = preg_replace(
                '/(new\s+'.preg_quote($endpoint->name, '/').'\([^)]+)\)/',
                '$1, $data)',
                $body
            );
        } else {
            // No path params: new Request() -> new Request($data)
            $body = str_replace(
                'new '.$endpoint->name.'()',
                'new '.$endpoint->name.'($data)',
                $body
            );
        }

        $method->setBody($body);
    }

    protected function isMutationRequest(Endpoint $endpoint): bool
    {
        return $endpoint->method->isPost()
            || $endpoint->method->isPatch()
            || $endpoint->method->isPut();
    }
}
