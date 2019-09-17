<?php

declare(strict_types=1);

namespace Example\GiftItem\Test\Integration\Model\Totals;

use Example\GiftItem\Model\GiftItemManager;
use Example\GiftItem\Model\Totals\GiftItemAddressTotal;
use Magento\Catalog\Model\Product as ProductModel;
use Magento\Catalog\Model\ResourceModel\Product as ProductResource;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order\Total\AbstractTotal;
use Magento\TestFramework\ObjectManager;
use PHPUnit\Framework\TestCase;

use function array_merge as merge;

class GiftItemAddressTotalTest extends TestCase
{
    /**
     * @param float|int $rowTotal
     * @return Quote\Item\AbstractItem|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createItemWithRowTotal($rowTotal, $baseRowTotal = null): Quote\Item\AbstractItem
    {
        $methods = merge(get_class_methods(Quote\Item\AbstractItem::class), ['getRowTotal', 'getBaseRowTotal']);
        $item = $this->getMockBuilder(Quote\Item\AbstractItem::class)
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
        $item->method('getRowTotal')->willReturn($rowTotal);
        $item->method('getBaseRowTotal')->willReturn($baseRowTotal);

        return $item;
    }

    public function testInheritsAbstractAddressTotalModel()
    {
        $this->assertInstanceOf(AbstractTotal::class, new GiftItemAddressTotal());
    }

    public function testReturnZeroIfOnlyNonGiftItemIsPassed()
    {
        $this->assertSame(0, (new GiftItemAddressTotal())->getGiftItemTotalSum());
    }

    public function testReturnZeroIfNonGiftItemPassed()
    {
        $nonGiftItem = $this->createItemWithRowTotal(10);
        $this->assertSame(0, (new GiftItemAddressTotal())->getGiftItemTotalSum($nonGiftItem));
    }

    public function testReturnsGiftItemRowTotal()
    {
        $rowTotal = 6;
        $giftItem = $this->createGiftItemWithRowTotal($rowTotal);
        $this->assertSame($rowTotal, (new GiftItemAddressTotal())->getGiftItemTotalSum($giftItem));
    }

    /**
     * @param int|float $rowTotal
     * @return Quote\Item\AbstractItem|\PHPUnit_Framework_MockObject_MockObject
     */
    public function createGiftItemWithRowTotal($rowTotal, $baseRowTotal = null): Quote\Item\AbstractItem
    {
        $option = $this->createMock(Quote\Item\Option::class);
        $option->method('getValue')->willReturn(1);
        $giftItem = $this->createItemWithRowTotal($rowTotal, $baseRowTotal);
        $giftItem->method('getOptionByCode')->with(GiftItemManager::OPTION_IS_GIFT)->willReturn($option);

        return $giftItem;
    }

    public function testReturnsSumOfGiftItemTotalsOnly()
    {
        $items = [
           $this->createItemWithRowTotal(1),
           $this->createItemWithRowTotal(2),
           $this->createGiftItemWithRowTotal(4),
           $this->createGiftItemWithRowTotal(8),
        ];
        $this->assertSame(12, (new GiftItemAddressTotal())->getGiftItemTotalSum(...$items));
    }

    public function testReturnsSumOfGiftItemBaseTotalsOnly()
    {
        $items = [
            $this->createItemWithRowTotal(0, 2),
            $this->createItemWithRowTotal(0, 4),
            $this->createGiftItemWithRowTotal(0, 8),
            $this->createGiftItemWithRowTotal(0, 16),
        ];
        $this->assertSame(24, (new GiftItemAddressTotal())->getGiftItemBaseTotalSum(...$items));
    }
}
