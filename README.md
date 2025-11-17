# Timatic PHP SDK

A Laravel package for the Timatic API, built with [Saloon](https://docs.saloon.dev/) and automatically generated from OpenAPI specifications.

## Requirements

- PHP 8.1 or higher
- Laravel 10.x or higher

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
use Timatic\SDK\TimaticConnector;
use Timatic\SDK\Requests\BudgetType\GetBudgetTypeCollection;

class BudgetController extends Controller
{
    public function __construct(
        protected TimaticConnector $timatic
    ) {}

    public function index()
    {
        // Using resource methods
        $budgets = $this->timatic->budget()->getBudgets()->dto();

        // Using direct send() with dtoOrFail() for automatic DTO conversion
        $budgetTypes = $this->timatic
            ->send(new GetBudgetTypeCollection())
            ->dtoOrFail();

        return view('budgets.index', compact('budgets', 'budgetTypes'));
    }

    public function store(Request $request)
    {
        $budget = new \Timatic\SDK\Dto\Budget([
            'title' => $request->input('title'),
            'totalPrice' => $request->input('total_price'),
        ]);

        $created = $this->timatic
            ->send(new \Timatic\SDK\Requests\Budget\PostBudgets($budget))
            ->dtoOrFail();

        return redirect()->route('budgets.show', $created->id);
    }
}
```

**In Console Commands:**

```php
use Timatic\SDK\TimaticConnector;

class SyncBudgetsCommand extends Command
{
    public function handle(TimaticConnector $timatic): int
    {
        $budgets = $timatic->budget()->getBudgets()->dto();

        foreach ($budgets as $budget) {
            // Process budgets
        }

        return Command::SUCCESS;
    }
}
```

### Pagination

The SDK supports automatic pagination for all collection endpoints using Saloon's pagination plugin:

```php
use Timatic\SDK\TimaticConnector;
use Timatic\SDK\Requests\Budget\GetBudgets;

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
        $allBudgets = $paginator->collect();
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
$response = $timatic->budget()->getBudgets();

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

## Regenerating the SDK

This SDK is automatically generated from the Timatic API OpenAPI specification using a custom JSON:API generator. To regenerate the SDK with the latest API changes:

```bash
composer regenerate
```

This will:
1. Download the latest OpenAPI specification from the API
2. Generate Models with flattened JSON:API attributes
3. Update the autoloader
4. Format the code with Laravel Pint

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
