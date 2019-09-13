<?php
declare(strict_types=1);

namespace Example\GiftItem\Model\Totals;

use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Sales\Model\Order\Total\AbstractTotal;

use function array_filter as filter;
use function array_map as map;
use function array_sum as sum;

class GiftItemAddressTotal extends AbstractTotal
{
    public function getGiftItemTotalSum(AbstractItem ...$items)
    {
        return $this->sumGiftItems('getRowTotal', ...$items);
    }

    private function sumGiftItems($fn, AbstractItem ...$items)
    {
        return sum($this->mapGiftItems($fn, ...$items));
    }

    private function mapGiftItems($fn, AbstractItem ...$items)
    {
        return map(function (AbstractItem $item) use ($fn) {
            return is_callable($fn) ? $fn($item) : $item->{$fn}();
        }, filter($items, [$this, 'isGift']));

    }
}