<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types = 1);

namespace Mniziolek\ApiExtension\Model\Address\Command;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Delete Command
 *
 * @package Mniziolek\ApiExtension\Model\Address\Command
 */
class Delete implements DeleteInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRepository;

    /**
     * Delete constructor.
     *
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository
    ) {
        $this->addressRepository = $addressRepository;
    }

    /**
     * @param AddressInterface $address
     *
     * @throws LocalizedException
     */
    public function execute(AddressInterface $address): void
    {
        $this->addressRepository->delete($address);

        return;
    }
}
