<?php

use App\Domain\Discount\DiscountCalculator;
use App\Domain\Discount\EverySixthCategorySwitchDiscount;
use App\Domain\Discount\Over1000TotalThen10PercentDiscount;
use App\Domain\Discount\TwoOrMoreCategoryToolsGet20PercentDiscount as TwoOrMoreCategoryToolsGet20PercentDiscountAlias;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';
define('PROJECT_ROOT', dirname(__DIR__, 2));


$sampleOrder1 = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order1.json');
$sampleOrder1a = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order1a.json');
$sampleOrder3a = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order3a.json');
$sampleOrder3 = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order3.json');
$productDictionary = DiscountCalculator::getProductDictionaryFromJson(PROJECT_ROOT . '/data/products.json');

$app = AppFactory::create();
$app->get(
    '/calculateOver1000TotalThen10PercentDiscount',
    function (Request $request, Response $response, $args) use ($sampleOrder1a) {
        $order = $sampleOrder1a;

        //Act
        $calc = new DiscountCalculator($order, new Over1000TotalThen10PercentDiscount());
        $discountResult = $calc->calculateDiscountAndReason();

        $response->getBody()->write(json_encode($discountResult));
        return $response->withHeader('Content-Type', 'application/json');
    }
);
$app->get(
    '/',
    function (Request $request, Response $response, $args) {
        $response->getBody()->write(json_encode("Hello World"));
        return $response->withHeader('Content-Type', 'application/json');
    }
);
$app->get('/calculateEverySixthCategorySwitchDiscount', function (Request $request, Response $response, $args) use ($sampleOrder1a, $productDictionary) {
    $order = $sampleOrder1a;

    //Act
    $calc = new DiscountCalculator($order, new EverySixthCategorySwitchDiscount($productDictionary));
    $discountResult = $calc->calculateDiscountAndReason();

    $response->getBody()->write(json_encode($discountResult));
    return $response->withHeader('Content-Type', 'application/json');
});
$app->get('/calculateTwoOrMoreCategoryToolsGet20PercentDiscountAlias', function (Request $request, Response $response, $args) use ($sampleOrder1a, $productDictionary) {
    $order = $sampleOrder1a;

    //Act
    $calc = new DiscountCalculator($order, new TwoOrMoreCategoryToolsGet20PercentDiscountAlias($productDictionary));
    $discountResult = $calc->calculateDiscountAndReason();

    $response->getBody()->write(json_encode($discountResult));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
