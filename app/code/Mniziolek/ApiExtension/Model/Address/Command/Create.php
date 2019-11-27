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
 * Class Create
 * @package Mniziolek\ApiExtension\Model\Address\Command
 */
class Create implements CreateInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRepository;

    /**
     * Create constructor.
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository
    )
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param int $customerId
     * @param AddressInterface $addressData
     * @return void
     * @throws LocalizedException
     */
    public function execute(int $customerId, AddressInterface $addressData): void
    {
        $addressData->setCustomerId($customerId);
        $this->addressRepository->save($addressData);
        return;
    }
}