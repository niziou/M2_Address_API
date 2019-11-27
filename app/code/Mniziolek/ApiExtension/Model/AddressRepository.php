<?php
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Mniziolek\ApiExtension\Api\Customer\AddressManagementInterface;
use Mniziolek\ApiExtension\Model\Address\Query\GetInterface;
use Mniziolek\ApiExtension\Model\Address\Query\SearchInterface;

class AddressRepository implements AddressManagementInterface
{
    private $getQuery;
    private $searchQuery;
    public function __construct(
        GetInterface $getQuery,
        SearchInterface $searchQuery
    )
    {
        $this->getQuery = $getQuery;
        $this->searchQuery = $searchQuery;
    }

    /**
     * Get Address Entity By ID
     *
     * @param int $customerId
     * @param int $addressId
     * @return AddressInterface
     * @throws NoSuchEntityException
     */
    public function get(int $customerId, int $addressId): AddressInterface
    {
        return $this->getQuery->execute($customerId, $addressId);
    }

    public function search(int $customerId, SearchCriteriaInterface $searchCriteria = null)
    {
        return $this->searchQuery->execute($customerId, $searchCriteria);
    }

    public function create(int $customerId, AddressInterface $addressData): void
    {
        return $this->createCommand->execute($customerId, $addressData);
    }

    public function delete(int $customerId, int $addressId): void
    {
        return $this->deleteCommand->execute($customerId, $addressId);
    }

    public function update(int $customerId, int $addressId, AddressInterface $addressData)
    {
        return $this->updateCommand->execute($customerId, $addressId, $addressData);
    }
}