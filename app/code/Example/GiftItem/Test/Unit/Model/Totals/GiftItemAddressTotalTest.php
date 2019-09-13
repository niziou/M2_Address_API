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
}
