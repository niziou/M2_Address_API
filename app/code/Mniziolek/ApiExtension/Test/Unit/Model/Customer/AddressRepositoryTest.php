<?php
/**
 * @package Mniziolek_ApiExtension
 * @author Mateusz Niziołek <mateusz.niziolek@gmail.com>
 */
declare(strict_types=1);

namespace Mniziolek\ApiExtension\Test\Unit\Model\Customer;

use Assert\Assert;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Mniziolek\ApiExtension\Model\Address\Query\GetInterface;
use Mniziolek\ApiExtension\Model\Address\Query\SearchInterface;
use Mniziolek\ApiExtension\Model\Address\Command\DeleteInterface;
use Mniziolek\ApiExtension\Model\Address\Command\SaveInterface;
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
     * @var
     */
    private $getQuery;
    /**
     * @var
     */
    private $searchQuery;
    /**
     * @var
     */
    private $deleteCommand;
    /**
     * @var
     */
    private $saveCommand;
    /**
     * @var
     */
    private $updateCommand;
    /**
     * @var
     */
    private $searchResults;
}