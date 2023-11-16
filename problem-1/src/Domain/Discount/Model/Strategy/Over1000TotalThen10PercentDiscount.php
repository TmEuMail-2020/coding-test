<?php

namespace App\Domain\Discount\Model\Strategy;

use App\Domain\Discount\Model\Discount;
use App\Domain\Discount\Model\DiscountReasons;
use App\Domain\Discount\Model\Order;

class Over1000TotalThen10PercentDiscount implements IDiscountStrategy
{

    public function calculateDiscountAndReason(Order $order): Discount
    {
        $discount = 0.0;
        $discountReason = "";

        if ($order->getTotal() > 1000) {
            $discount = $order->getTotal() * (0.1);
            $discountReason = DiscountReasons::A_CUSTOMER_WHO_HAS_ALREADY_BOUGHT_FOR_OVER_1000_GETS_A_DISCOUNT_OF_10_ON_THE_WHOLE_ORDER->value;
        }
        return new Discount($discount, $discountReason);
    }
}
