<?php

use App\Commands\GenerateCommand;
use NunoMaduro\LaravelConsoleSummary\SummaryCommand;
use Symfony\Component\Console\Command\DumpCompletionCommand;
use Symfony\Component\Console\Command\HelpCommand;

return [
    'default' => SummaryCommand::class,
    'paths' => [],
    'add' => [GenerateCommand::class],
    'hidden' => [
        SummaryCommand::class,
        DumpCompletionCommand::class,
        HelpCommand::class,
    ],
    'remove' => [],
];
