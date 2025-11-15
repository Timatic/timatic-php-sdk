# Timatic PHP SDK

A PHP SDK for the Timatic API, built with [Saloon](https://docs.saloon.dev/) and automatically generated from OpenAPI specifications.

## Installation

```bash
composer require timatic/php-sdk
```

## Usage

```php
use Timatic\SDK\Timatic;

// Initialize the SDK
$timatic = new Timatic();

// Example: Get users
$response = $timatic->user()->getUsers();
$users = $response->json();

// Example: Get a specific customer
$response = $timatic->customer()->getCustomer(id: 1);
$customer = $response->json();

// Example: Create a new budget
$response = $timatic->budget()->postBudgets([
    'name' => 'Q1 2024 Budget',
    // ... other budget data
]);
```

## Available Resources

The SDK provides access to the following resources:

- **Budgets** - Manage budgets and budget entries
- **Customers** - Customer management
- **Users** - User management
- **Teams** - Team management
- **Entries** - Time entry management
- **Incidents** - Incident tracking
- **Changes** - Change tracking
- **Overtimes** - Overtime management
- **Events** - Event logging
- And more...

## JSON:API Support

This SDK uses a custom **JSON:API DTO Generator** that automatically flattens JSON:API attributes into proper Model properties. Instead of having generic `$attributes`, `$type`, and `$relationships` objects, each model has specific typed properties.

### Example

Instead of:
```php
$budget->attributes->title; // ❌ Generic structure
```

You get:
```php
$budget->title; // ✅ Proper typed property
$budget->budgetTypeId;
$budget->startedAt; // Carbon instance for datetime fields
```

### Model Features

- **Extends `Model` base class** with JSON:API support
- **Property attributes** via `#[Property]` for serialization
- **DateTime handling** with Carbon instances
- **Type safety** with PHP 8.1+ type hints
- **HasAttributes trait** for easy attribute manipulation

## Regenerating the SDK

This SDK is automatically generated from the Timatic API OpenAPI specification using a custom JSON:API generator. To regenerate the SDK with the latest API changes:

```bash
./regenerate-sdk.sh
```

This will:
1. Download the latest OpenAPI specification from the API
2. Generate Models with flattened JSON:API attributes
3. Update the autoloader

### How It Works

The SDK uses a custom `JsonApiDtoGenerator` that:
1. Detects JSON:API schemas in the OpenAPI specification
2. Extracts properties from the `attributes` object
3. Generates proper Model classes with specific properties
4. Adds `#[Property]` and `#[DateTime]` attributes
5. Uses Carbon for datetime fields

## Development

### Running Tests

```bash
composer test
```

## License

This package is licensed under the Elastic License 2.0 (ELv2).

## Credits

- Built with [Saloon](https://docs.saloon.dev/)
- Generated using [Saloon SDK Generator](https://docs.saloon.dev/installable-plugins/sdk-generator)
