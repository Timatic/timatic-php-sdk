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

// Clean up generated test files (but keep Pest.php and TestCase.php)
$testsFolder = __DIR__.'/../tests';
if (is_dir($testsFolder)) {
    $testFiles = glob($testsFolder.'/*Test.php');
    foreach ($testFiles as $testFile) {
        unlink($testFile);
    }
    echo '  ✓ Removed generated test files'."\n";
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

// Create code generator with our custom JSON:API generators
echo "🏗️  Generating SDK with JSON:API models...\n";
$generator = new CodeGenerator(
    config: $config,
    connectorGenerator: new JsonApiConnectorGenerator($config),
    dtoGenerator: new JsonApiDtoGenerator($config),
    requestGenerator: new JsonApiRequestGenerator($config),
    resourceGenerator: new JsonApiResourceGenerator($config),
    postProcessors: [new JsonApiPestTestGenerator]
);

// Generate the code
$result = $generator->run($specification);

// Extract tests from result
$tests = $result->additionalFiles ?? null;

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

// Write connector
if ($result->connectorClass) {
    $path = writeFile($result->connectorClass, $outputDir, $config->namespace);
    echo "✓ Connector: {$path}\n";
}

// Post-process and write resources
echo "\n📦 Resources:\n";
foreach ($result->resourceClasses as $resourceClass) {
    $namespace = array_values($resourceClass->getNamespaces())[0];
    $classType = array_values($namespace->getClasses())[0];

    // Fix imports - add "Request" suffix to all Request class imports
    foreach ($namespace->getUses() as $alias => $fqn) {
        // Check if this is a Request class import
        if (str_contains($fqn, '\\Requests\\')) {
            $className = basename(str_replace('\\', '/', $fqn));
            // Add "Request" suffix if not already present
            if (! str_ends_with($className, 'Request')) {
                $newFqn = substr($fqn, 0, -strlen($className)).$className.'Request';
                $namespace->removeUse($fqn);
                $namespace->addUse($newFqn, $className.'Request');
            }
        }
    }

    // Fix POST/PUT/PATCH methods to add $data parameter and update class references
    foreach ($classType->getMethods() as $method) {
        $methodName = $method->getName();
        $body = $method->getBody();

        // Add "Request" suffix to class instantiations in method body
        $body = preg_replace_callback(
            '/\(new\s+(\w+)\(/',
            function ($matches) {
                $className = $matches[1];
                // Add "Request" suffix if not already present
                if (! str_ends_with($className, 'Request')) {
                    return '(new '.$className.'Request(';
                }

                return $matches[0];
            },
            $body
        );

        // Check if it's a mutation method (post/patch only, PUT is not supported)
        if (preg_match('/^(post|patch)/i', $methodName)) {
            // Add data parameter
            $method->addParameter('data')
                ->setType('\\Timatic\\SDK\\Foundation\\Model|array|null')
                ->setDefaultValue(null);

            // Update method body to pass $data to request constructor
            // Pattern 2 first: new Request($param) -> new Request($param, $data)
            // Must be checked before Pattern 1 to avoid double replacement
            if (preg_match('/\(new\s+\w+Request\([^)]+\)\)/', $body)) {
                $body = preg_replace(
                    '/\(new\s+(\w+Request)\(([^)]+)\)\)/',
                    '(new $1($2, $data))',
                    $body
                );
            } else {
                // Pattern 1: new Request() -> new Request($data)
                $body = preg_replace(
                    '/\(new\s+(\w+Request)\(\)\)/',
                    '(new $1($data))',
                    $body
                );
            }
        }

        $method->setBody($body);
    }

    $path = writeFile($resourceClass, $outputDir, $config->namespace);
    echo '  ✓ '.basename($path)."\n";
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
if ($tests && is_array($tests)) {
    echo "\n🧪 Tests:\n";
    foreach ($tests as $file) {
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
