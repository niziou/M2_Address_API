<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Address\Query;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Get
 * @package Mniziolek\ApiExtension\Model\Address\Query
 */
class Get implements GetInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepository;

    /**
     * Get constructor.
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository
    )
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Get Example Entity By ID
     *
     * @param int $customerId
     * @param int $addressId
     * @return AddressInterface;
     * @throws NoSuchEntityException
     * @throws AuthorizationException
     * @throws LocalizedException
     */
    public function execute(int $customerId, int $addressId): AddressInterface
    {
        $address = $this->addressRepository->getById($addressId);
        if (is_array($address)) {
            throw new NoSuchEntityException(__('Address with id "%1" does not exist.', $addressId));
        }
        if(intval($address->getCustomerId()) !== intval($customerId)) {
            throw new AuthorizationException(__('Address doesn\'t belong to the customer "%1"', $customerId));
        }
        return $address;
    }
}