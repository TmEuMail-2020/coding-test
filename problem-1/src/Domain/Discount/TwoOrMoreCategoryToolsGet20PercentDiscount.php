<?php

namespace App\Domain\Discount;

use function PHPUnit\Framework\throwException;

class TwoOrMoreCategoryToolsGet20PercentDiscount implements IDiscountStrategy
{

    private array $productDictionary;

    public function __construct(array $productDictionary)
    {
        $this->productDictionary = $productDictionary;
    }

    public function calculateDiscountAndReason(Order $order): Discount
    {
        $discountAmount = 0;
        $hit = 0;
        /**
         * @var OrderItem[] $itemsWithHit
         */
        $itemsWithHit = [];
        foreach ($order->getItems() as $key => $item) {
            if ($this->productDictionary[$item->getProductId()] === "1") {
                $itemsWithHit[$key] = $item;
                $hit++;
            }
        }
        usort($itemsWithHit, function ($a, $b) {
            return $a->getUnitPrice() <=> $b->getUnitPrice();
        });


        return new Discount($itemsWithHit[0]->getUnitPrice(), DiscountReasons::EVERY_6TH_CATEGORY_TOOLS_SWITCHED_TO_20_PERCENT_DISCOUNT->value);
    }

}
