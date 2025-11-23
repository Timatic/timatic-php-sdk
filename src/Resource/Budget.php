<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
use Timatic\SDK\Requests\Budget\DeleteBudgetRequest;
use Timatic\SDK\Requests\Budget\GetBudgetRequest;
use Timatic\SDK\Requests\Budget\GetBudgetsRequest;
use Timatic\SDK\Requests\Budget\PatchBudgetRequest;
use Timatic\SDK\Requests\Budget\PostBudgetsRequest;

class Budget extends BaseResource
{
    public function getBudgets(?string $include = null): Response
    {
        return $this->connector->send(new GetBudgetsRequest($filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterbudgetTypeId, $filterbudgetTypeIdeq, $filterbudgetTypeIdnq, $filterbudgetTypeIdgt, $filterbudgetTypeIdlt, $filterbudgetTypeIdgte, $filterbudgetTypeIdlte, $filterbudgetTypeIdcontains, $filterisArchived, $filtercustomerExternalId, $filtershowToCustomer, $include));
    }

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

    public function patchBudget(string $budgetId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchBudgetRequest($budgetId, $data));
    }
}
