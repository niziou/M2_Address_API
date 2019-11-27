<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Address\Query;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AddressSearchResultsInterface;
use Magento\Customer\Model\ResourceModel\Address\CollectionFactory;
use Magento\Customer\Api\Data\AddressSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class Search implements SearchInterface
{
    /**
     * @var AddressSearchResultsInterfaceFactory
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
    public function __construct(
        AddressSearchResultsInterfaceFactory $addressSearchResultsFactory,
        CollectionFactory $addressCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor
    )
    {
        $this->addressSearchResultsFactory = $addressSearchResultsFactory;
        $this->addressCollectionFactory = $addressCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
    }

    public function execute(int $customerId, SearchCriteriaInterface $searchCriteria): AddressSearchResultsInterface
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
}