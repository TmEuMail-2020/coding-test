<?php

namespace App\Tests\Domain\Discount;

use PHPUnit\Framework\TestCase;

//define('PROJECT_ROOT', )

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
        //Act

        //Assert
        $this->assertSame(4.99, $data->getItems()[0]->getUnitPrice());

    }

    public function testGive10PercentDiscountForOrdersOver1000Euro(): void
    {
        //Arrange
        $this->markTestSkipped('This test has not been implemented yet.');
    }

    public function testForEveryProductOfCategorySwitchesBuyFiveGetSixthFree(): void
    {
        $this->markTestSkipped('This test has not been implemented yet.');
    }

    public function testBuyTwoOrMoreToolsGet20PercentDiscountOnCheapestProduct(): void
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
