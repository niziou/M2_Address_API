<?php
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Mniziolek\ApiExtension\Api\Customer\AddressManagementInterface;
use Mniziolek\ApiExtension\Model\Address\Query\Get;

class AddressRepository implements AddressManagementInterface
{
    private $getQuery;
    public function __construct(
        Get $getQuery
    )
    {

    }
    /**
     * Get Address Entity By ID
     *
     * @param int $customerId
     * @param int $addressId
     * @return AddressInterface
     */
    public function get(int $customerId, int $addressId): AddressInterface
    {
        return $this->getQuery->execute($customerId, $addressId);
    }

    public function search(int $customerId, SearchCriteriaInterface $searchCriteria = null)
    {
        // TODO: Implement search() method.
    }

    public function create(int $customerId, AddressInterface $addressData): void
    {
        // TODO: Implement create() method.
    }

    public function delete(int $customerId, int $addressId): void
    {
        // TODO: Implement delete() method.
    }

    public function update(int $customerId, int $addressId, AddressInterface $addressData)
    {
        // TODO: Implement update() method.
    }
}