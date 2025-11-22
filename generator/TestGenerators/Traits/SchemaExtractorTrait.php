<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators\Traits;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;
use Crescat\SaloonSdkGenerator\Helpers\NameHelper;

trait SchemaExtractorTrait
{
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
     * Get the response schema for an endpoint from the OpenAPI spec
     */
    protected function getResponseSchemaForEndpoint(Endpoint $endpoint): ?array
    {
        $spec = $this->getOpenApiSpec();
        if (empty($spec)) {
            return null;
        }

        // Find the endpoint spec by operationId
        $endpointSpec = $this->findEndpointSpecByOperationId($endpoint->name);
        if (! $endpointSpec || ! isset($endpointSpec['responses']['200']['content']['application/json']['schema'])) {
            return null;
        }

        $schema = $endpointSpec['responses']['200']['content']['application/json']['schema'];

        // Handle array responses (collections)
        if (isset($schema['type']) && $schema['type'] === 'array' && isset($schema['items'])) {
            $schema = $schema['items'];
        }

        // Resolve $ref if present
        if (isset($schema['$ref'])) {
            $schema = $this->resolveSchemaReference($schema['$ref']);
        }

        return $schema;
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
     * Get the resource type from a schema (e.g., "users", "entries")
     */
    protected function getResourceTypeFromSchema(array $schema): string
    {
        // Try to extract from schema title or description
        if (isset($schema['title'])) {
            return NameHelper::safeVariableName($schema['title']);
        }

        // Try to get from properties.type.example
        if (isset($schema['properties']['type']['example'])) {
            return $schema['properties']['type']['example'];
        }

        // Fallback to generic name
        return 'resources';
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
}
