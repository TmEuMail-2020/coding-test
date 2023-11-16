<?php

use App\Domain\Discount\Model\Order;
use App\Domain\Discount\Model\Strategy\EverySixthCategorySwitchDiscount;
use App\Domain\Discount\Model\Strategy\Over1000TotalThen10PercentDiscount;
use App\Domain\Discount\Model\Strategy\TwoOrMoreCategoryToolsGet20PercentDiscount as TwoOrMoreCategoryToolsGet20PercentDiscountAlias;
use App\Domain\Discount\Service\DiscountCalculator;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require __DIR__ . '/../vendor/autoload.php';
define('PROJECT_ROOT', dirname(__DIR__, 2));

$productDictionary = DiscountCalculator::getProductDictionaryFromJson(PROJECT_ROOT . '/data/products.json');

$app = AppFactory::create();
//  Out of the box, PSR-7 implementations do not support these formats, hence middleware is needed
//      https://stackoverflow.com/a/57524022/22349977
//      https://www.slimframework.com/docs/v4/middleware/body-parsing.html
$app->addBodyParsingMiddleware();
$app->post(
    '/discount/strategy/{id}',
    function (Request $request, Response $response, array $args) use ($productDictionary) {
        $id = $args['id'];
        $order = new Order($request->getParsedBody(), true);

        try {
            $calc = match ($id) {
                '1' => new DiscountCalculator(
                    $order, new Over1000TotalThen10PercentDiscount()
                ),
                '2' => new DiscountCalculator(
                    $order,
                    new EverySixthCategorySwitchDiscount($productDictionary)
                ),
                '3' => new DiscountCalculator(
                    $order,
                    new TwoOrMoreCategoryToolsGet20PercentDiscountAlias($productDictionary)
                ),
                default => throw new Exception("Unknown strategy ID: $id"),
            };
            $discountResult = $calc->calculateDiscountAndReason();
            $response->getBody()->write(json_encode($discountResult));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $response->getBody()->write(json_encode($e->getMessage()));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
);

$app->run();
