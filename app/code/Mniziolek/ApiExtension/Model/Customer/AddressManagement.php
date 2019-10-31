<?php
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Customer;

use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AddressInterfaceFactory;
use Magento\Customer\Api\Data\AddressSearchResultsInterfaceFactory;
use Magento\Customer\Model\AddressFactory;
use Magento\Customer\Model\ResourceModel\Address\CollectionFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Mniziolek\ApiExtension\Api\Customer\AddressManagementInterface;


/**
 * Class AddressManagement
 * @package Mniziolek\ApiExtension\Model\Customer
 */
class AddressManagement implements AddressManagementInterface
{
    /**
     * @var AddressRepositoryInterface
     */
    protected $addressRepository;
    /**
     * @var \Magento\Customer\Api\Data\AddressSearchResultsInterfaceFactory
     */
    protected $addressSearchResultsFactory;
    /**
     * @var CollectionFactory
     */
    protected $addressCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * AddressManagement constructor.
     * @param AddressRepositoryInterface $addressRepository
     * @param AddressSearchResultsInterfaceFactory $addressSearchResultsFactory
     * @param CollectionFactory $addressCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        AddressSearchResultsInterfaceFactory $addressSearchResultsFactory,
        CollectionFactory $addressCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor
    )
    {
        $this->addressRepository = $addressRepository;
        $this->addressSearchResultsFactory = $addressSearchResultsFactory;
        $this->addressCollectionFactory = $addressCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
    }

    /**
     *
     * Similar to getList from AddressRepository
     * {@inheritdoc}
     */
    public function search($customerId, SearchCriteriaInterface $searchCriteria = null)
    {
        $collection = $this->addressCollectionFactory->create();
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            AddressInterface::class
        );
        /** No search criteria object passed */
        if($searchCriteria === null) {
            $collection->addFieldToFilter('parent_id', $customerId);
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }
        /** @var AddressInterface[] $addresses */
        $addresses = [];
        /** @var \Magento\Customer\Model\Address $address */
        foreach ($collection->getItems() as $address) {
            $addresses[] = $address;
        }
        /** @var \Magento\Customer\Api\Data\AddressSearchResultsInterface $searchResults */
        $searchResults = $this->addressSearchResultsFactory->create();
        $searchResults->setItems($addresses);
        if($searchCriteria != null) {
            $searchResults->setSearchCriteria($searchCriteria);
        }
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
    /**
     * @param int $customerId
     * @param int $addressId
     * @return AddressInterface
     * @throws LocalizedException
     */
    public function get(int $customerId, int $addressId): AddressInterface
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

    /**
     * @param int $customerId
     * @param AddressInterface $addressData
     * @return AddressInterface
     * @throws LocalizedException
     * @throws InputException
     */
    public function create(int $customerId,AddressInterface $addressData): AddressInterface
    {
        $addressData->setCustomerId($customerId);
        $addressData = $this->addressRepository->save($addressData);
        return $addressData;
    }

    /**
     * @param int $customerId
     * @param int $addressId
     * @param AddressInterface $addressData
     * @return AddressInterface
     * @throws LocalizedException
     */
    public function update(int $customerId,int $addressId, AddressInterface $addressData): AddressInterface
    {
        $addressData->setId($addressId);
        $addressData->setCustomerId($customerId);
        $this->addressRepository->save($addressData);
        return $addressData;
    }

    /**
     * @param int $customerId
     * @param int $addressId
     * @return bool
     * @throws LocalizedException
     */
    public function delete(int $customerId, int $addressId): bool
    {
        /** Get method checks if address belongs to customer */
        $address = $this->get($customerId,$addressId);
        return $this->addressRepository->delete($address);
    }
}
