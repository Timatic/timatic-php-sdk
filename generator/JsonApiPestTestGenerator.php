<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Data\TaggedOutputFile;
use Crescat\SaloonSdkGenerator\Generators\PestTestGenerator;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nette\PhpGenerator\PhpFile;

class JsonApiPestTestGenerator extends PestTestGenerator
{
    /**
     * @param  array|Endpoint[]  $endpoints
     */
    public function generateTest(string $resourceName, array $endpoints): PhpFile|TaggedOutputFile|null
    {
        $fileStub = file_get_contents(__DIR__.'/../../../saloon-sdk-generator-jsonapi/src/Stubs/pest-resource-test.stub');

        $fileStub = str_replace('{{ prelude }}', '// Generated '.date('Y-m-d H:i:s'), $fileStub);
        $fileStub = str_replace('{{ connectorName }}', $this->config->connectorName, $fileStub);
        $fileStub = str_replace('{{ namespace }}', $this->config->namespace, $fileStub);
        $fileStub = str_replace('{{ name }}', $this->config->connectorName, $fileStub);
        $fileStub = str_replace('{{ clientName }}', NameHelper::safeVariableName($this->config->connectorName), $fileStub);

        $namespace = Arr::first($this->generatedCode->connectorClass->getNamespaces());
        $classType = Arr::first($namespace->getClasses());

        $constructorParameters = $classType->getMethod('__construct')->getParameters();
        $constructorArgs = [];

        foreach ($constructorParameters as $parameter) {
            if ($parameter->isNullable()) {
                continue;
            }

            $defaultValue = match ($parameter->getType()) {
                'string' => "'replace'",
                'bool' => 'true',
                'int' => 0,
                default => 'null',
            };

            $constructorArgs[] = $parameter->getName().': '.$defaultValue;
        }

        $fileStub = str_replace('{{ connectorArgs }}', Str::wrap(implode(",\n\t\t", $constructorArgs), "\n\t\t", "\n\t"), $fileStub);

        // Generate imports
        $imports = [];
        foreach ($endpoints as $endpoint) {
            $requestClassName = NameHelper::resourceClassName($endpoint->name);
            $imports[] = "use {$this->config->namespace}\\{$this->config->requestNamespaceSuffix}\\{$resourceName}\\{$requestClassName};";
        }

        // Add Saloon testing imports
        $imports[] = "use Saloon\\Http\\Faking\\MockClient;";
        $imports[] = "use Saloon\\Http\\Faking\\MockResponse;";
        $imports[] = "use Saloon\\Http\\Request;";

        $fileStub = str_replace('{{ requestImports }}', implode("\n", $imports), $fileStub);

        // Generate DTO imports
        $dtoImports = $this->generateDtoImports($endpoints);
        $fileStub = str_replace('{{ dtoImports }}', implode("\n", $dtoImports), $fileStub);

        // Generate test functions
        foreach ($endpoints as $endpoint) {
            $requestClassName = NameHelper::resourceClassName($endpoint->name);
            $requestClassNameAlias = $requestClassName == $resourceName ? "{$requestClassName}Request" : null;

            $testFunction = $this->generateTestFunction($endpoint, $resourceName, $requestClassName, $requestClassNameAlias);
            $fileStub .= "\n\n{$testFunction}";
        }

        try {
            return new TaggedOutputFile(
                tag: 'pest',
                file: $fileStub,
                path: "tests/{$resourceName}Test.php",
            );
        } catch (Exception $e) {
            return null;
        }
    }

    protected function generateTestFunction(Endpoint $endpoint, string $resourceName, string $requestClassName, ?string $requestClassNameAlias): string
    {
        $isMutation = $endpoint->method->isPost() || $endpoint->method->isPatch() || $endpoint->method->isPut();

        // Use JSON:API stub for mutations, regular stub for others
        $stubPath = $isMutation
            ? __DIR__.'/stubs/pest-jsonapi-test-func.stub'
            : __DIR__.'/../../../saloon-sdk-generator-jsonapi/src/Stubs/pest-resource-test-func.stub';

        $functionStub = file_get_contents($stubPath);

        $clientName = NameHelper::safeVariableName($this->config->connectorName);
        $resourceNameSafe = NameHelper::safeVariableName($resourceName);
        $methodNameSafe = NameHelper::safeVariableName($requestClassName);

        $functionStub = str_replace('{{ clientName }}', $clientName, $functionStub);
        $functionStub = str_replace('{{ requestClass }}', $requestClassNameAlias ?? $requestClassName, $functionStub);
        $functionStub = str_replace('{{ resourceName }}', $resourceNameSafe, $functionStub);
        $functionStub = str_replace('{{ methodName }}', $methodNameSafe, $functionStub);
        $functionStub = str_replace('{{ fixtureName }}', Str::camel($resourceNameSafe.'.'.$methodNameSafe), $functionStub);

        $description = $isMutation
            ? "sends valid JSON:API body when calling {$methodNameSafe} in {$resourceName}"
            : "calls the {$methodNameSafe} method in the {$resourceName} resource";

        $functionStub = str_replace('{{ testDescription }}', $description, $functionStub);

        // Set response status
        $responseStatus = $endpoint->method->isPost() ? 201 : 200;
        $functionStub = str_replace('{{ responseStatus }}', (string) $responseStatus, $functionStub);

        if ($isMutation) {
            // For mutations, create a Model instance
            $dtoClassName = NameHelper::dtoClassName($resourceName);
            $modelSetup = "    \${$resourceNameSafe} = new {$dtoClassName}(['title' => 'Test {$resourceName}']);\n";
            $methodArguments = "\${$resourceNameSafe}";

            // Add simple body assertion
            $bodyAssertions = "        // Validate attributes exist\n";
            $bodyAssertions .= "        expect(\$data['attributes'])->toBeArray();\n";

            $functionStub = str_replace('{{ modelSetup }}', $modelSetup, $functionStub);
            $functionStub = str_replace('{{ methodArguments }}', $methodArguments, $functionStub);
            $functionStub = str_replace('{{ bodyAssertions }}', $bodyAssertions, $functionStub);
        } else {
            // For non-mutations, use regular fixture-based approach
            $methodArguments = [];
            foreach ($endpoint->allParameters() as $param) {
                $methodArguments[] = sprintf('%s: %s', NameHelper::safeVariableName($param->name), match ($param->type) {
                    'string' => "'test string'",
                    'int', 'integer' => '123',
                    default => 'null',
                });
            }

            $methodArguments = Str::wrap(implode(",\n\t\t", $methodArguments), "\n\t\t", "\n\t");
            $functionStub = str_replace('{{ methodArguments }}', $methodArguments, $functionStub);
        }

        return $functionStub;
    }
}
