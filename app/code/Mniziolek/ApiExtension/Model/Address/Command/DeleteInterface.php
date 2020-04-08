<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types = 1);

namespace Mniziolek\ApiExtension\Model\Address\Command;

use Magento\Customer\Api\Data\AddressInterface;

interface DeleteInterface
{
    /**
     * @param AddressInterface $address
     *
     * @return void
     */
    public function execute(AddressInterface $address): void;
}
