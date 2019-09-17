<?php
declare(strict_types=1);

namespace Example\GiftItem\Model\Totals;

use Example\GiftItem\Model\GiftItemManager;
use Magento\Quote\Model\Quote\Item\AbstractItem;
use Magento\Sales\Model\Order\Total\AbstractTotal;

use function array_filter as filter;
use function array_map as map;
use function array_sum as sum;

class GiftItemAddressTotal extends AbstractTotal
{
    public function collect()
    {
//          Subtract gift item row totals sum from subtotal
//          Subtract gift item base row totals sum from base subtotal
//          Set calculation_price of every gift item to 0
//          Set base_calculation_price of every gift item to 0
//          Call calcRowTotal on each item
    }

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

    private function isGift(AbstractItem $item)
    {
        $option = $item->getOptionByCode(GiftItemManager::OPTION_IS_GIFT);
        return $option && $option->getValue();
    }
}