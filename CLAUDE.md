Make sure the package is compatible with Laravel 10, 11 and 12

## Timatic PHP SDK - Auto-Generated Files

This SDK is automatically generated from the OpenAPI specification. **DO NOT manually edit auto-generated files**.

### HTTP Methods Policy

This SDK **does not support PUT requests**. Only the following HTTP methods are supported:
- **POST** - Create new resources
- **PATCH** - Partially update existing resources
- **GET** - Retrieve resources
- **DELETE** - Remove resources

PUT is intentionally excluded as PATCH provides better semantics for partial updates in JSON:API applications. The generator will throw an exception if it encounters PUT endpoints.

### 🔍 How to Tell if a File Can Be Edited

**Simple Rule:** Check the file header. If it contains `// auto-generated`, **DO NOT edit it manually**.

```php
<?php // auto-generated   // ← DO NOT EDIT files with this marker

declare(strict_types=1);

namespace Timatic\Dto;
// ...
```

**Why?** The generator uses this marker to identify files it should clean up and regenerate. Files with this marker will be **deleted and recreated** on every regeneration.

### ✅ Files You CAN Edit:
- Any file **without** the `// auto-generated` marker
- Examples: `src/Concerns/`, `src/Attributes/`, `src/Responses/`, `src/Pagination/`, `src/Providers/`, `src/Facades/`, `config/`, `tests/Pest.php`, `tests/TestCase.php`, etc.

### ❌ Files You CANNOT Edit:
- Any file **with** the `// auto-generated` marker
- These are typically in: `src/Dto/`, `src/Requests/`, `src/Resource/`, `src/TimaticConnector.php`, `tests/*Test.php`, `Factories/`
- To change these files, modify the appropriate generator instead (see below)

## SDK Regeneration Commands

**IMPORTANT:** Always use `composer regenerate` to regenerate the SDK.

To update auto-generated files from the latest OpenAPI spec:

```bash
# Run the regenerate script (handles all steps)
composer regenerate

# Verify with tests
composer test
```

**What `composer regenerate` does:**
1. Runs `php generator/generator generate:sdk openapi.json` (companion LaravelZero app in `generator/`, run `composer install` there once)
2. Generates DTOs, Requests, Pest tests and factories from the local `openapi.json` (export it from timatic-backend with `php artisan scramble:export`, see README)
3. Updates autoloader with `composer dump-autoload`
4. Formats all code with Laravel Pint

Foundation, connector, provider and config are only rewritten with `--foundation` (see README).

## Modifying Auto-Generated Code

If you need to change how files are generated, modify the generators in the `timatic/jsonapi-sdk-generator` package (github Timatic/json-api-php-sdk-generator). Timatic-specific overrides belong in `generator/app/`.

### Generator Mapping per Directory:

| Directory | Generator (in JsonApiSdkGenerator) | Description |
|-----------|-----------|-------------|
| `src/TimaticConnector.php` | `Generators/JsonApiConnectorGenerator.php` | Generates the main Connector with JSON:API configuration, pagination support, and custom headers. |
| `src/Dto/` | `Generators/JsonApiDtoGenerator.php` | Generates Models from OpenAPI schemas. Flattens JSON:API attributes into typed properties. Adds `#[Property]` and `#[DateTime]` attributes. |
| `src/Requests/` | `Generators/JsonApiRequestGenerator.php` | Generates Request classes. Adds Model support for POST/PATCH. Adds `Paginatable` interface to GET collections. |
| `src/Resource/` | `Generators/JsonApiResourceGenerator.php` | Generates Resource classes with `$data` parameters on POST/PATCH methods. |
| `tests/*Test.php` | `Generators/JsonApiPestTestGenerator.php` | Generates Pest test files for all endpoints. |
| `factories/` | `Generators/JsonApiFactoryGenerator.php` | Generates Faker factories for all DTOs. |

After modifying generators, regenerate and test:
```bash
composer regenerate
composer test
```
