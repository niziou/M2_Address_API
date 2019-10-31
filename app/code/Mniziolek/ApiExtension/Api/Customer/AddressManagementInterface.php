<?php
namespace Mniziolek\ApiExtension\Api\Customer;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface AddressManagementInterface
{
    /**
     * @param int $customerId
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return \Magento\Customer\Api\Data\AddressSearchResultsInterface
     */
    public function search(int $customerId, SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param int $customerId
     * @param int $addressId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\AuthorizationException
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function get(int $customerId, int $addressId);

    /**
     * @param int $customerId
     * @param \Magento\Customer\Api\Data\AddressInterface $addressData
     * @throws \Magento\Framework\Exception\InputException
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function create(int $customerId, AddressInterface $addressData);

    /**
     * @param int $customerId
     * @param int $addressId
     * @param \Magento\Customer\Api\Data\AddressInterface $addressData
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function update(int $customerId, int $addressId, AddressInterface $addressData);

    /**
     * @param int $customerId
     * @param int $addressId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool
     */
    public function delete(int $customerId, int $addressId);
}