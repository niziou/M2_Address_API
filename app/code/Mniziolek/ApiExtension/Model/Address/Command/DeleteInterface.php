<?php
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Command;

use Magento\Framework\Exception\LocalizedException;

interface DeleteInterface
{
    /**
     * @param int $customerId
     * @param int $addressId
     * @return void
     * @throws LocalizedException
     */
    public function execute(int $customerId, int $addressId): void;
}