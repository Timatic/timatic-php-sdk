<?php

declare(strict_types=1);

namespace App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Timatic\JsonApiSdk\Commands\GenerateCommand as JsonApiGenerateCommand;

#[AsCommand(
    name: 'generate:sdk',
    description: 'Generate the Timatic SDK from an OpenAPI specification',
)]
class GenerateCommand extends JsonApiGenerateCommand {}
