<?php

namespace App\Tests\Domain\Discount;

use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{
    /**
     * @param string $filename
     * @return void
     */
    public function getOrdersFromJson(string $filename): Order
    {
        if (file_exists($filename)) {
            $contents = file_get_contents($filename);
            return new Order(json_decode($contents, true));
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->sampleOrder1 = $this->getOrdersFromJson(MONO_REPO_ROOT . '/example-orders/order1.json');
        $this->sampleOrder1a = $this->getOrdersFromJson(MONO_REPO_ROOT . '/example-orders/order1a.json');
    }

    public function test_can_read_data_from_incoming_data_source()
    {
        $this->assertSame(4.99, $this->sampleOrder1->getItems()[0]->getUnitPrice());
    }

    public function test_give_10_percent_discount_for_only_one_order_which_in_total_over_1000_euro(): void
    {
        //Arrange
        $order = $this->sampleOrder1a;
        $totalPrice = 1049.90;

        //Act
        $calc = new DiscountCalculator($order, new Over1000Discount10PercentDiscount());
        $discountResult = $calc->calculateDiscountAndReason();

        //Assert
        $this->assertEquals($totalPrice * 0.9, $discountResult->getTotalAfterDiscount());
    }

    public function test_for_every_product_of_category_switches_buy_five_get_sixth_free(): void
    {
        $this->markTestSkipped('This test has not been implemented yet.');
    }

    public function test_buy_two_or_more_tools_get_20_percent_discount_on_cheapest_product(): void
    {
        $this->markTestSkipped('This test has not been implemented yet.');
    }

}

class DiscountCalculator
{
    private Order $order;
    private DiscountStrategy $discountStrategy;

    public function __construct(Order $order, DiscountStrategy $discountStrategy)
    {
        $this->order = $order;
        $this->discountStrategy = $discountStrategy;
    }

    public function calculateDiscountAndReason(): Discount
    {
        return $this->discountStrategy->calculateDiscountAndReason($this->order);
    }
}

interface DiscountStrategy
{
    public function calculateDiscountAndReason(Order $order): Discount;
}

class Over1000Discount10PercentDiscount implements DiscountStrategy
{

    public function calculateDiscountAndReason(Order $order): Discount
    {
        $totalAfterDiscount = 0.0;
        $discountReason = "";

        if ($order->getTotal() > 1000) {
            $totalAfterDiscount = $order->getTotal() * 0.9;
            $discountReason = DiscountReasons::A_CUSTOMER_WHO_HAS_ALREADY_BOUGHT_FOR_OVER_1000_GETS_A_DISCOUNT_OF_10_ON_THE_WHOLE_ORDER;
        }
        return new Discount($totalAfterDiscount, $discountReason);
    }
}

class Discount
{
    private float $totalAfterDiscount;
    private string $discountReason;

    public function __construct(float $totalAfterDiscount, string $discountReason)
    {
        $this->totalAfterDiscount = $totalAfterDiscount;
        $this->discountReason = $discountReason;
    }

    public function getTotalAfterDiscount(): float
    {
        return $this->totalAfterDiscount;
    }

}

class Order
{
    private int $id;
    private int $customerId;
    private array $items;
    private float $total;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->id = (int)$data['id'];
        $this->customerId = (int)$data['customer-id'];
        $this->items = array_map(function ($item) {
            return new OrderItem($item);
        }, $data['items']);
        $this->total = (float)$data['total'];
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

}


class OrderItem
{
    private int $productId;
    private int $quantity;
    private float $unitPrice;
    private float $total;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->productId = (int)$data['product-id'];
        $this->quantity = (int)$data['quantity'];
        $this->unitPrice = (float)$data['unit-price'];
        $this->total = (float)$data['total'];
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

}


class DiscountReasons
{

    public const A_CUSTOMER_WHO_HAS_ALREADY_BOUGHT_FOR_OVER_1000_GETS_A_DISCOUNT_OF_10_ON_THE_WHOLE_ORDER = "A customer who has already bought for over € 1000, gets a discount of 10% on the whole order. ";
}
