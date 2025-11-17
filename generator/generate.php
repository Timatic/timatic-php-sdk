<?php

declare(strict_types=1);

// Use global composer autoload for SDK generator
require_once $_SERVER['HOME'].'/.composer/vendor/autoload.php';
// Also load local vendor for our custom generators
require_once __DIR__.'/../vendor/autoload.php';

use Crescat\SaloonSdkGenerator\CodeGenerator;
use Crescat\SaloonSdkGenerator\Data\Generator\Config;
use Crescat\SaloonSdkGenerator\Factory;
use Timatic\SDK\Generator\JsonApiDtoGenerator;
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
    dtoGenerator: new JsonApiDtoGenerator($config),
    requestGenerator: new JsonApiRequestGenerator($config),
    resourceGenerator: new JsonApiResourceGenerator($config)
);

// Generate the code
$result = $generator->run($specification);

// Tests are not generated in this version (requires SDK generator v1.4+)
// You can manually add Pest tests for JSON:API validation
$tests = null;

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
    // Fix POST/PUT/PATCH methods to add $data parameter
    $namespace = array_values($resourceClass->getNamespaces())[0];
    $classType = array_values($namespace->getClasses())[0];

    foreach ($classType->getMethods() as $method) {
        $methodName = $method->getName();

        // Check if it's a mutation method (post/patch only, PUT is not supported)
        if (preg_match('/^(post|patch)/i', $methodName)) {
            // Add data parameter
            $method->addParameter('data')
                ->setType('\\Timatic\\SDK\\Foundation\\Model|array|null')
                ->setDefaultValue(null);

            // Update method body to pass $data to request constructor
            $body = $method->getBody();

            // Pattern 2 first: new Request($param) -> new Request($param, $data)
            // Must be checked before Pattern 1 to avoid double replacement
            if (preg_match('/\(new\s+\w+\([^)]+\)\)/', $body)) {
                $body = preg_replace(
                    '/\(new\s+(\w+)\(([^)]+)\)\)/',
                    '(new $1($2, $data))',
                    $body
                );
            } else {
                // Pattern 1: new Request() -> new Request($data)
                $body = preg_replace(
                    '/\(new\s+(\w+)\(\)\)/',
                    '(new $1($data))',
                    $body
                );
            }

            $method->setBody($body);
        }
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
