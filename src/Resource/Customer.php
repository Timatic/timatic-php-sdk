<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Customer\DeleteCustomer;
use Timatic\SDK\Requests\Customer\GetCustomer;
use Timatic\SDK\Requests\Customer\GetCustomers;
use Timatic\SDK\Requests\Customer\PatchCustomer;
use Timatic\SDK\Requests\Customer\PostCustomers;
use Timatic\SDK\Requests\Customer\PutCustomer;

class Customer extends BaseResource
{
	/**
	 * @param string $filterexternalId
	 * @param string $filterexternalIdeq
	 */
	public function getCustomers(?string $filterexternalId = null, ?string $filterexternalIdeq = null): Response
	{
		return $this->connector->send(new GetCustomers($filterexternalId, $filterexternalIdeq));
	}


	public function postCustomers(): Response
	{
		return $this->connector->send(new PostCustomers());
	}


	/**
	 * @param string $customer
	 */
	public function getCustomer(string $customer): Response
	{
		return $this->connector->send(new GetCustomer($customer));
	}


	/**
	 * @param string $customer
	 */
	public function putCustomer(string $customer): Response
	{
		return $this->connector->send(new PutCustomer($customer));
	}


	/**
	 * @param string $customer
	 */
	public function deleteCustomer(string $customer): Response
	{
		return $this->connector->send(new DeleteCustomer($customer));
	}


	/**
	 * @param string $customer
	 */
	public function patchCustomer(string $customer): Response
	{
		return $this->connector->send(new PatchCustomer($customer));
	}
}
