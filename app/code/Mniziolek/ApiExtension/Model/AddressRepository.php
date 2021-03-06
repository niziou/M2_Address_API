<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types = 1);

namespace Mniziolek\ApiExtension\Model;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AddressSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mniziolek\ApiExtension\Api\CustomerAddressRepositoryInterface;
use Mniziolek\ApiExtension\Model\Address\Command\CreateInterface;
use Mniziolek\ApiExtension\Model\Address\Command\DeleteInterface;
use Mniziolek\ApiExtension\Model\Address\Command\UpdateInterface;
use Mniziolek\ApiExtension\Model\Address\Query\GetInterface;
use Mniziolek\ApiExtension\Model\Address\Query\SearchInterface;

/**
 * Class AddressRepository
 *
 * @package Mniziolek\ApiExtension\Model
 */
class AddressRepository implements CustomerAddressRepositoryInterface
{
    /**
     * @var GetInterface
     */
    private $getQuery;

    /**
     * @var SearchInterface
     */
    private $searchQuery;

    /**
     * @var CreateInterface
     */
    private $createCommand;

    /**
     * @var UpdateInterface
     */
    private $updateCommand;

    /**
     * @var DeleteInterface
     */
    private $deleteCommand;

    /**
     * AddressRepository constructor.
     *
     * @param GetInterface $getQuery
     * @param SearchInterface $searchQuery
     * @param CreateInterface $createCommand
     * @param UpdateInterface $updateCommand
     * @param DeleteInterface $deleteCommand
     */
    public function __construct(
        GetInterface $getQuery,
        SearchInterface $searchQuery,
        CreateInterface $createCommand,
        UpdateInterface $updateCommand,
        DeleteInterface $deleteCommand
    ) {
        $this->getQuery = $getQuery;
        $this->searchQuery = $searchQuery;
        $this->createCommand = $createCommand;
        $this->updateCommand = $updateCommand;
        $this->deleteCommand = $deleteCommand;
    }

    /**
     * Search Query reads the AddressResultCollection by the given SearchCriteria
     *
     * @param int $customerId
     * @param SearchCriteriaInterface|null $searchCriteria
     *
     * @return AddressSearchResultsInterface
     */
    public function search(
        int $customerId,
        SearchCriteriaInterface $searchCriteria = null
    ): AddressSearchResultsInterface {
        return $this->searchQuery->execute($customerId, $searchCriteria);
    }

    /**
     * Create new address for given customer
     *
     * @param int $customerId
     * @param AddressInterface $addressData
     *
     * @throws InputException
     * @throws LocalizedException
     */
    public function create(int $customerId, AddressInterface $addressData): void
    {
        $this->createCommand->execute($customerId, $addressData);

        return;
    }

    /**
     * Delete customer address by entity ID and checks if customer owns that address
     *
     * @param int $customerId
     * @param int $addressId
     *
     * @throws NoSuchEntityException
     * @todo refactor: validation should be out
     */
    public function delete(int $customerId, int $addressId): void
    {
        $address = $this->get($customerId, $addressId);
        $this->deleteCommand->execute($address);

        return;
    }

    /**
     * Get Query reads the Address Entity By ID and checks if address belongs to customer
     *
     * @param int $customerId
     * @param int $addressId
     *
     * @return AddressInterface
     * @throws NoSuchEntityException
     * @todo refactor: validation should be out
     */
    public function get(int $customerId, int $addressId): AddressInterface
    {
        return $this->getQuery->execute($customerId, $addressId);
    }

    /**
     * Update customer address by entity Id
     *
     * @param int $customerId
     * @param int $addressId
     * @param AddressInterface $addressData
     *
     * @throws LocalizedException
     * @todo refactor: validation should be out
     */
    public function update(int $customerId, int $addressId, AddressInterface $addressData): void
    {
        /** Get method checks if address belongs to customer */
        $this->get($customerId, $addressId);
        $this->updateCommand->execute($customerId, $addressId, $addressData);

        return;
    }
}
