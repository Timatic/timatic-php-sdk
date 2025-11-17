<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Requests\Customer\DeleteCustomer;
use Timatic\SDK\Requests\Customer\GetCustomer;
use Timatic\SDK\Requests\Customer\GetCustomers;
use Timatic\SDK\Requests\Customer\PatchCustomer;
use Timatic\SDK\Requests\Customer\PostCustomers;

class Customer extends BaseResource
{
    public function getCustomers(?string $filterexternalId = null, ?string $filterexternalIdeq = null): Response
    {
        return $this->connector->send(new GetCustomers($filterexternalId, $filterexternalIdeq));
    }

    public function postCustomers(\Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostCustomers($data));
    }

    public function getCustomer(string $customer): Response
    {
        return $this->connector->send(new GetCustomer($customer));
    }

    public function deleteCustomer(string $customer): Response
    {
        return $this->connector->send(new DeleteCustomer($customer));
    }

    public function patchCustomer(string $customer, \Timatic\SDK\Foundation\Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchCustomer($customer, $data));
    }
}
