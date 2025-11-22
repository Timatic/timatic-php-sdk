<?php

declare(strict_types=1);

namespace Timatic\SDK\Generator\TestGenerators;

use Crescat\SaloonSdkGenerator\Data\Generator\Endpoint;

class DeleteRequestTestGenerator
{
    /**
     * Check if endpoint is a DELETE request
     */
    public function isDeleteRequest(Endpoint $endpoint): bool
    {
        return $endpoint->method->isDelete();
    }

    /**
     * Get the stub path for DELETE request tests
     */
    public function getStubPath(): string
    {
        return __DIR__.'/stubs/pest-delete-request-test-func.stub';
    }

    /**
     * Replace stub variables (DELETE requests don't need custom replacements)
     */
    public function replaceStubVariables(string $functionStub, Endpoint $endpoint): string
    {
        // DELETE requests use the standard stub without custom replacements
        return $functionStub;
    }
}
