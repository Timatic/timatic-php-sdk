<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Crescat\SaloonSdkGenerator\CodeGenerator;
use Crescat\SaloonSdkGenerator\Data\Generator\Config;
use Crescat\SaloonSdkGenerator\Factory;
use Timatic\SDK\Generator\JsonApiDtoGenerator;

// Download OpenAPI spec
echo "📥 Downloading OpenAPI specification...\n";
$openApiJson = file_get_contents('https://api.app.timatic.test/docs/json', false, stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]));

if (!$openApiJson) {
    echo "❌ Failed to download OpenAPI specification\n";
    exit(1);
}

file_put_contents(__DIR__ . '/../openapi.json', $openApiJson);
echo "✅ OpenAPI specification downloaded\n\n";

// Parse the specification
echo "🔨 Parsing OpenAPI specification...\n";
$specification = Factory::parse('openapi', __DIR__ . '/../openapi.json');
echo "✅ Specification parsed\n\n";

// Create config
$config = new Config(
    connectorName: 'Timatic',
    namespace: 'Timatic\\SDK',
    resourceNamespaceSuffix: 'Resource',
    requestNamespaceSuffix: 'Requests',
    dtoNamespaceSuffix: 'Dto',
);

// Create code generator with our custom JSON:API DTO generator
echo "🏗️  Generating SDK with JSON:API models...\n";
$generator = new CodeGenerator(
    config: $config,
    dtoGenerator: new JsonApiDtoGenerator($config)
);

// Generate the code
$result = $generator->run($specification);

// Output directory
$outputDir = __DIR__ . '/../src';

// Helper function to write files
function writeFile($file, $outputDir, $namespace) {
    $relativePath = str_replace($namespace, '', array_values($file->getNamespaces())[0]->getName());
    $className = array_values($file->getClasses())[0]->getName();
    $filePath = $outputDir . str_replace('\\', '/', $relativePath) . '/' . $className . '.php';

    // Create directory if it doesn't exist
    $dir = dirname($filePath);
    if (!is_dir($dir)) {
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

// Write resources
echo "\n📦 Resources:\n";
foreach ($result->resourceClasses as $resourceClass) {
    $path = writeFile($resourceClass, $outputDir, $config->namespace);
    echo "  ✓ " . basename($path) . "\n";
}

// Write requests
echo "\n📝 Requests:\n";
foreach ($result->requestClasses as $requestClass) {
    $path = writeFile($requestClass, $outputDir, $config->namespace);
    echo "  ✓ " . basename(dirname($path)) . '/' . basename($path) . "\n";
}

// Write DTOs (now Models!)
echo "\n🎯 Models:\n";
foreach ($result->dtoClasses as $dtoClass) {
    $path = writeFile($dtoClass, $outputDir, $config->namespace);
    echo "  ✓ " . basename($path) . "\n";
}

echo "\n✅ SDK generation complete!\n";
echo "\n💡 Next steps:\n";
echo "   1. Run 'composer dump-autoload'\n";
echo "   2. Review generated models in src/Dto/\n";
echo "   3. Test the SDK\n";
