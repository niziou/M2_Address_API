<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Test\Unit\Model\Customer;

use Assert\Assert;
use Magento\Customer\Api\Data\AddressSearchResultsInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Mniziolek\ApiExtension\Model\Address\Query\GetInterface;
use Mniziolek\ApiExtension\Model\Address\Query\SearchInterface;
use Mniziolek\ApiExtension\Model\Address\Command\DeleteInterface;
use Mniziolek\ApiExtension\Model\Address\Command\CreateInterface;
use Mniziolek\ApiExtension\Model\Address\Command\UpdateInterface;
use Mniziolek\ApiExtension\Model\AddressRepository;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
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
     *
     * @throws NoSuchEntityException
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
                new NoSuchEntityException(__("No address entity exists with entity ID spcified"))
            );
        $this->addressRepository->get($customerId, $entityId);
    }
}