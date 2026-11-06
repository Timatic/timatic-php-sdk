Make sure the package is compatible with Laravel 11, 12 and 13

## Timatic PHP SDK - Generated Files

This SDK is generated from the Timatic OpenAPI specification. **Do not edit generated files manually**; change the generator and regenerate instead.

### HTTP Methods Policy

This SDK **does not support PUT requests**. Only the following HTTP methods are supported:
- **POST** - Create new resources
- **PATCH** - Partially update existing resources
- **GET** - Retrieve resources
- **DELETE** - Remove resources

PUT is intentionally excluded as PATCH provides better semantics for partial updates in JSON:API applications. `composer regenerate` passes `--exclude-put-requests`, so PUT endpoints are skipped.

### Which Files Are Generated

`composer regenerate` deletes and recreates these directories on every run:
- `src/DataTransferObjects/`
- `src/Requests/`
- `Factories/`
- `tests/Requests/`

These are only rewritten by a manual `--foundation` run (see README), so treat them as generated too:
- `src/Foundation/` and `tests/Foundation/` (copied from the generator package)
- `src/TimaticConnector.php`, `src/Providers/`, `config/`, `tests/TestCase.php`

Everything else can be edited, e.g. `tests/Feature/`, `tests/Factories/`, `tests/Pagination/`, `tests/Pest.php`, `README.md`.

## SDK Regeneration Commands

**IMPORTANT:** Always use `composer regenerate` to regenerate the SDK.

```bash
composer regenerate
composer test
```

**What `composer regenerate` does:**
1. Empties the generated directories listed above
2. Runs `php generator/generator generate:sdk openapi.json` (companion LaravelZero app in `generator/`, run `composer install` there once)
3. Generates DTOs, Requests, Pest tests and factories from the local `openapi.json` (export it from timatic-backend with `php artisan scramble:export`, see README)
4. Updates the autoloader with `composer dump-autoload`
5. Formats all code with Laravel Pint

## Modifying Generated Code

Change the generators in the `timatic/jsonapi-sdk-generator` package (github Timatic/json-api-php-sdk-generator), which builds on `timatic/saloon-sdk-generator` (github Timatic/saloon-sdk-generator). Timatic-specific overrides belong in `generator/app/`. Both packages are installed from their GitHub `main` branch.

### Generator Mapping per Directory:

| Directory | Generator (in JsonApiSdkGenerator) | Description |
|-----------|-----------|-------------|
| `src/TimaticConnector.php` | `Generators/JsonApiConnectorGenerator.php` | Connector with JSON:API headers, token auth and pagination. |
| `src/DataTransferObjects/` | `Generators/JsonApiDtoGenerator.php` | Spatie Data DTOs. Read DTOs come from the resource schemas, with JSON:API attributes flattened into typed properties and relationships marked with `#[JsonApiRelationship]`. Write DTOs (`New{Entity}`, `Update{Entity}`) come from the request body schema of each store/update endpoint. Every DTO gets `#[JsonApiType]`. |
| `src/Requests/` | `Generators/JsonApiRequestGenerator.php` | Saloon requests. Store/update requests take their write DTO; collection requests get `Paginatable`, `HasFilters` and `include*()` methods. |
| `tests/Requests/` | `Generators/JsonApiPestTestGenerator.php` | Pest tests for all endpoints. |
| `Factories/` | `Generators/JsonApiFactoryGenerator.php` | Faker factories for all DTOs. |
| `src/Foundation/` | `Foundation/` (copied by `Services/FoundationCopier.php`) | Serializer, transformer, paginator, response and factory base classes. |

After modifying generators, regenerate and test:
```bash
composer regenerate
composer test
```
