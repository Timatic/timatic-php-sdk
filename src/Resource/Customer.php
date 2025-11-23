<?php

namespace Timatic\SDK\Resource;

use Saloon\Http\BaseResource;
use Saloon\Http\Response;
use Timatic\SDK\Hydration\Model;
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

    /**
     * @param  Timatic\SDK\Hydration\Model|array|null  $data  Request data
     */
    public function postCustomers(Model|array|null $data = null): Response
    {
        return $this->connector->send(new PostCustomersRequest($data));
    }

    public function getCustomer(string $customerId): Response
    {
        return $this->connector->send(new GetCustomerRequest($customerId));
    }

    public function deleteCustomer(string $customerId): Response
    {
        return $this->connector->send(new DeleteCustomerRequest($customerId));
    }

    /**
     * @param  Timatic\SDK\Hydration\Model|array|null  $data  Request data
     */
    public function patchCustomer(string $customerId, Model|array|null $data = null): Response
    {
        return $this->connector->send(new PatchCustomerRequest($customerId, $data));
    }
}
