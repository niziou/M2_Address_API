<?php
declare(strict_types=1);

namespace Example\GiftItem\Model\Totals;

use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;
use PHPUnit\Framework\TestCase;

class GiftItemAddressTotalTest extends TestCase
{
    public function testInheritsAbstractAdressTotalModel()
    {
        $this->assertInstanceOf(AbstractTotal::class, new GiftItemAddressTotal());
    }
}