<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Address\Command;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Update
 * @package Mniziolek\ApiExtension\Model\Address\Command
 */
class Update implements UpdateInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRepository;

    /**
     * Update constructor.
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(AddressRepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param int $customerId
     * @param int $addressId
     * @param AddressInterface $addressData
     * @throws LocalizedException
     */
    public function execute(int $customerId, int $addressId, AddressInterface $addressData): void
    {
        $addressData->setId($addressId);
        $addressData->setCustomerId($customerId);
        $this->addressRepository->save($addressData);
        return;
    }
}