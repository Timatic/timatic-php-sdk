<?php

namespace Timatic\SDK;

use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Timatic\SDK\Pagination\JsonApiPaginator;
use Timatic\SDK\Resource\Approve;
use Timatic\SDK\Resource\Budget;
use Timatic\SDK\Resource\BudgetTimeSpentTotal;
use Timatic\SDK\Resource\BudgetType;
use Timatic\SDK\Resource\Change;
use Timatic\SDK\Resource\Correction;
use Timatic\SDK\Resource\Customer;
use Timatic\SDK\Resource\DailyProgress;
use Timatic\SDK\Resource\EntriesExport;
use Timatic\SDK\Resource\Entry;
use Timatic\SDK\Resource\EntrySuggestion;
use Timatic\SDK\Resource\Event;
use Timatic\SDK\Resource\ExportMail;
use Timatic\SDK\Resource\Incident;
use Timatic\SDK\Resource\MarkAsExported;
use Timatic\SDK\Resource\MarkAsInvoiced;
use Timatic\SDK\Resource\Me;
use Timatic\SDK\Resource\Number;
use Timatic\SDK\Resource\Overtime;
use Timatic\SDK\Resource\Period;
use Timatic\SDK\Resource\Team;
use Timatic\SDK\Resource\TimeSpentTotal;
use Timatic\SDK\Resource\User;
use Timatic\SDK\Resource\UserCustomerHoursAggregate;
use Timatic\SDK\Responses\TimaticResponse;

/**
 * timatic-api
 */
class TimaticConnector extends Connector implements HasPagination
{
    protected function defaultHeaders(): array
    {
        $headers = [
            'Accept' => 'application/vnd.api+json',
            'Content-Type' => 'application/vnd.api+json',
        ];

        if ($token = config('timatic.api_token')) {
            $headers['Authorization'] = "Bearer {$token}";
        }

        return $headers;
    }

    public function resolveResponseClass(): string
    {
        return TimaticResponse::class;
    }

    public function paginate(Request $request): JsonApiPaginator
    {
        return new JsonApiPaginator($this, $request);
    }

    public function __construct() {}

    public function resolveBaseUrl(): string
    {
        return config('timatic.base_url');
    }

    public function approve(): Approve
    {
        return new Approve($this);
    }

    public function budget(): Budget
    {
        return new Budget($this);
    }

    public function budgetTimeSpentTotal(): BudgetTimeSpentTotal
    {
        return new BudgetTimeSpentTotal($this);
    }

    public function budgetType(): BudgetType
    {
        return new BudgetType($this);
    }

    public function change(): Change
    {
        return new Change($this);
    }

    public function correction(): Correction
    {
        return new Correction($this);
    }

    public function customer(): Customer
    {
        return new Customer($this);
    }

    public function dailyProgress(): DailyProgress
    {
        return new DailyProgress($this);
    }

    public function entriesExport(): EntriesExport
    {
        return new EntriesExport($this);
    }

    public function entry(): Entry
    {
        return new Entry($this);
    }

    public function entrySuggestion(): EntrySuggestion
    {
        return new EntrySuggestion($this);
    }

    public function event(): Event
    {
        return new Event($this);
    }

    public function exportMail(): ExportMail
    {
        return new ExportMail($this);
    }

    public function incident(): Incident
    {
        return new Incident($this);
    }

    public function markAsExported(): MarkAsExported
    {
        return new MarkAsExported($this);
    }

    public function markAsInvoiced(): MarkAsInvoiced
    {
        return new MarkAsInvoiced($this);
    }

    public function me(): Me
    {
        return new Me($this);
    }

    public function number(): Number
    {
        return new Number($this);
    }

    public function overtime(): Overtime
    {
        return new Overtime($this);
    }

    public function period(): Period
    {
        return new Period($this);
    }

    public function team(): Team
    {
        return new Team($this);
    }

    public function timeSpentTotal(): TimeSpentTotal
    {
        return new TimeSpentTotal($this);
    }

    public function user(): User
    {
        return new User($this);
    }

    public function userCustomerHoursAggregate(): UserCustomerHoursAggregate
    {
        return new UserCustomerHoursAggregate($this);
    }
}
