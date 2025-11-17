<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Budget\DeleteBudget;
use Timatic\SDK\Requests\Budget\GetBudget;
use Timatic\SDK\Requests\Budget\GetBudgets;
use Timatic\SDK\Requests\Budget\PatchBudget;
use Timatic\SDK\Requests\Budget\PostBudgets;

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
        return $this->connector->send(new GetBudgets($filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterbudgetTypeId, $filterbudgetTypeIdeq, $filterbudgetTypeIdnq, $filterbudgetTypeIdgt, $filterbudgetTypeIdlt, $filterbudgetTypeIdgte, $filterbudgetTypeIdlte, $filterbudgetTypeIdcontains, $filterisArchived, $filtercustomerExternalId, $filtershowToCustomer, $include));
    }

    public function postBudgets(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostBudgets($data));
    }

    public function getBudget(string $budget): Response
    {
        return $this->connector->send(new GetBudget($budget));
    }

    public function deleteBudget(string $budget): Response
    {
        return $this->connector->send(new DeleteBudget($budget));
    }

    public function patchBudget(string $budget, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchBudget($budget, $data));
    }
}
