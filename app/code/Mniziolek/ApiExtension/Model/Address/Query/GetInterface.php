<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types = 1);

namespace Mniziolek\ApiExtension\Model\Address\Query;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Exception\NoSuchEntityException;

interface GetInterface
{
    /**
     * Get Example Entity By ID
     *
     * @param int $customerId
     * @param int $addressId
     *
     * @return AddressInterface;
     * @throws NoSuchEntityException
     */
    public function execute(int $customerId, int $addressId): AddressInterface;
}
