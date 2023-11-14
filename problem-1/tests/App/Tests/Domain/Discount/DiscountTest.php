<?php

namespace App\Tests\Domain\Discount;

use App\Domain\Discount\Order;
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
        $calc = new \App\Domain\Discount\DiscountCalculator($order, new \App\Domain\Discount\Over1000Discount10PercentIDiscount());
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
