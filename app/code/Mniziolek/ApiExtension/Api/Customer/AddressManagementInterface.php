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
    public function search($customerId, SearchCriteriaInterface $searchCriteria = null);

    /**
     * @param int $customerId
     * @param int $addressId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\AuthorizationException
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function get($customerId, $addressId);

    /**
     * @param int $customerId
     * @param \Magento\Customer\Api\Data\AddressInterface $addressData
     * @throws \Magento\Framework\Exception\InputException
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function create($customerId, $addressData);

    /**
     * @param int $customerId
     * @param int $addressId
     * @param \Magento\Customer\Api\Data\AddressInterface $addressData
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Magento\Customer\Api\Data\AddressInterface
     */
    public function update($customerId, $addressId, $addressData);

    /**
     * @param int $customerId
     * @param int $addressId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool
     */
    public function delete($customerId, $addressId);
}