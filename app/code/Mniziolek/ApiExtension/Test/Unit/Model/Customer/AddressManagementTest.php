<?php

declare(strict_types=1);

namespace Mniziolek\ApiExtension\Model\Customer;

use Assert\Assert;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use PHPUnit\Framework\TestCase;

class AddressManagementTest extends TestCase
{
    /**
     * @var \Magento\Directory\Helper\Data|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $directoryData;

    /**
     * @var \Magento\Customer\Model\AddressFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressFactory;

    /**
     * @var \Magento\Customer\Model\AddressRegistry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressRegistry;

    /**
     * @var \Magento\Customer\Model\CustomerRegistry|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customerRegistry;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Address|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressResourceModel;

    /**
     * @var \Magento\Customer\Api\Data\AddressSearchResultsInterfaceFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressSearchResultsFactory;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Address\CollectionFactory|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $addressCollectionFactory;

    /**
     * @var \Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $extensionAttributesJoinProcessor;

    /**
     * @var \Magento\Customer\Model\Customer|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $customer;

    /**
     * @var \Magento\Customer\Model\Address|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $address;

    /**
     * @var \Magento\Customer\Model\ResourceModel\AddressRepository
     */
    protected $repository;

    /**
     * @var AddressManagement
     */
    protected $addressManagement;

    /**
     * Setting up loading outer class. Is it good?
     */
    protected function setUp()
    {
        $this->addressRegistry = $this->createMock(\Magento\Customer\Model\AddressRegistry::class);
        $this->addressManagement = $this->createMock(AddressManagement::class);
        $this->addressFactory = $this->createPartialMock(\Magento\Customer\Model\Address::class, ['create']);
        $this->addressRegistry = $this->createMock(\Magento\Customer\Model\AddressRegistry::class);
        $this->customerRegistry = $this->createMock(\Magento\Customer\Model\CustomerRegistry::class);
        $this->addressResourceModel = $this->createMock(\Magento\Customer\Model\ResourceModel\Address::class);
        $this->directoryData = $this->createMock(\Magento\Directory\Helper\Data::class);
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function testGet()
    {
        $customerAddress = $this->getMockForAbstractClass(
            \Magento\Customer\Api\Data\AddressInterface::class,
            [],
            '',
            false
        );
        $this->addressManagement->expects($this->once())
            ->method('get')
            ->with(1,1)
            ->willReturn($this->address);
        $this->assertSame($customerAddress, $this->addressManagement->get(1,1));
        //co ma zwracac get, obiekt address
    }
}