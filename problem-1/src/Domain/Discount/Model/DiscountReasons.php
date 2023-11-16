<?php

namespace App\Domain\Discount\Model;

enum DiscountReasons: string
{

    case A_CUSTOMER_WHO_HAS_ALREADY_BOUGHT_FOR_OVER_1000_GETS_A_DISCOUNT_OF_10_ON_THE_WHOLE_ORDER = "A customer who has already bought for over € 1000, gets a discount of 10% on the whole order. ";
    case EVERY_6TH_CATEGORY_SWITCH_DISCOUNT = 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.';
    case BUY_TWO_OR_MORE_TOOLS_GET_20_PERCENT_DISCOUNT_ON_CHEAPEST_PRODUCT = 'If you buy two or more products of category "Tools" (id 1), you get a 20% discount on the cheapest product';
    case NOT_ELIGIBLE_FOR_THIS_DISCOUNT = 'Not eligible for this discount';
}
