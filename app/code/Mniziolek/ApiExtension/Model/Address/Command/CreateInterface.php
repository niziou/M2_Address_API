<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Address\Command;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;

interface CreateInterface
{
    /**
     * @param int $customerId
     * @param AddressInterface $addressData
     * @return AddressInterface
     * @throws LocalizedException
     * @throws InputException
     */
    public function execute(int $customerId, AddressInterface $addressData);
}