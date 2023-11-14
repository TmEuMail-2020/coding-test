<?php

namespace App\Domain\Discount;

use function PHPUnit\Framework\throwException;

class EverySixthCategorySwitchDiscount implements IDiscountStrategy
{

    private array $productDictionary;

    public function __construct(array $productDictionary)
    {
        $this->productDictionary = $productDictionary;
    }

    public function calculateDiscountAndReason(Order $order): Discount
    {
        $itemHitForDiscount = [];
        $hit = 0;
        foreach ($order->getItems() as $key => $item) {
//            $itemHitForDiscount[]['category'] = $this->productDictionary[$item->getProductId()];
            if ($this->productDictionary[$item->getProductId()] === "2") {
               $hit++;
            }
            if ($hit % 5 === 0) {
                $itemHitForDiscount[$key] = $item;
                $hit = 0;
            }
        }

        $discountAmount = 0;
        foreach ($itemHitForDiscount as $discountedItem) {
           $discountAmount+= $discountedItem->getUnitPrice();
        }

        return new Discount($discountAmount, "");
    }

}
