<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;
use Timatic\SDK\Generator\TestGenerators\Traits\OpenApiSpecLoaderTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\SchemaExtractorTrait;
use Timatic\SDK\Generator\TestGenerators\Traits\TestValueGeneratorTrait;

class MutationRequestTestGenerator
{
    use OpenApiSpecLoaderTrait;
    use SchemaExtractorTrait;
    use TestValueGeneratorTrait;

    /**
     * Check if endpoint is a mutation request (POST or PATCH)
     */
    public function isMutationRequest(Endpoint $endpoint): bool
    {
        return $endpoint->method->isPost() || $endpoint->method->isPatch();
    }

    /**
     * Get the stub path for mutation request tests
     */
    public function getStubPath(): string
    {
        return __DIR__.'/stubs/pest-mutation-test-func.stub';
    }

    /**
     * Replace stub variables with mutation-specific content
     */
    public function replaceStubVariables(string $functionStub, Endpoint $endpoint): string
    {
        // Generate DTO instantiation code
        $dtoInstantiation = $this->generateDtoInstantiation($endpoint);
        $functionStub = str_replace('{{ dtoInstantiation }}', $dtoInstantiation, $functionStub);

        // Generate body validation code
        $bodyValidation = $this->generateBodyValidation($endpoint);
        $functionStub = str_replace('{{ bodyValidation }}', $bodyValidation, $functionStub);

        // Generate method arguments (including $dto)
        $methodArguments = $this->generateMethodArguments($endpoint);
        $functionStub = str_replace('{{ mutationMethodArguments }}', $methodArguments, $functionStub);

        return $functionStub;
    }

    /**
     * Generate method arguments for resource method call
     */
    protected function generateMethodArguments(Endpoint $endpoint): string
    {
        $args = [];

        // Add path parameters first (e.g., budgetId for PATCH)
        foreach ($endpoint->pathParameters as $param) {
            $paramName = NameHelper::safeVariableName($param->name);
            // Add 'Id' suffix if not already present
            if (! str_ends_with($paramName, 'Id')) {
                $paramName .= 'Id';
            }
            $args[] = "{$paramName}: 'test string'";
        }

        // Add $dto parameter last
        $args[] = '$dto';

        return implode(', ', $args);
    }

    /**
     * Generate DTO instantiation code with sample data
     */
    protected function generateDtoInstantiation(Endpoint $endpoint): string
    {
        $dtoClassName = $this->getDtoClassName($endpoint);
        $properties = $this->generateDtoProperties($endpoint);

        $lines = [];
        $lines[] = "    \$dto = new \\Timatic\\SDK\\Dto\\{$dtoClassName};";
        $lines[] = $properties;
        $lines[] = '    // todo: add every other DTO field';

        return implode("\n", $lines);
    }

    /**
     * Generate DTO property assignments
     */
    protected function generateDtoProperties(Endpoint $endpoint): string
    {
        $schema = $this->getRequestSchemaForEndpoint($endpoint);
        if (! $schema) {
            return "    \$dto->name = 'test value';";
        }

        $properties = $this->extractPropertiesFromSchema($schema);
        $lines = [];

        // Limit to first 4 properties for the test
        $propertiesToShow = array_slice($properties, 0, 4);

        foreach ($propertiesToShow as $propName => $propSpec) {
            $value = $this->generateTestValueForProperty($propName, $propSpec);
            $lines[] = "    \$dto->{$propName} = {$value};";
        }

        return implode("\n", $lines);
    }

    /**
     * Generate body validation code
     */
    protected function generateBodyValidation(Endpoint $endpoint): string
    {
        $resourceType = $this->getResourceTypeFromEndpoint($endpoint);
        $schema = $this->getRequestSchemaForEndpoint($endpoint);

        if (! $schema) {
            return $this->generateFallbackBodyValidation($resourceType, $endpoint);
        }

        $properties = $this->extractPropertiesFromSchema($schema);
        $lines = [];

        $lines[] = '    $mockClient->assertSent(function (Request $request) {';
        $lines[] = '        expect($request->body()->all())';
        $lines[] = "            ->toHaveKey('data')";

        // POST calls don't have an ID field in the request
        if ($endpoint->method->isPost()) {
            $lines[] = '            // POST calls dont have an ID field';
        }

        $lines[] = "            ->data->type->toBe('{$resourceType}')";

        // Generate attribute validations
        $attributeValidations = $this->generateAttributeValidations($properties);
        if ($attributeValidations) {
            $lines[] = '            ->data->attributes->scoped(fn ($attributes) => $attributes';
            $lines[] = $attributeValidations;
            $lines[] = '            );';
        }

        $lines[] = '';
        $lines[] = '        return true;';
        $lines[] = '    });';

        return implode("\n", $lines);
    }

    /**
     * Generate attribute validation chain
     */
    protected function generateAttributeValidations(array $properties): string
    {
        $lines = [];

        // Limit to first 4 properties for the test
        $propertiesToShow = array_slice($properties, 0, 4);

        foreach ($propertiesToShow as $propName => $propSpec) {
            $value = $this->generateTestValueForProperty($propName, $propSpec);
            $assertionValue = $this->formatValueForAssertion($value);
            $lines[] = "                ->{$propName}->toBe({$assertionValue})";
        }

        return implode("\n", $lines);
    }

    /**
     * Get the DTO class name for an endpoint
     */
    protected function getDtoClassName(Endpoint $endpoint): string
    {
        // Try to extract from endpoint collection name
        if ($endpoint->collection) {
            $resourceName = NameHelper::resourceClassName($endpoint->collection);

            // Remove trailing 's' for singular DTO name
            return rtrim($resourceName, 's');
        }

        // Fallback: try to parse from endpoint name
        $name = $endpoint->name ?: NameHelper::pathBasedName($endpoint);
        // Remove method prefix (post, patch)
        $name = preg_replace('/^(post|patch)/i', '', $name);
        // Remove trailing 's' for singular
        $name = rtrim($name, 's');

        return NameHelper::resourceClassName($name);
    }

    /**
     * Generate fallback body validation when schema is not available
     */
    protected function generateFallbackBodyValidation(string $resourceType, Endpoint $endpoint): string
    {
        $lines = [];
        $lines[] = '    $mockClient->assertSent(function (Request $request) {';
        $lines[] = '        expect($request->body()->all())';
        $lines[] = "            ->toHaveKey('data')";

        if ($endpoint->method->isPost()) {
            $lines[] = '            // POST calls dont have an ID field';
        }

        $lines[] = "            ->data->type->toBe('{$resourceType}')";
        $lines[] = '            ->data->attributes->scoped(fn ($attributes) => $attributes';
        $lines[] = "                ->name->toBe('test value')";
        $lines[] = '            );';
        $lines[] = '';
        $lines[] = '        return true;';
        $lines[] = '    });';

        return implode("\n", $lines);
    }
}
