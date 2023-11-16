<?php

namespace App\Domain\Discount\Model\Strategy;

use App\Domain\Discount\Model\Discount;
use App\Domain\Discount\Model\DiscountReasons;
use App\Domain\Discount\Model\Order;
use App\Domain\Discount\Model\OrderItem;

class TwoOrMoreCategoryToolsGet20PercentDiscount implements IDiscountStrategy
{

    private array $productDictionary;

    public function __construct(array $productDictionary)
    {
        $this->productDictionary = $productDictionary;
    }

    public function calculateDiscountAndReason(Order $order): Discount
    {
        // If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product.
        //  interpretation: products A,B,C from category 1, when quantity of A+B+C >= 2, then find the lowest product price among A,B,C
        /**
         * @var OrderItem[] $itemsWithHit
         */
        $itemsWithHit = [];
        foreach ($order->getItems() as $key => $item) {
            if ($this->productDictionary[$item->getProductId()] === "1") {
                $itemsWithHit[$key] = $item;
            }
        }

        //early return
        if (count($itemsWithHit) < 2) {
            return new Discount(0, DiscountReasons::NOT_ELIGIBLE_FOR_THIS_DISCOUNT->value);
        }

        $itemsWithHitByPriceAsKey = [];
        foreach ($itemsWithHit as $element) {
            $itemsWithHitByPriceAsKey[(string)$element->getUnitPrice()] = $element;
        }
        // can just do "reset($itemsWithHitByPriceAsKey)" but less readable
        ksort($itemsWithHitByPriceAsKey);
        $lowestPriceItem = $itemsWithHitByPriceAsKey[min(array_keys($itemsWithHitByPriceAsKey))];


        return new Discount(
        //TODO: should use value object to handle this kind of rounding issue
            round($lowestPriceItem->getUnitPrice() * $lowestPriceItem->getQuantity() * 0.20, 2),
            DiscountReasons::BUY_TWO_OR_MORE_TOOLS_GET_20_PERCENT_DISCOUNT_ON_CHEAPEST_PRODUCT->value
        );
    }

}
