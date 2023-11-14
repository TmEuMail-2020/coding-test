<?php

namespace App\Domain\Discount;

interface IDiscountStrategy
{
    public function calculateDiscountAndReason(\App\Domain\Discount\Order $order): \App\Domain\Discount\Discount;
}
