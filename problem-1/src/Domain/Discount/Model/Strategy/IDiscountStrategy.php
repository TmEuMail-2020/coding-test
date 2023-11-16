<?php

namespace App\Domain\Discount\Model\Strategy;

use App\Domain\Discount\Model\Discount;
use App\Domain\Discount\Model\Order;

interface IDiscountStrategy
{
    public function calculateDiscountAndReason(Order $order): Discount;
}
