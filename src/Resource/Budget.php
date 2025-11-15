<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Budget\DeleteBudget;
use Timatic\SDK\Requests\Budget\GetBudget;
use Timatic\SDK\Requests\Budget\GetBudgets;
use Timatic\SDK\Requests\Budget\PatchBudget;
use Timatic\SDK\Requests\Budget\PostBudgets;
use Timatic\SDK\Requests\Budget\PutBudget;

class Budget extends BaseResource
{
	/**
	 * @param int $filtercustomerId
	 * @param int $filtercustomerIdeq
	 * @param int $filtercustomerIdnq
	 * @param int $filtercustomerIdgt
	 * @param int $filtercustomerIdlt
	 * @param int $filtercustomerIdgte
	 * @param int $filtercustomerIdlte
	 * @param int $filtercustomerIdcontains
	 * @param string $filterbudgetTypeId
	 * @param string $filterbudgetTypeIdeq
	 * @param string $filterbudgetTypeIdnq
	 * @param string $filterbudgetTypeIdgt
	 * @param string $filterbudgetTypeIdlt
	 * @param string $filterbudgetTypeIdgte
	 * @param string $filterbudgetTypeIdlte
	 * @param string $filterbudgetTypeIdcontains
	 * @param string $filterisArchived
	 * @param string $filtercustomerExternalId
	 * @param string $filtershowToCustomer
	 * @param string $include
	 */
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
	): Response
	{
		return $this->connector->send(new GetBudgets($filtercustomerId, $filtercustomerIdeq, $filtercustomerIdnq, $filtercustomerIdgt, $filtercustomerIdlt, $filtercustomerIdgte, $filtercustomerIdlte, $filtercustomerIdcontains, $filterbudgetTypeId, $filterbudgetTypeIdeq, $filterbudgetTypeIdnq, $filterbudgetTypeIdgt, $filterbudgetTypeIdlt, $filterbudgetTypeIdgte, $filterbudgetTypeIdlte, $filterbudgetTypeIdcontains, $filterisArchived, $filtercustomerExternalId, $filtershowToCustomer, $include));
	}


	public function postBudgets(): Response
	{
		return $this->connector->send(new PostBudgets());
	}


	/**
	 * @param string $budget
	 */
	public function getBudget(string $budget): Response
	{
		return $this->connector->send(new GetBudget($budget));
	}


	/**
	 * @param string $budget
	 */
	public function putBudget(string $budget): Response
	{
		return $this->connector->send(new PutBudget($budget));
	}


	/**
	 * @param string $budget
	 */
	public function deleteBudget(string $budget): Response
	{
		return $this->connector->send(new DeleteBudget($budget));
	}


	/**
	 * @param string $budget
	 */
	public function patchBudget(string $budget): Response
	{
		return $this->connector->send(new PatchBudget($budget));
	}
}
