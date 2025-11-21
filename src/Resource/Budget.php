<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Foundation\Model;
use Timatic\SDK\Requests\Budget\DeleteBudgetRequest;
use Timatic\SDK\Requests\Budget\GetBudgetRequest;
use Timatic\SDK\Requests\Budget\GetBudgetsRequest;
use Timatic\SDK\Requests\Budget\PatchBudgetRequest;
use Timatic\SDK\Requests\Budget\PostBudgetsRequest;

class Budget extends BaseResource
{
    public function getBudgets(
        ?int $filtercustomerId = null,
        ?int $filtercustomerIdeq = null,
        ?int $filtercustomerIdnq = null,
        ?int $filtercustomerIdgt = null,
        ?int $filtercustomerIdlt = null,
        ?int $filtercustomerIdgte = null,
        ?int $filtercustomerIdlte = null,
        ?int $filtercustomerIdcontains = null,
        ?string $filterbudgetTypeId = null,
        ?string $filterbudgetTypeIdeq = null,
        ?string $filterbudgetTypeIdnq = null,
        ?string $filterbudgetTypeIdgt = null,
        ?string $filterbudgetTypeIdlt = null,
        ?string $filterbudgetTypeIdgte = null,
        ?string $filterbudgetTypeIdlte = null,
        ?string $filterbudgetTypeIdcontains = null,
        ?string $filterisArchived = null,
        ?string $filtercustomerExternalId = null,
        ?string $filtershowToCustomer = null,
        ?string $include = null,
    ): Response {
        return $this->connector->send(new GetBudgetsRequest($filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterbudgetTypeId, $filterbudgetTypeIdeq, $filterbudgetTypeIdnq, $filterbudgetTypeIdgt, $filterbudgetTypeIdlt, $filterbudgetTypeIdgte, $filterbudgetTypeIdlte, $filterbudgetTypeIdcontains, $filterisArchived, $filtercustomerExternalId, $filtershowToCustomer, $include));
    }

    /**
     * @param  Timatic\SDK\Foundation\Model|array|null  $data  Request data
     */
    public function postBudgets(Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostBudgetsRequest($data));
    }

    public function getBudget(string $budgetId): Response
    {
        return $this->connector->send(new GetBudgetRequest($budgetId));
    }

    public function deleteBudget(string $budgetId): Response
    {
        return $this->connector->send(new DeleteBudgetRequest($budgetId));
    }

    /**
     * @param  Timatic\SDK\Foundation\Model|array|null  $data  Request data
     */
    public function patchBudget(string $budgetId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchBudgetRequest($budgetId, $data));
    }
}
