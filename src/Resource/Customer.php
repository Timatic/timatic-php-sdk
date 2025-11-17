<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Customer\DeleteCustomerRequest;
use Timatic\SDK\Requests\Customer\GetCustomerRequest;
use Timatic\SDK\Requests\Customer\GetCustomersRequest;
use Timatic\SDK\Requests\Customer\PatchCustomerRequest;
use Timatic\SDK\Requests\Customer\PostCustomersRequest;

class Customer extends BaseResource
{
    public function getCustomers(?string $filterexternalId = null, ?string $filterexternalIdeq = null): Response
    {
        return $this->connector->send(new GetCustomersRequest($filterexternalId, $filterexternalIdeq));
    }

    public function postCustomers(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostCustomersRequest($data));
    }

    public function getCustomer(string $customer): Response
    {
        return $this->connector->send(new GetCustomerRequest($customer));
    }

    public function deleteCustomer(string $customer): Response
    {
        return $this->connector->send(new DeleteCustomerRequest($customer));
    }

    public function patchCustomer(string $customer, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchCustomerRequest($customer, $data));
    }
}
