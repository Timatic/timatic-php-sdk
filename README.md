# Timatic PHP SDK

[![Tests](https://github.com/Timatic/timatic-php-sdk/actions/workflows/tests.yml/badge.svg)](https://github.com/Timatic/timatic-php-sdk/actions/workflows/tests.yml)
[![codecov](https://codecov.io/gh/Timatic/timatic-php-sdk/branch/main/graph/badge.svg)](https://codecov.io/gh/Timatic/timatic-php-sdk)
[![Code Style](https://github.com/Timatic/timatic-php-sdk/actions/workflows/code-style.yml/badge.svg)](https://github.com/Timatic/timatic-php-sdk/actions/workflows/code-style.yml)
[![Static Analysis](https://github.com/Timatic/timatic-php-sdk/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/Timatic/timatic-php-sdk/actions/workflows/static-analysis.yml)

A Laravel package for the Timatic API, built with [Saloon](https://docs.saloon.dev/) and automatically generated from OpenAPI specifications.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
  - [Using Dependency Injection](#using-dependency-injection)
  - [Testing](#testing)
  - [Pagination](#pagination)
  - [Custom Response Methods](#custom-response-methods)
- [HTTP Methods](#http-methods)
- [Available Resources](#available-resources)
- [JSON:API Support](#jsonapi-support)
  - [Model Features](#model-features)
  - [Working with Relationships](#working-with-relationships)
- [Regenerating the SDK](#regenerating-the-sdk)
- [Development](#development)
- [License](#license)
- [Credits](#credits)

## Requirements

- PHP 8.2 or higher
- Laravel 11.x or higher

## Installation

```bash
composer require timatic/php-sdk
```

## Configuration

The package automatically registers itself via Laravel auto-discovery.

Publish the config file:

```bash
php artisan vendor:publish --tag=timatic-config
```

Add your API credentials to `.env`:

```env
TIMATIC_BASE_URL=https://api.app.timatic.test
TIMATIC_API_TOKEN=your-api-token-here
```

## Usage

### Using Dependency Injection

The SDK connector is automatically registered in Laravel's service container, making it easy to inject into your controllers, commands, and other classes:

```php
use Timatic\Requests\Budget\GetBudgetsCollectionRequest;
use Timatic\Requests\Budget\GetBudgetRequest;
use Timatic\Requests\Budget\PostBudgetsRequest;
use Timatic\Requests\BudgetType\GetBudgetTypesCollectionRequest;

use Timatic\TimaticConnector;

class BudgetController extends Controller
{
    public function __construct(
        protected TimaticConnector $timatic
    ) {}

    public function index()
    {
        // fetch one or more items, limited by the default page size from the api
        $budgetTypes = $this->timatic
            ->send(new GetBudgetTypesCollectionRequest())
            ->dto();
            
        $defaultBudget = $this->timatic->send(
            new \Timatic\Requests\Budget\GetBudgetRequest(id: '1337')
        )->dtoOrFail();
    
        // fetch all DTO's
        $budgets = $this->timatic->paginate(new GetBudgetsCollectionRequest())
            ->dtoCollection();

        return view('budgets.index', compact('budgets', 'budgetTypes', 'defaultBudget'));
    }

    public function store(Request $request)
    {
        $budget = new \Timatic\Dto\Budget([
            'title' => $request->input('title'),
            'totalPrice' => $request->input('total_price'),
        ]);

        $created = $this->timatic
            ->send(new PostBudgetsRequest($budget))
            ->dtoOrFail();

        return redirect()->route('budgets.show', $created->id);
    }
}
```

**In Console Commands:**

```php
use \Timatic\Requests\Budget\GetBudgetsCollectionRequest;
use Timatic\TimaticConnector;

class SyncBudgetsCommand extends Command
{
    public function handle(TimaticConnector $timatic): int
    {
        $budgets = $timatic->paginate(
            new GetBudgetsCollectionRequest()
        )->dtoCollection()
        
        foreach ($budgets as $budget) {
            // Process budgets
        }

        return Command::SUCCESS;
    }
}
```

### Testing

When testing code that uses the Timatic SDK, you can mock the connector and its responses using factories. The SDK includes factory classes for all DTOs that make it easy to generate test data.

Here's an example of testing the `BudgetController` from the example above:

```php
use Timatic\TimaticConnector;
use Timatic\Dto\Budget;
use Timatic\Dto\BudgetType;
use Timatic\Requests\Budget\GetBudgetsRequest;
use Timatic\Requests\Budget\PostBudgetsRequest;
use Timatic\Requests\BudgetType\GetBudgetTypesRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('it displays budgets and budget types', function () {
    // Generate test data using factories
    $budget = Budget::testFactory()->state(['id' => '1'])->make();
    $budgetType = BudgetType::testFactory()->state(['id' => '1'])->make();

    // Create mock responses using factory-generated data
    $mockClient = MockClient::global([
        GetBudgetsRequest::class => MockResponse::make([
            'data' => [JsonApiSerializer::toJsonApi($budget)],
        ], 200),
        GetBudgetTypesRequest::class => MockResponse::make([
            'data' => [JsonApiSerializer::toJsonApi($budgetType)],
        ], 200),
    ]);

    // Make request
    $response = $this->get(route('budgets.index'));

    // Assert
    $response->assertOk();
    $response->assertViewHas('budgets');
    $response->assertViewHas('budgetTypes');
});

test('it creates a new budget', function () {
    // Generate test data with specific attributes
    $budget = Budget::testFactory()->state([
        'id' => '2',
        'title' => 'New Budget',
        'totalPrice' => '5000.00',
    ])->make();

    $mockClient = MockClient::global([
        PostBudgetsRequest::class => MockResponse::make([
            'data' => JsonApiSerializer::toJsonApi($budget),
        ], 201),
    ]);

    $response = $this->post(route('budgets.store'), [
        'title' => 'New Budget',
        'total_price' => 5000.00,
    ]);

    $response->assertRedirect(route('budgets.show', '2'));
});

test('it sends a POST request to create a budget using the SDK', function () {
    $budgetToCreate = Budget::testFactory()->state([
        'title' => 'New Budget',
        'totalPrice' => '5000.00',
        'customerId' => 'customer-123',
    ])->make();

    $createdBudget = Budget::testFactory()->state([
        'id' => 'created-456',
        'title' => 'New Budget',
        'totalPrice' => '5000.00',
        'customerId' => 'customer-123',
    ])->make();

    $mockClient = MockClient::global([
        PostBudgetsRequest::class => MockResponse::make([
            'data' => JsonApiSerializer::toJsonApi($createdBudget),
        ], 201),
    ]);

    artisan('sync:budgets')->assertOk();

    // Assert the request body was sent correctly
    $mockClient->assertSent(function (PostBudgetsRequest $request) {
        $body = $request->body()->all();

        return $body['data']['attributes']['title'] === 'New Budget'
            && $body['data']['attributes']['totalPrice'] === '5000.00'
            && $body['data']['attributes']['customerId'] === 'customer-123';
    });
});
```

#### Factory Methods

Every DTO in the SDK has a corresponding factory class with the following methods:

```php
// Create a single model with random data, without an ID
$budget = Budget::testFactory()->make();

// Create multiple models with unique UUID IDs
$budgets = Budget::testFactory()->withId()->count(3)->make(); // Returns Collection

// Override specific attributes
$budget = Budget::testFactory()->state([
    'title' => 'Q1 Budget',
    'totalPrice' => '10000.00',
])->make();

// Chain state calls for complex scenarios
$budget = Budget::testFactory()
    ->state(['customerId' => $customerId])
    ->state(['budgetTypeId' => $budgetTypeId])
    ->make();
```

For more information on mocking Saloon requests, see the [Saloon Mocking Documentation](https://docs.saloon.dev/testing/faking-responses).

### Pagination

The SDK supports automatic pagination for all collection endpoints using Saloon's pagination plugin:

```php
use Timatic\TimaticConnector;
use Timatic\Requests\Budget\GetBudgets;

class BudgetController extends Controller
{
    public function index(TimaticConnector $timatic)
    {
        // Create a paginator
        $paginator = $timatic->paginate(new GetBudgets());

        // Optionally set items per page (default is API's default)
        $paginator->setPerPageLimit(50);

        // Iterate through all pages automatically
        foreach ($paginator->items() as $budget) {
            // Process each budget across all pages
            // The paginator handles pagination automatically
        }

        // Or collect all items at once
        $allBudgets = $paginator->dtoCollection();
    }
}
```

The paginator:
- Automatically handles JSON:API pagination (`page[number]` and `page[size]`)
- Detects the last page via `links.next`
- Works with all GET collection requests (GetBudgets, GetCustomers, GetUsers, etc.)

### Custom Response Methods

All responses are instances of `TimaticResponse` which extends Saloon's Response with JSON:API convenience methods:

```php
$response = $timatic->send(new GetBudgetsCollectionRequest());

// Get the first item from a collection
$firstBudget = $response->firstItem();

// Check for errors
if ($response->hasErrors()) {
    $errors = $response->errors();
    // Handle errors...
}

// Access JSON:API meta information
$meta = $response->meta();
$total = $meta['total'] ?? 0;

// Access pagination links
$links = $response->links();
$nextPage = $links['next'] ?? null;

// Access included resources
$included = $response->included();
foreach ($included as $resource) {
    // Process related resources
}
```

## HTTP Methods

This SDK follows REST best practices and **does not support PUT requests**. Instead:

- **POST** - Create new resources
- **PATCH** - Partially update existing resources
- **GET** - Retrieve resources
- **DELETE** - Remove resources

PUT is intentionally excluded because resources are never completely replaced by Timatic.

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
- **Relationship support** with automatic hydration and serialization

### Working with Relationships

The SDK automatically handles JSON:API relationships, providing seamless access to related models with full type safety.

#### Accessing Relationships

When you fetch a model with included relationships, they're automatically hydrated into typed properties:

```php
use Timatic\Requests\User\GetUserRequest;

// Fetch a user with their team included
$request = new GetUserRequest(id: '123');
$request->query()->add('include', 'team');

$user = $timatic->send($request)->dtoOrFail();

// Access the relationship - it's already a Team object!
$team = $user->team; // Team instance
echo $team->name; // "Engineering"
```

#### Serializing Relationships

When creating or updating resources with relationships, the SDK automatically serializes them to JSON:API format:

```php
use Timatic\Dto\User;
use Timatic\Dto\Team;
use Timatic\Requests\User\PatchUserRequest;

// Fetch existing models
$user = $timatic->send(new GetUserRequest(id: '123'))->dtoOrFail();
$team = $timatic->send(new GetTeamRequest(id: '456'))->dtoOrFail();

// Update the relationship
$user->team = $team;

// Send the update - relationships are automatically serialized
$updated = $timatic->send(new PatchUserRequest(id: $user->id, data: $user))->dtoOrFail();
```

The `toJsonApi()` method automatically converts relationships to the correct JSON:API format:

```php
JsonApiSerializer::toJsonApi($user);
// Returns:
// [
//     'type' => 'users',
//     'id' => '123',
//     'attributes' => [
//         'email' => 'john@example.com',
//         'givenName' => 'John',
//         // ...
//     ],
//     'relationships' => [
//         'team' => [
//             'data' => ['type' => 'teams', 'id' => '456']
//         ]
//     ]
// ]
```


#### Included Resources

To fetch relationships, use the `include` query parameter:

```php
// Include a single relationship
$request = new GetUserRequest(id: '123');
$request->query()->add('include', 'team');

// Include multiple relationships
$request->query()->add('include', 'team,permissions');

// Include nested relationships
$request->query()->add('include', 'team.users');

$user = $timatic->send($request)->dtoOrFail();
```

The SDK automatically hydrates all included resources into their respective relationship properties.

## Regenerating the SDK

The SDK is generated from the Timatic OpenAPI spec by a companion [LaravelZero](https://laravel-zero.com/) app in `generator/`, which wraps [timatic/jsonapi-sdk-generator](https://github.com/Timatic/json-api-php-sdk-generator).

First-time setup:

```bash
cd generator && composer install
```

Export the spec from a local `timatic-backend` checkout to `openapi.json` (gitignored) and regenerate:

```bash
(cd ../timatic-backend && docker compose exec -T app php artisan scramble:export --path=storage/api.json && mv storage/api.json ../timatic-php-sdk/openapi.json)
composer regenerate
```

`composer regenerate` rewrites `src/Dto`, `src/Requests`, `Factories` and `tests/Requests`. To also rewrite `src/Foundation`, the connector, service provider and config, run the generator with `--foundation --connector-name=TimaticConnector --base-url=https://api.tenant.timatic.app` and revert the `composer.json` changes it makes.

## Development

### Running Tests

```bash
# Run tests
composer test

# Run tests with code coverage
composer coverage
```

## License

This package is licensed under the Elastic License 2.0 (ELv2).

## Credits

- Built with [Saloon](https://docs.saloon.dev/)
- Generated using [Saloon SDK Generator](https://docs.saloon.dev/installable-plugins/sdk-generator)
