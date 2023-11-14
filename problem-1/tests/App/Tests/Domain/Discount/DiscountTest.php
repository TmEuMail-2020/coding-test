<?php

namespace App\Tests\Domain\Discount;

use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $filename = MONO_REPO_ROOT . '/example-orders/order1.json';
        if (file_exists($filename)) {
            $contents = file_get_contents($filename);
            $this->order = new Order(json_decode($contents, true));
        }
    }

    public function test_can_read_data_from_incoming_data_source()
    {
        //Act

        //Assert
        $this->assertSame(4.99, $data->getItems()[0]->getUnitPrice());

    }

    public function test_give_10_percent_discount_for_only_one_order_which_in_total_over_1000_euro(): void
    {
        //Arrange
        $this->markTestSkipped('This test has not been implemented yet.');
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


class Order
{
    private int $id;
    private int $customerId;
    private array $items;
    private int $total;

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
