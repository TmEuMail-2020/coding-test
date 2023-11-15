<?php

namespace App\Domain\Discount;


class DiscountCalculator
{
    private Order $order;
    private IDiscountStrategy $discountStrategy;

    public function __construct(
        Order $order,
        IDiscountStrategy $discountStrategy
    ) {
        $this->order = $order;
        $this->discountStrategy = $discountStrategy;
    }

    public static function getOrdersFromJson(string $filename): ?Order
    {
        if (file_exists($filename)) {
            $contents = file_get_contents($filename);
            return new Order(json_decode($contents, true));
        }

        return null;
    }

    /**
     * @param string $filename
     * @return Product[]|null
     */
    public static function getProductDictionaryFromJson(string $filename): ?array
    {
        $productDictionary = [];
        if (file_exists($filename)) {
            $contents = file_get_contents($filename);
            $jsonObj = json_decode($contents, true);
            foreach ($jsonObj as $productInfo) {
//                $productDictionary[] = new Product($productInfo);
                $productDictionary[$productInfo['id']] = $productInfo['category'];
            }
            return $productDictionary;
        }
        return null;
    }

    public function calculateDiscountAndReason(): Discount
    {
        return $this->discountStrategy->calculateDiscountAndReason($this->order);
    }
}
