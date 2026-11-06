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
  - [Read and write DTOs](#read-and-write-dtos)
  - [Testing](#testing)
  - [Pagination](#pagination)
  - [Filtering and Includes](#filtering-and-includes)
  - [Response Methods](#response-methods)
- [HTTP Methods](#http-methods)
- [Available Resources](#available-resources)
- [JSON:API Support](#jsonapi-support)
  - [Relationships](#relationships)
- [Regenerating the SDK](#regenerating-the-sdk)
- [Development](#development)
- [License](#license)
- [Credits](#credits)

## Requirements

- PHP 8.2 or higher
- Laravel 12.39 or higher

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

The connector is registered in Laravel's service container, so you can inject it into controllers, commands and other classes:

```php
use Timatic\DataTransferObjects\NewBudget;
use Timatic\Requests\Budget\BudgetsCollectionRequest;
use Timatic\Requests\Budget\BudgetsShowRequest;
use Timatic\Requests\Budget\BudgetsStoreRequest;
use Timatic\Requests\BudgetType\BudgetTypesCollectionRequest;
use Timatic\TimaticConnector;

class BudgetController extends Controller
{
    public function __construct(
        protected TimaticConnector $timatic
    ) {}

    public function index()
    {
        // One page of items, limited by the API's default page size
        $budgetTypes = $this->timatic
            ->send(new BudgetTypesCollectionRequest)
            ->dto();

        $defaultBudget = $this->timatic
            ->send(new BudgetsShowRequest(budgetId: 1337))
            ->dtoOrFail();

        // All items across all pages
        $budgets = $this->timatic
            ->paginate(new BudgetsCollectionRequest)
            ->dtoCollection();

        return view('budgets.index', compact('budgets', 'budgetTypes', 'defaultBudget'));
    }

    public function store(Request $request)
    {
        $budget = new NewBudget(
            title: $request->input('title'),
            totalPrice: $request->input('total_price'),
            customerId: $request->integer('customer_id'),
        );

        $created = $this->timatic
            ->send(new BudgetsStoreRequest($budget))
            ->dtoOrFail();

        return redirect()->route('budgets.show', $created->id);
    }
}
```

**In Console Commands:**

```php
use Timatic\Requests\Budget\BudgetsCollectionRequest;
use Timatic\TimaticConnector;

class SyncBudgetsCommand extends Command
{
    public function handle(TimaticConnector $timatic): int
    {
        $budgets = $timatic->paginate(new BudgetsCollectionRequest)->dtoCollection();

        foreach ($budgets as $budget) {
            // Process budgets
        }

        return Command::SUCCESS;
    }
}
```

### Read and write DTOs

Responses are hydrated into a read DTO per resource, such as `Budget`, `Entry` or `User`. Store and update requests take a separate write DTO, generated from the request body schema of that endpoint:

| Request | Body DTO |
|---|---|
| `BudgetsStoreRequest` | `NewBudget` |
| `BudgetsUpdateRequest` | `UpdateBudget` |
| `EntriesStoreRequest` | `NewEntry` |
| `EntriesUpdateRequest` | `UpdateEntry` |

Write DTOs only contain the fields the API accepts, typed as the API expects them. For example, `NewEntry` has `hasOvertime` and an integer `customerId`, while the `Entry` read DTO has `minutesSpent` and a string `customerId`.

### Testing

Every DTO has a factory, so you can build test data and fake API responses with Saloon's `MockClient`.

Here's an example of testing the `BudgetController` from above:

```php
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Request;
use Timatic\DataTransferObjects\Budget;
use Timatic\DataTransferObjects\BudgetType;
use Timatic\Foundation\JsonApi\JsonApiSerializer;
use Timatic\Requests\Budget\BudgetsCollectionRequest;
use Timatic\Requests\Budget\BudgetsShowRequest;
use Timatic\Requests\Budget\BudgetsStoreRequest;
use Timatic\Requests\BudgetType\BudgetTypesCollectionRequest;

test('it displays budgets and budget types', function () {
    $budget = Budget::testFactory()->state(['id' => '1'])->make();
    $budgetType = BudgetType::testFactory()->state(['id' => '1'])->make();

    MockClient::global([
        BudgetsCollectionRequest::class => MockResponse::make([
            'data' => [JsonApiSerializer::toJsonApi($budget)],
        ]),
        BudgetsShowRequest::class => MockResponse::make([
            'data' => JsonApiSerializer::toJsonApi($budget),
        ]),
        BudgetTypesCollectionRequest::class => MockResponse::make([
            'data' => [JsonApiSerializer::toJsonApi($budgetType)],
        ]),
    ]);

    $this->get(route('budgets.index'))
        ->assertOk()
        ->assertViewHas('budgets')
        ->assertViewHas('budgetTypes');
});

test('it creates a new budget', function () {
    $createdBudget = Budget::testFactory()->state(['id' => '2'])->make();

    $mockClient = MockClient::global([
        BudgetsStoreRequest::class => MockResponse::make([
            'data' => JsonApiSerializer::toJsonApi($createdBudget),
        ], 201),
    ]);

    $this->post(route('budgets.store'), [
        'title' => 'New Budget',
        'total_price' => 5000,
        'customer_id' => 123,
    ])->assertRedirect(route('budgets.show', '2'));

    $mockClient->assertSent(function (Request $request) {
        $attributes = $request->body()->all()['data']['attributes'];

        return $attributes['title'] === 'New Budget'
            && $attributes['totalPrice'] === 5000
            && $attributes['customerId'] === 123;
    });
});
```

#### Factory Methods

```php
// A single DTO with random data, without an ID
$budget = Budget::testFactory()->make();

// Multiple DTOs with unique UUID IDs
$budgets = Budget::testFactory()->withId()->count(3)->make(); // Collection

// Override specific attributes
$budget = Budget::testFactory()->state([
    'title' => 'Q1 Budget',
    'totalPrice' => '10000.00',
])->make();

// Write DTOs have factories too
$entry = NewEntry::testFactory()->state(['hasOvertime' => false])->make();
```

For more on mocking, see the [Saloon testing documentation](https://docs.saloon.dev/testing/faking-responses).

### Pagination

Every collection request supports pagination through Saloon's pagination plugin:

```php
$paginator = $timatic->paginate(new BudgetsCollectionRequest);

// Optional; defaults to the API's page size
$paginator->setPerPageLimit(50);

// Iterate over all pages lazily
foreach ($paginator->items() as $budget) {
    // ...
}

// Or collect all DTOs at once
$allBudgets = $paginator->dtoCollection();
```

The paginator uses JSON:API pagination (`page[number]` and `page[size]`) and stops when `links.next` is empty.

### Filtering and Includes

Collection requests that support it have `filter()` and typed `include*()` methods:

```php
use Timatic\Foundation\Filtering\Operator;

$request = (new EntriesCollectionRequest)
    ->filter('userId', '42')
    ->filter('startedAt', '2026-01-01', Operator::GreaterThanOrEquals)
    ->includeBudget();

$entries = $timatic->paginate($request)->dtoCollection();
```

### Response Methods

Responses are `JsonApiResponse` instances, which add JSON:API helpers to Saloon's `Response`:

```php
$response = $timatic->send(new BudgetsCollectionRequest);

$firstBudget = $response->firstItem();

if ($response->hasErrors()) {
    $errors = $response->errors();
}

$meta = $response->meta();
$links = $response->links();
$included = $response->included();
```

## HTTP Methods

The SDK has no PUT requests. It uses:

- **POST** to create resources
- **PATCH** to partially update resources
- **GET** to retrieve resources
- **DELETE** to remove resources

PUT is left out because Timatic never replaces a resource completely.

## Available Resources

Budgets, budget types, corrections, customers, entries, entry suggestions, events, export formats, overtimes, Jira project mappings, suggestion integrations, teams, tickets, tracked domains and users. See `src/Requests` for every request.

## JSON:API Support

DTOs are [Spatie Data](https://spatie.be/docs/laravel-data) objects. The JSON:API envelope is flattened, so attributes are typed properties:

```php
$budget->title;        // instead of $budget->attributes->title
$budget->budgetTypeId;
$budget->startedAt;    // Carbon instance
```

### Relationships

Relationships are typed properties marked with `#[JsonApiRelationship]`. Included resources are hydrated into them:

```php
$users = $timatic
    ->send((new UsersCollectionRequest)->includeTeam())
    ->dto();

$users->first()->team; // Team instance
```

When you send a DTO, `JsonApiSerializer` turns its relationships into resource identifiers:

```php
use Timatic\DataTransferObjects\UpdateUser;

$team = $timatic->send(new TeamsShowRequest(teamId: '456'))->dtoOrFail();

$timatic->send(new UsersUpdateRequest(
    userId: '123',
    data: new UpdateUser(team: $team),
));

// Sends:
// [
//     'data' => [
//         'type' => 'users',
//         'attributes' => [],
//         'relationships' => [
//             'team' => ['data' => ['type' => 'teams', 'id' => '456']],
//         ],
//     ],
// ]
```

The JSON:API `type` comes from the `#[JsonApiType]` attribute on each DTO.

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

`composer regenerate` rewrites `src/DataTransferObjects`, `src/Requests`, `Factories` and `tests/Requests`. To also rewrite `src/Foundation`, the connector, service provider and config, run the generator with `--foundation --connector-name=TimaticConnector --base-url=https://api.tenant.timatic.app` and revert the `composer.json` changes it makes (it normalizes the file and pins `ergebnis/composer-normalize`).

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
- Generated using [timatic/jsonapi-sdk-generator](https://github.com/Timatic/json-api-php-sdk-generator), built on [Saloon SDK Generator](https://docs.saloon.dev/installable-plugins/sdk-generator)
