<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators\Traits;

use cebe\openapi\spec\Operation;
use cebe\openapi\spec\Reference;
use cebe\openapi\spec\Schema;
use Crescat\SaloonSdkGenerator\Data\Generator\ApiSpecification;
use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;

trait SchemaExtractorTrait
{
    /**
     * The parsed ApiSpecification (must be provided by the class using this trait)
     */
    protected ApiSpecification $specification;

    /**
     * Get the response schema for an endpoint from the ApiSpecification
     */
    protected function getResponseSchemaForEndpoint(Endpoint $endpoint): ?Schema
    {
        $operation = $this->findOperationByEndpoint($endpoint);
        if (! $operation) {
            return null;
        }

        // Get the 200 response schema
        $response = $operation->responses['200'] ?? $operation->responses[200] ?? null;
        if (! $response) {
            return null;
        }

        // Get the JSON response schema
        $mediaType = $response->content['application/json'] ?? null;
        if (! $mediaType || ! $mediaType->schema) {
            return null;
        }

        $schema = $this->resolveSchema($mediaType->schema);

        // Handle array responses (collections) - unwrap to get the item schema
        if ($schema && $schema->type === 'array' && $schema->items) {
            $schema = $this->resolveSchema($schema->items);
        }

        return $schema;
    }

    /**
     * Get the request body schema for an endpoint from the ApiSpecification
     */
    protected function getRequestSchemaForEndpoint(Endpoint $endpoint): ?Schema
    {
        $operation = $this->findOperationByEndpoint($endpoint);
        if (! $operation || ! $operation->requestBody) {
            return null;
        }

        // Get the JSON request schema
        $mediaType = $operation->requestBody->content['application/json'] ?? null;
        if (! $mediaType || ! $mediaType->schema) {
            return null;
        }

        return $this->resolveSchema($mediaType->schema);
    }

    /**
     * Resolve a Schema or Reference to a Schema
     */
    protected function resolveSchema(Schema|Reference|null $schemaOrRef): ?Schema
    {
        if ($schemaOrRef === null) {
            return null;
        }

        // If it's already a Schema, return it
        if ($schemaOrRef instanceof Schema) {
            return $schemaOrRef;
        }

        // If it's a Reference, resolve it
        if ($schemaOrRef instanceof Reference) {
            $resolved = $schemaOrRef->resolve();
            if ($resolved instanceof Schema) {
                return $resolved;
            }
        }

        return null;
    }

    /**
     * Find an Operation in the ApiSpecification by matching endpoint operationId
     */
    protected function findOperationByEndpoint(Endpoint $endpoint): ?Operation
    {
        if (! $this->specification->paths) {
            return null;
        }

        // Search through all paths to find matching operation
        foreach ($this->specification->paths as $pathItem) {
            $httpMethod = strtolower($endpoint->method->value);

            // Get the operation for this HTTP method
            $operation = match ($httpMethod) {
                'get' => $pathItem->get,
                'post' => $pathItem->post,
                'patch' => $pathItem->patch,
                'delete' => $pathItem->delete,
                'put' => $pathItem->put,
                default => null,
            };

            if (! $operation) {
                continue;
            }

            // Match by operationId
            if ($operation->operationId === $endpoint->name) {
                return $operation;
            }
        }

        return null;
    }

    /**
     * Extract properties from a schema (handling JSON:API structure)
     * Returns an array of Schema objects keyed by property name
     *
     * @return array<string, Schema>
     */
    protected function extractPropertiesFromSchema(Schema $schema): array
    {
        if (! $schema->properties) {
            return [];
        }

        // For JSON:API, properties are nested in data.attributes
        if (isset($schema->properties['data'])) {
            $dataSchema = $this->resolveSchema($schema->properties['data']);
            if ($dataSchema && isset($dataSchema->properties['attributes'])) {
                $attributesSchema = $this->resolveSchema($dataSchema->properties['attributes']);
                if ($attributesSchema && $attributesSchema->properties) {
                    return $this->resolvePropertySchemas($attributesSchema->properties);
                }
            }
        }

        // Fallback: check if properties has attributes directly
        if (isset($schema->properties['attributes'])) {
            $attributesSchema = $this->resolveSchema($schema->properties['attributes']);
            if ($attributesSchema && $attributesSchema->properties) {
                return $this->resolvePropertySchemas($attributesSchema->properties);
            }
        }

        // Direct properties - filter out JSON:API reserved fields
        $properties = $schema->properties;
        unset($properties['id'], $properties['type'], $properties['attributes'], $properties['relationships']);

        return $this->resolvePropertySchemas($properties);
    }

    /**
     * Resolve all property schemas (convert References to Schemas)
     *
     * @param  array<string, Schema|Reference>  $properties
     * @return array<string, Schema>
     */
    protected function resolvePropertySchemas(array $properties): array
    {
        $resolved = [];
        foreach ($properties as $name => $property) {
            $schema = $this->resolveSchema($property);
            if ($schema) {
                $resolved[$name] = $schema;
            }
        }

        return $resolved;
    }

    /**
     * Get the resource type from a schema (e.g., "users", "entries")
     */
    protected function getResourceTypeFromSchema(Schema $schema): string
    {
        // Try to extract from schema title
        if ($schema->title) {
            return NameHelper::safeVariableName($schema->title);
        }

        // Try to get from properties.type.example (JSON:API type field)
        if (isset($schema->properties['type'])) {
            $typeProperty = $schema->properties['type'];
            if ($typeProperty instanceof Schema && $typeProperty->example) {
                return $typeProperty->example;
            }
        }

        // Fallback to generic name
        return 'resources';
    }

    /**
     * Get the resource type for JSON:API from endpoint (plural, lowercase)
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
}
