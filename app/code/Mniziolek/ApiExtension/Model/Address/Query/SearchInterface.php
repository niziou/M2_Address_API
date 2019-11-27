<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Address\Query;

use Magento\Customer\Api\Data\AddressSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface SearchInterface
{
    /**
     * Get List of Addresses according to SearchCriteria
     * @param int $customerId
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return AddressSearchResultsInterface
     */
    public function execute(int $customerId, SearchCriteriaInterface $searchCriteria): AddressSearchResultsInterface;
}