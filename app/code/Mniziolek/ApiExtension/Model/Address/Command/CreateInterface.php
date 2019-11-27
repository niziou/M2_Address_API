<?php
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Command;

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