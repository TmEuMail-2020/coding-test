<?php

namespace App\Tests\Domain\Discount;

use App\Domain\Discount\DiscountCalculator;
use App\Domain\Discount\DiscountReasons;
use App\Domain\Discount\EverySixthCategorySwitchDiscount;
use App\Domain\Discount\Order;
use App\Domain\Discount\Over1000TotalThen10PercentDiscount;
use App\Domain\Discount\TwoOrMoreCategoryToolsGet20PercentDiscount;
use PHPUnit\Framework\TestCase;

class DiscountTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->sampleOrder1 = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order1.json');
        $this->sampleOrder1a = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order1a.json');
        $this->sampleOrder3a = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order3a.json');
        $this->sampleOrder3 = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order3.json');
    }

    public function test_can_read_data_from_incoming_data_source()
    {
        $this->assertSame(4.99, $this->sampleOrder1->getItems()[0]->getUnitPrice());
    }

    public function test_give_10_percent_discount_for_only_one_item_which_in_total_over_1000_euro(): void
    {
        //Arrange
        $order = $this->sampleOrder1a;
        $totalPrice = 1049.90;

        //Act
        $calc = new DiscountCalculator($order, new Over1000TotalThen10PercentDiscount());
        $discountResult = $calc->calculateDiscountAndReason();

        //Assert
        $this->assertEquals($totalPrice * (1 - 0.9), $discountResult->getDiscountAmount());
    }

    public function test_give_10_percent_discount_for_multiple_items_which_in_total_over_1000_euro(): void
    {
        //Arrange
        $order = $this->sampleOrder3a;
        $totalPrice = 1069.00;

        //Act
        $calc = new DiscountCalculator($order, new Over1000TotalThen10PercentDiscount());
        $discountResult = $calc->calculateDiscountAndReason();

        //Assert
        $this->assertEquals($totalPrice * (1 - 0.9), $discountResult->getDiscountAmount());
    }

    public function test_give_10_percent_discount_with_correct_reason(): void
    {
        //Arrange
        $order = $this->sampleOrder1a;
        $tenPercentDiscountReasonAfterCalculation = DiscountReasons::A_CUSTOMER_WHO_HAS_ALREADY_BOUGHT_FOR_OVER_1000_GETS_A_DISCOUNT_OF_10_ON_THE_WHOLE_ORDER->value;

        //Act
        $calc = new DiscountCalculator($order, new Over1000TotalThen10PercentDiscount());
        $discountResult = $calc->calculateDiscountAndReason();

        //Assert
        $this->assertEquals($tenPercentDiscountReasonAfterCalculation, $discountResult->getDiscountReason());
    }

    public function test_give_sixth_item_for_free_when_in_category_switches(): void
    {
        //Arrange
        $order = $this->sampleOrder1;
        $productDictionary = DiscountCalculator::getProductDictionaryFromJson(PROJECT_ROOT . '/data/products.json');

        //Act
        $calc = new DiscountCalculator($order, new EverySixthCategorySwitchDiscount($productDictionary));
        $discountResult = $calc->calculateDiscountAndReason();

        //Assert
        $this->assertEquals(4.99, $discountResult->getDiscountAmount());
    }

    public function test_buy_two_or_more_tools_get_20_percent_discount_on_cheapest_product(): void
    {
        //Arrange
        $order = $this->sampleOrder3;
        $productDictionary = DiscountCalculator::getProductDictionaryFromJson(PROJECT_ROOT . '/data/products.json');

        //Act
        $calc = new DiscountCalculator($order, new TwoOrMoreCategoryToolsGet20PercentDiscount($productDictionary));
        $discountResult = $calc->calculateDiscountAndReason();

        //Assert
        $this->assertEquals(3.9, $discountResult->getDiscountAmount());
    }

    public function test_give_chained_discount_10_percent_discount_and_sixth_item_for_free_when_in_category_switches(): void
    {
        //TODO: chained discount has many considerations, e.g. order of discount, discount amount, etc. Hence now stop
        //Arrange
        $order = $this->sampleOrder1;
        $productDictionary = DiscountCalculator::getProductDictionaryFromJson(PROJECT_ROOT . '/data/products.json');

        //Act
        $everySixthCatSwitchDiscountCalculator = new DiscountCalculator(
            $order,
            new EverySixthCategorySwitchDiscount($productDictionary)
        );
        $everySixthCatSwitchDiscountResult = $everySixthCatSwitchDiscountCalculator->calculateDiscountAndReason();

        $over1000TotalThen10PercentDiscountCalculator = new DiscountCalculator(
            $order,
            new Over1000TotalThen10PercentDiscount()
        );
        $over1000TotalThen10PercentDiscountCalculatorResult = $over1000TotalThen10PercentDiscountCalculator->calculateDiscountAndReason(
        );
        //Assert
        $this->assertEquals(
            4.99 + 0.0,
            $everySixthCatSwitchDiscountResult->getDiscountAmount(
            ) + $over1000TotalThen10PercentDiscountCalculatorResult->getDiscountAmount()
        );
    }


}
