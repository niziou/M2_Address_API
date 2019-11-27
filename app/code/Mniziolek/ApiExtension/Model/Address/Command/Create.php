<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Address\Command;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\AddressRepositoryInterface;

class Create implements CreateInterface
{
    protected $addressRepository;
    public function __construct(
        AddressRepositoryInterface $addressRepository
    )
    {
        $this->addressRepository = $addressRepository;
    }

    public function execute(int $customerId, AddressInterface $addressData)
    {
        $addressData->setCustomerId($customerId);
        $addressData = $this->addressRepository->save($addressData);
        return $addressData;
    }
}