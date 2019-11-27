<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Mniziolek\ApiExtension\Api\Customer\AddressManagementInterface;
use Mniziolek\ApiExtension\Model\Address\Query\GetInterface;
use Mniziolek\ApiExtension\Model\Address\Command\CreateInterface;
use Mniziolek\ApiExtension\Model\Address\Query\SearchInterface;
use Mniziolek\ApiExtension\Model\Address\Command\UpdateInterface;
use Mniziolek\ApiExtension\Model\Address\Command\DeleteInterface;

class AddressRepository implements CustomerAddressRepositoryInterface
{
    private $getQuery;
    private $searchQuery;
    private $createCommand;
    private $updateCommand;
    private $deleteCommand;
    public function __construct(
        GetInterface $getQuery,
        SearchInterface $searchQuery,
        CreateInterface $createCommand,
        UpdateInterface $updateCommand,
        DeleteInterface $deleteCommand
    )
    {
        $this->getQuery = $getQuery;
        $this->searchQuery = $searchQuery;
        $this->createCommand = $createCommand;
        $this->updateCommand = $updateCommand;
        $this->deleteCommand = $deleteCommand;
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

    public function create(int $customerId, AddressInterface $addressData)
    {
        return $this->createCommand->execute($customerId, $addressData);
    }

    public function delete(int $customerId, int $addressId)
    {
        $address = $this->get($customerId,$addressId);
        $this->deleteCommand->execute($address);
        return;
    }

    public function update(int $customerId, int $addressId, AddressInterface $addressData)
    {
        return $this->updateCommand->execute($customerId, $addressId, $addressData);
    }
}