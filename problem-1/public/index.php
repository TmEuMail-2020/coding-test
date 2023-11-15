<?php

use App\Domain\Discount\DiscountCalculator;
use App\Domain\Discount\Over1000TotalThen10PercentDiscount;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';
define('PROJECT_ROOT', dirname(__DIR__, 2));


$app = AppFactory::create();
$app->get('/', function (Request $request, Response $response, $args) {
    $sampleOrder1 = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order1.json');
    $sampleOrder1a = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order1a.json');
    $sampleOrder3a = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order3a.json');
    $sampleOrder3 = DiscountCalculator::getOrdersFromJson(PROJECT_ROOT . '/example-orders/order3.json');
    $order = $sampleOrder1a;

    //Act
    $calc = new DiscountCalculator($order, new Over1000TotalThen10PercentDiscount());
    $discountResult = $calc->calculateDiscountAndReason();

    $response->getBody()->write((string)$discountResult->getDiscountAmount());
    return $response;
});

$app->run();
