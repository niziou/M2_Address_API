<?php
namespace Mniziolek\ApiExtension\Api;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AddressSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

interface CustomerAddressRepositoryInterface
{
    /**
     * @param int $customerId
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return AddressSearchResultsInterface
     */
    public function search(int $customerId, SearchCriteriaInterface $searchCriteria = null): AddressSearchResultsInterface;

    /**
     * @param int $customerId
     * @param int $addressId
     * @return AddressInterface
     * @throws AuthorizationException
     * @throws LocalizedException
     */
    public function get(int $customerId, int $addressId): AddressInterface;

    /**
     * @param int $customerId
     * @param AddressInterface $addressData
     * @return void
     * @throws InputException
     */
    public function create(int $customerId, AddressInterface $addressData);

    /**
     * @param int $customerId
     * @param int $addressId
     * @param AddressInterface $addressData
     * @return void
     * @throws NoSuchEntityException
     * @throws InputException
     */
    public function update(int $customerId, int $addressId, AddressInterface $addressData);

    /**
     * @param int $customerId
     * @param int $addressId
     * @throws NoSuchEntityException
     * @throws LocalizedException
     * @return void
     */
    public function delete(int $customerId, int $addressId);
}