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
        foreach ($order->getItems() as $key => $item) {
            if ($this->productDictionary[$item->getProductId()] === "1") {

            }
        }


        return new Discount($discountAmount, DiscountReasons::EVERY_6TH_CATEGORY_SWITCH_DISCOUNT->value);
    }

}
