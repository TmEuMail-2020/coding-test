<?php

namespace App\Domain\Discount\Model\Strategy;

use App\Domain\Discount\Model\Discount;
use App\Domain\Discount\Model\DiscountReasons;
use App\Domain\Discount\Model\Order;

class EverySixthCategorySwitchDiscount implements IDiscountStrategy
{

    private array $productDictionary;

    public function __construct(array $productDictionary)
    {
        $this->productDictionary = $productDictionary;
    }

    public function calculateDiscountAndReason(Order $order): Discount
    {
        /* IMPORTANT assumption:

        order.json "items" - "product-id" always is unique in the items level, meaning will never happen
            two duplicate product-id showing up as two items

        valid structure:
            {
              "id": "2",
              "customer-id": "2",
              "items": [
                {
                  "product-id": "B102",
                  "quantity": "5",
                  "unit-price": "4.99",
                  "total": "24.95"
                }
              ],
              "total": "24.95"
            }
        INVALID structure:
            {
              "id": "1",
              "customer-id": "1",
              "items": [
                {
                  "product-id": "B102",
                  "quantity": "10",
                  "unit-price": "4.99",
                  "total": "49.90"
                },
                {
                  "product-id": "B102",
                  "quantity": "10",
                  "unit-price": "4.99",
                  "total": "49.90"
                }
              ],
              "total": "49.90"
            }
        */
        $discountAmount = 0;
        $hit = 0;
        // Assumption: Buy 5, get 6th free = you MUST have 6 item. So if quantity = 5, then no discount
        foreach ($order->getItems() as $key => $item) {
            if ($this->productDictionary[$item->getProductId()] === "2") {
                $discountAmount = (floor($item->getQuantity() / 6)) * $item->getUnitPrice();
            }
        }


        return new Discount($discountAmount, DiscountReasons::EVERY_6TH_CATEGORY_SWITCH_DISCOUNT->value);
    }

}
