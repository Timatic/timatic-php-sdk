<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators\Traits;

trait OpenApiSpecLoaderTrait
{
    protected ?array $openApiSpec = null;

    /**
     * Load and cache the OpenAPI specification
     */
    protected function getOpenApiSpec(): array
    {
        if ($this->openApiSpec === null) {
            $specPath = __DIR__.'/../../../openapi.json';
            if (file_exists($specPath)) {
                $this->openApiSpec = json_decode(file_get_contents($specPath), true);
            } else {
                $this->openApiSpec = [];
            }
        }

        return $this->openApiSpec;
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
}
