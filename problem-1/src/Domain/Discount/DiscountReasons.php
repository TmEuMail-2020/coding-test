<?php

namespace App\Domain\Discount;

enum DiscountReasons: string
{

    case EVERY_6TH_CATEGORY_SWITCH_DISCOUNT = 'For every product of category "Switches" (id 2), when you buy five, you get a sixth for free.';
    case A_CUSTOMER_WHO_HAS_ALREADY_BOUGHT_FOR_OVER_1000_GETS_A_DISCOUNT_OF_10_ON_THE_WHOLE_ORDER = "A customer who has already bought for over € 1000, gets a discount of 10% on the whole order. ";
    case EVERY_6TH_CATEGORY_TOOLS_SWITCHED_TO_20_PERCENT_DISCOUNT = 'For every product of category "Tools" (id 1), when you buy two or more, the price for each is reduced by 20%';
    case BUY_TWO_OR_MORE_TOOLS_GET_20_PERCENT_DISCOUNT_ON_CHEAPEST_PRODUCT = 'test buy two or more tools get 20 percent discount on cheapest product';
    case NOT_APPLICABLE = 'not applicable';
}
