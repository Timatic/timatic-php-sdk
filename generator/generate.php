<?php

declare(strict_types=1);

// Use local vendor autoload
require_once __DIR__.'/../vendor/autoload.php';

use Crescat\SaloonSdkGenerator\CodeGenerator;
use Crescat\SaloonSdkGenerator\Data\Generator\Config;
use Crescat\SaloonSdkGenerator\Factory;
use Timatic\SDK\Generator\JsonApiConnectorGenerator;
use Timatic\SDK\Generator\JsonApiDtoGenerator;
use Timatic\SDK\Generator\JsonApiPestTestGenerator;
use Timatic\SDK\Generator\JsonApiRequestGenerator;
use Timatic\SDK\Generator\JsonApiResourceGenerator;

// Download OpenAPI spec
echo "📥 Downloading OpenAPI specification...\n";
$openApiJson = file_get_contents('https://api.app.timatic.test/docs/json', false, stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]));

if (! $openApiJson) {
    echo "❌ Failed to download OpenAPI specification\n";
    exit(1);
}

file_put_contents(__DIR__.'/../openapi.json', $openApiJson);
echo "✅ OpenAPI specification downloaded\n\n";

// Clean up previously generated folders
echo "🧹 Cleaning up previously generated files...\n";
$foldersToClean = [
    __DIR__.'/../src/Requests',
    __DIR__.'/../src/Resource',
    __DIR__.'/../src/Dto',
    __DIR__.'/../tests/Requests',
];

foreach ($foldersToClean as $folder) {
    if (is_dir($folder)) {
        // Recursively delete directory
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $todo($fileinfo->getRealPath());
        }

        rmdir($folder);
        echo '  ✓ Removed '.basename($folder)."\n";
    }
}

echo "✅ Cleanup completed\n\n";

// Parse the specification
echo "🔨 Parsing OpenAPI specification...\n";
$specification = Factory::parse('openapi', __DIR__.'/../openapi.json');
echo "✅ Specification parsed\n\n";

// Create config
$config = new Config(
    connectorName: 'TimaticConnector',
    namespace: 'Timatic\\SDK',
    resourceNamespaceSuffix: 'Resource',
    requestNamespaceSuffix: 'Requests',
    dtoNamespaceSuffix: 'Dto',
);

// Generate SDK code with tests in a single run
echo "🏗️  Generating SDK with JSON:API models and tests...\n";
$generator = new CodeGenerator(
    config: $config,
    connectorGenerator: new JsonApiConnectorGenerator($config),
    dtoGenerator: new JsonApiDtoGenerator($config),
    requestGenerator: new JsonApiRequestGenerator($config),
    resourceGenerator: new JsonApiResourceGenerator($config),
    postProcessors: [new JsonApiPestTestGenerator] // Generate tests in same run
);

$result = $generator->run($specification);

// Output directory
$outputDir = __DIR__.'/../src';

// Helper function to write files
function writeFile($file, $outputDir, $namespace)
{
    $relativePath = str_replace($namespace, '', array_values($file->getNamespaces())[0]->getName());
    $className = array_values($file->getClasses())[0]->getName();
    $filePath = $outputDir.str_replace('\\', '/', $relativePath).'/'.$className.'.php';

    // Create directory if it doesn't exist
    $dir = dirname($filePath);
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    file_put_contents($filePath, (string) $file);

    return $filePath;
}

// Write requests
echo "\n📝 Requests:\n";
foreach ($result->requestClasses as $requestClass) {
    $path = writeFile($requestClass, $outputDir, $config->namespace);
    echo '  ✓ '.basename(dirname($path)).'/'.basename($path)."\n";
}

// Write DTOs (now Models!)
echo "\n🎯 Models:\n";
foreach ($result->dtoClasses as $dtoClass) {
    $path = writeFile($dtoClass, $outputDir, $config->namespace);
    echo '  ✓ '.basename($path)."\n";
}

// Write test files
if ($result->additionalFiles && is_array($result->additionalFiles)) {
    echo "\n🧪 Tests:\n";
    foreach ($result->additionalFiles as $file) {
        if ($file instanceof \Crescat\SaloonSdkGenerator\Data\TaggedOutputFile) {
            $testPath = __DIR__.'/../'.$file->path;

            // Create directory if it doesn't exist
            $dir = dirname($testPath);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            file_put_contents($testPath, $file->file);
            echo '  ✓ '.basename($testPath)."\n";
        }
    }
}

// Dump autoload to make new classes available
echo "\n";
passthru('composer dump-autoload --quiet');
