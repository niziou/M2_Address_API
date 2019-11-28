<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Test\Unit\Model\Customer;

use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Api\Data\AddressSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Mniziolek\ApiExtension\Model\Address\Command\CreateInterface;
use Mniziolek\ApiExtension\Model\Address\Command\DeleteInterface;
use Mniziolek\ApiExtension\Model\Address\Command\UpdateInterface;
use Mniziolek\ApiExtension\Model\Address\Query\GetInterface;
use Mniziolek\ApiExtension\Model\Address\Query\SearchInterface;
use Mniziolek\ApiExtension\Model\AddressRepository;
use PHPUnit\Framework\TestCase;

class AddressRepositoryTest extends TestCase
{
    /**
     * @var AddressInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $address;
    /**
     * @var AddressRepository
     */
    private $addressRepository;
    /**
     * @var GetInterface
     */
    private $getQuery;
    /**
     * @var SearchInterface
     */
    private $searchQuery;
    /**
     * @var DeleteInterface
     */
    private $deleteCommand;
    /**
     * @var CreateInterface
     */
    private $createCommand;
    /**
     * @var UpdateInterface
     */
    private $updateCommand;
    /**
     * @var AddressSearchResultsInterface
     */
    private $searchResults;

    /**
     * Setup for AddressRepositoryTest Class
     */
    public function setUp()
    {
        $this->address = $this->getMockBuilder(AddressInterface::class)->getMock();
        $this->getQuery = $this->getMockBuilder(GetInterface::class)->getMock();
        $this->searchQuery = $this->getMockBuilder(SearchInterface::class)->getMock();
        $this->deleteCommand = $this->getMockBuilder(DeleteInterface::class)->getMock();
        $this->createCommand = $this->getMockBuilder(CreateInterface::class)->getMock();
        $this->updateCommand = $this->getMockBuilder(UpdateInterface::class)->getMock();
        $this->searchResults = $this->getMockBuilder(AddressSearchResultsInterface::class)->getMock();
        $this->addressRepository = (new ObjectManager($this))->getObject(
            AddressRepository::class,
            [
                'get' => $this->getQuery,
                'search' => $this->searchQuery,
                'create' => $this->createCommand,
                'delete' => $this->deleteCommand,
                'update' => $this->updateCommand,
            ]
        );
    }

    /**
     * Test that get() will successfully call Get::execute() and return expected Object
     * @throws NoSuchEntityException
     */
    public function testGet()
    {
        $entityId = 1;
        $customerId = 1;
        $this->getQuery
            ->expects($this->once())
            ->method('execute')
            ->with($customerId, $entityId)
            ->willReturn($this->address);

        $this->assertEquals(
            $this->address,
            $this->addressRepository->get($customerId, $entityId)
        );
    }

    /**
     * @expectedException NoSuchEntityException
     * @expectedExceptionMessage No Example Entity Exists With Entity ID specified
     */
    public function testGetWithNoSuchEntityException()
    {
        $customerId = 1;
        $entityId = 1;
        $this->getQuery
            ->expects($this->once())
            ->method('execute')
            ->with($customerId, $entityId)
            ->willThrowException(
                new NoSuchEntityException(__("No Example Entity Exists With Entity ID specified"))
            );
        $this->addressRepository->get($customerId, $entityId);
    }

    /**
     * Test getList() successfully calls GetList::execute and returns expceted ExampleSearchResults
     */
    public function testSearchWithSearchCriteria()
    {
        $customerId = 1;
        $searchCriteria = $this->getMockBuilder(SearchCriteriaInterface::class)->getMock();
        $this->searchQuery
            ->expects($this->once())
            ->method('execute')
            ->with($searchCriteria)
            ->willReturn($this->searchResults);
        $this->assertEquals(
            $this->searchResults,
            $this->addressRepository->search($customerId, $searchCriteria)
        );
    }

    /**
     * Test getList() successfully calls GetList::execute and returns expceted ExampleSearchResults
     */
    public function testSearchWithoutSearchCriteria()
    {
        $customerId = 1;
        $this->searchQuery
            ->expects($this->once())
            ->method('execute')
            ->with($customerId, null)
            ->willReturn($this->searchResults);
        $this->assertEquals(
            $this->searchResults,
            $this->addressRepository->search($customerId, null)
        );
    }

    /**
     * @expectedException CouldNotDeleteException
     * @expectedExceptionMessage Could Not Delete Example Entity
     */
    public function testDeleteWithCouldNotDeleteException()
    {
        $customerId = 1;
        $addressId = 1;
        $this->deleteCommand
            ->expects($this->once())
            ->method('execute')
            ->with($this->address)
            ->willThrowException(
                new CouldNotDeleteException(__('Could Not Delete Example Entity'))
            );
        $this->addressRepository->delete($customerId, $addressId);
    }

    /**
     * @expectedException NoSuchEntityException
     * @expectedExceptionMessage Could Not Delete Example Entity as No Entity Exists with Id
     */
    public function testDeleteWithNoSuchEntityException()
    {
        $customerId = 1;
        $addressId = 1;
        $this->deleteCommand
            ->expects($this->once())
            ->method('execute')
            ->with($customerId, $addressId)
            ->willThrowException(
                new NoSuchEntityException(
                    __(
                        'Could Not Delete Example Entity as No Entity Exists with Id'
                    )
                )
            );
        $this->addressRepository->delete($customerId, $addressId);
    }

    /**
     * Test update() successfully calls Update::execute and returns expected AddressSearchResults
     */
    public function testUpdate()
    {
        $customerId = 1;
        $addressId = 1;
        $this->updateCommand
            ->expects($this->once())
            ->method('execute')
            ->with($customerId, $addressId)
            ->willReturn($this->address);

        $this->assertEquals(
            $this->address,
            $this->addressRepository->update($customerId, $addressId, $this->address)
        );
    }

    public function testUpdateWithCouldNotSaveException()
    {
        $customerId = 1;
        $addressId = 1;
        $this->updateCommand
            ->expects($this->once())
            ->method('execute')
            ->with($customerId, $addressId, $this->address)
            ->willThrowException(
                new CouldNotSaveException(
                    __(
                        'Could Not Update Address Entity'
                    )
                )
            );
        $this->addressRepository->update($customerId, $addressId, $this->address);
    }
}