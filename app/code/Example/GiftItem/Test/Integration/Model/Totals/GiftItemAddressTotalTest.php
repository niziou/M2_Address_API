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

use function \array_filter as filter;
use function \array_values as values;

class GiftItemAddressTotalTest extends TestCase
{
    public function testInheritsAbstractAddressTotalModel()
    {
        $this->assertInstanceOf(AbstractTotal::class, new GiftItemAddressTotal());
    }

    public function testReturnZeroIfOnlyNonGiftItemIsPassed()
    {
        $this->assertSame(0, (new GiftItemAddressTotal())->getGiftItemTotalSum());
    }

}
