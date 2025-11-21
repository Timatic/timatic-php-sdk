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

    // Fix class references: add "Request" suffix to class instantiations in method body
    foreach ($classType->getMethods() as $method) {
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

        // Fix mutation methods that have $data parameter but don't pass it
        $methodName = $method->getName();
        if (preg_match('/^(post|patch)/i', $methodName) && $method->hasParameter('data')) {
            // Check if Request instantiation exists without $data parameter
            // Matches: new PostBudgetsRequest() or new PostBudgetsRequest (without parens)
            if (preg_match('/new\s+\w+Request\(\s*\)/', $body)) {
                // Has empty parens: replace () with ($data)
                $body = preg_replace(
                    '/new\s+(\w+Request)\(\s*\)/',
                    'new $1($data)',
                    $body
                );
            } elseif (preg_match('/new\s+\w+Request(?![(\w])/', $body)) {
                // No parens: add ($data)
                $body = preg_replace(
                    '/new\s+(\w+Request)(?![(\w])/',
                    'new $1($data)',
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

// Write test files (also apply path parameter transformations here as fallback)
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

            // Apply path parameter transformations (as fallback if generator didn't do it)
            $testContent = $file->file;
            $resourceNames = [
                'budget', 'customer', 'user', 'team', 'entry', 'entrySuggestion',
                'correction', 'change', 'incident', 'overtime',
            ];

            foreach ($resourceNames as $resourceName) {
                $testContent = preg_replace(
                    "/\b{$resourceName}:\s*(['\"])/",
                    "{$resourceName}Id: $1",
                    $testContent
                );
            }

            file_put_contents($testPath, $testContent);
            echo '  ✓ '.basename($testPath)."\n";
        }
    }
}
