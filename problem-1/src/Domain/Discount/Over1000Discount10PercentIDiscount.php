<?php

namespace App\Domain\Discount;

class Over1000Discount10PercentIDiscount implements \App\Domain\Discount\IDiscountStrategy
{

    public function calculateDiscountAndReason(\App\Domain\Discount\Order $order): Discount
    {
        $discount = 0.0;
        $discountReason = "";

        if ($order->getTotal() > 1000) {
            $discount = $order->getTotal() * (1 - 0.9);
            $discountReason = DiscountReasons::A_CUSTOMER_WHO_HAS_ALREADY_BOUGHT_FOR_OVER_1000_GETS_A_DISCOUNT_OF_10_ON_THE_WHOLE_ORDER;
        }
        return new Discount($discount, $discountReason);
    }
}
