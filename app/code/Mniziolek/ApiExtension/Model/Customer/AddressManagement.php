<?php


namespace Polcode\ApiExtension\Model\Customer;

use Polcode\ApiExtension\Api\Customer\AddressManagementInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\AddressSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Model\AddressRegistry;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Customer\Api\AddressRepositoryInterface;
use Magento\Customer\Model\AddressFactory;


class AddressManagement implements AddressManagementInterface
{
    /**
     * @var \Magento\Customer\Model\AddressRegistry
     */
    protected $addressRegistry;
    /**
     * @var \Magento\Customer\Api\Data\AddressSearchResultsInterfaceFactory
     */
    protected $addressSearchResultsFactory;
    /**
     * @var \Magento\Customer\Model\ResourceModel\Address\CollectionFactory
     */
    protected $addressCollectionFactory;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface
     */
    protected $extensionAttributesJoinProcessor;
    /**
     * @var SearchCriteriaInterface
     */
    protected $searchCriteriaEmpty;
    protected $addressRepository;
    protected $addressFactory;
    protected $addressInterfaceFactory;

    /**
     * AddressManagement constructor.
     * @param CustomerRepositoryInterface $customerRegistry
     * @param AddressSearchResultsInterfaceFactory $addressSearchResultsFactory
     * @param \Magento\Customer\Model\ResourceModel\Address\CollectionFactory $addressCollectionFactory
     * @param SearchCriteriaInterface $searchCriteria
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $joinProcessor
     * @param AddressRegistry $addressRegistry
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(
        CustomerRepositoryInterface $customerRegistry,
        AddressSearchResultsInterfaceFactory $addressSearchResultsFactory,
        \Magento\Customer\Model\ResourceModel\Address\CollectionFactory $addressCollectionFactory,
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $joinProcessor,
        AddressRegistry $addressRegistry,
        AddressRepositoryInterface $addressRepository,
        AddressFactory $addressFactory
    )
    {
        $this->customerRepository = $customerRegistry;
        $this->addressSearchResultsFactory = $addressSearchResultsFactory;
        $this->addressCollectionFactory = $addressCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $joinProcessor;
        $this->addressRegistry = $addressRegistry;
        $this->searchCriteriaEmpty = $searchCriteria;
        $this->addressRepository = $addressRepository;
        $this->addressFactory = $addressFactory;
    }

    /**
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
        /** @var \Magento\Customer\Api\Data\AddressInterface[] $addresses */
        $addresses = [];
        /** @var \Magento\Customer\Model\Address $address */
        foreach ($collection->getItems() as $address) {
            $addresses[] = $this->getById($address->getId());
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
     * {@inheritdoc}
     */
    public function get($customerId, $addressId)
    {
        $collection = $this->addressCollectionFactory->create();
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            AddressInterface::class
        );
        $collection->addFieldToFilter('parent_id', $customerId);
        $collection->addFieldToFilter('entity_id', $addressId);
        /** @var \Magento\Customer\Model\Address $address */
        $address = [];
        foreach ($collection->getItems() as $address) {
            $address = $this->getById($address->getId());
        }
        if (is_array($address)) {
            throw new NoSuchEntityException(__('Address with id "%1" does not exist.', $addressId));
        }
        return $address;
    }

    /**
     * {@inheritdoc}
     */
    public function create($customerId, $addressData)
    {
        $address = $this->addressFactory->create();
        $address->updateData($addressData);
        $address->setCustomerId($customerId);
        if(!$address->validate()) {
            throw new InputException(
                __("AddressData is not valid, it has to be type \Magento\Customer\Api\Data\AddressInterface")
            );
        }
        $address->save();
        $addressData = $this->get($customerId, $address->getId());
        return $addressData;
    }

    /**
     * {@inheritdoc}
     */
    public function update($customerId, $addressId, $addressData)
    {
        $addressData->setId($addressId);
        $address = $this->addressFactory->create();
        $address->load($addressId);
        $address->updateData($addressData);
        $address->validate();
        $address->save();

        $addressData = $this->get($customerId, $addressId);
        return $addressData;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($customerId, $addressId)
    {
        /** Checks if address belongs to this customer */
        $this->get($customerId,$addressId);
        return $this->addressRepository->deleteById($addressId);
    }

    /**
     * Retrieve customer address.
     *
     * @param int $addressId
     * @return \Magento\Customer\Api\Data\AddressInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getById($addressId)
    {
        $address = $this->addressRegistry->retrieve($addressId);
        return $address->getDataModel();
    }
}
