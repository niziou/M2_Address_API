<?php
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Mniziolek\ApiExtension\Api\Customer\AddressManagementInterface;

class AddressRepository implements AddressManagementInterface
{
    public function get(int $customerId, int $addressId)
    {
        // TODO: Implement get() method.
    }

    public function search(int $customerId, SearchCriteriaInterface $searchCriteria = null)
    {
        // TODO: Implement search() method.
    }

    public function create(int $customerId, AddressInterface $addressData)
    {
        // TODO: Implement create() method.
    }

    public function delete(int $customerId, int $addressId)
    {
        // TODO: Implement delete() method.
    }

    public function update(int $customerId, int $addressId, AddressInterface $addressData)
    {
        // TODO: Implement update() method.
    }
}