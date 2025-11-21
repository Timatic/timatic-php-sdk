<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;

class MutationRequestTestGenerator
{
    protected ?array $openApiSpec = null;

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
     * Get the resource type for JSON:API (plural, lowercase)
     */
    protected function getResourceTypeFromEndpoint(Endpoint $endpoint): string
    {
        if ($endpoint->collection) {
            return NameHelper::safeVariableName($endpoint->collection);
        }

        // Fallback: parse from endpoint path
        $path = $endpoint->path;
        // Extract first path segment (e.g., /budgets -> budgets)
        preg_match('#^/([^/]+)#', $path, $matches);

        return $matches[1] ?? 'resources';
    }

    /**
     * Load and cache the OpenAPI specification
     */
    protected function getOpenApiSpec(): array
    {
        if ($this->openApiSpec === null) {
            $specPath = __DIR__.'/../openapi.json';
            if (file_exists($specPath)) {
                $this->openApiSpec = json_decode(file_get_contents($specPath), true);
            } else {
                $this->openApiSpec = [];
            }
        }

        return $this->openApiSpec;
    }

    /**
     * Get the request body schema for an endpoint from the OpenAPI spec
     */
    protected function getRequestSchemaForEndpoint(Endpoint $endpoint): ?array
    {
        $spec = $this->getOpenApiSpec();
        if (empty($spec)) {
            return null;
        }

        // Find the endpoint spec by operationId
        $endpointSpec = $this->findEndpointSpecByOperationId($endpoint->name);
        if (! $endpointSpec || ! isset($endpointSpec['requestBody']['content']['application/json']['schema'])) {
            return null;
        }

        $schema = $endpointSpec['requestBody']['content']['application/json']['schema'];

        // Resolve $ref if present
        if (isset($schema['$ref'])) {
            $schema = $this->resolveSchemaReference($schema['$ref']);
        }

        return $schema;
    }

    /**
     * Find an endpoint specification by operation ID
     */
    protected function findEndpointSpecByOperationId(string $operationId): ?array
    {
        $spec = $this->getOpenApiSpec();
        if (empty($spec) || ! isset($spec['paths'])) {
            return null;
        }

        // Search through all paths and methods to find the matching operationId
        foreach ($spec['paths'] as $path => $pathItem) {
            foreach ($pathItem as $method => $operation) {
                // Skip non-operation keys (like parameters, summary, etc.)
                if (! is_array($operation) || ! isset($operation['operationId'])) {
                    continue;
                }

                if ($operation['operationId'] === $operationId) {
                    return $operation;
                }
            }
        }

        return null;
    }

    /**
     * Resolve a schema reference ($ref)
     */
    protected function resolveSchemaReference(string $ref): ?array
    {
        $spec = $this->getOpenApiSpec();
        $refPath = str_replace('#/', '', $ref);
        $refParts = explode('/', $refPath);

        $referencedSchema = $spec;
        foreach ($refParts as $part) {
            if (! isset($referencedSchema[$part])) {
                return null;
            }
            $referencedSchema = $referencedSchema[$part];
        }

        return $referencedSchema;
    }

    /**
     * Extract properties from a schema (handling JSON:API structure)
     */
    protected function extractPropertiesFromSchema(array $schema): array
    {
        // For JSON:API, properties are nested in data.attributes
        if (isset($schema['properties']['data']['properties']['attributes']['properties'])) {
            return $schema['properties']['data']['properties']['attributes']['properties'];
        }

        // Fallback: check if properties has attributes
        if (isset($schema['properties']['attributes']['properties'])) {
            return $schema['properties']['attributes']['properties'];
        }

        // Direct properties
        if (isset($schema['properties'])) {
            $properties = $schema['properties'];
            // Remove non-attribute fields
            unset($properties['id'], $properties['type'], $properties['attributes'], $properties['relationships']);

            return $properties;
        }

        return [];
    }

    /**
     * Generate appropriate test value based on property name and spec
     */
    protected function generateTestValueForProperty(string $property, array $spec = []): string
    {
        // Check for example in spec
        if (isset($spec['example'])) {
            $value = $spec['example'];
            if (is_string($value)) {
                return "'{$value}'";
            }
            if (is_bool($value)) {
                return $value ? 'true' : 'false';
            }
            if (is_numeric($value)) {
                return (string) $value;
            }
        }

        $type = $spec['type'] ?? 'string';
        $format = $spec['format'] ?? null;

        // DateTime fields
        if ($format === 'date-time' || str_contains($property, 'At') || str_contains($property, 'Date')) {
            return "'2025-01-01T10:00:00Z'";
        }

        // ID properties
        if (str_ends_with($property, 'Id')) {
            return "'test-id-123'";
        }

        // Boolean properties
        if ($type === 'boolean' || str_starts_with($property, 'is') || str_starts_with($property, 'has')) {
            return 'false';
        }

        // Numeric properties
        if ($type === 'integer' || $type === 'number') {
            return '123';
        }

        // String properties with common names
        if ($property === 'title') {
            return "'test title'";
        }
        if ($property === 'description') {
            return "'test description'";
        }
        if ($property === 'name') {
            return "'test name'";
        }

        // Default to string
        return "'test value'";
    }

    /**
     * Format a value for use in assertions
     */
    protected function formatValueForAssertion(string $value): string
    {
        // If value is already quoted, return as-is
        if (str_starts_with($value, "'") && str_ends_with($value, "'")) {
            return $value;
        }

        // Boolean values
        if ($value === 'true' || $value === 'false') {
            return $value;
        }

        // Numeric values
        if (is_numeric($value)) {
            return $value;
        }

        // Wrap in quotes
        return "'{$value}'";
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
