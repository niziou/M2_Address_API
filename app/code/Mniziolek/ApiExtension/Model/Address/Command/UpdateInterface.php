<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types = 1);

namespace Mniziolek\ApiExtension\Model\Address\Command;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Exception\LocalizedException;

interface UpdateInterface
{
    /**
     * @param int $customerId
     * @param int $addressId
     * @param AddressInterface $addressData
     *
     * @return void
     * @throws LocalizedException
     */
    public function execute(int $customerId, int $addressId, AddressInterface $addressData): void;
}
