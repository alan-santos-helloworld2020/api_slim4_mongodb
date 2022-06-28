<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/controller/ClienteController.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->add(function(Request $request,RequestHandler $handler){
    $response = $handler->handle($request);
    return $response->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});



$app->group("/cliente",function(RouteCollectorProxy $group){
    $group->get('',ClienteController::class . ":findAll");
    $group->get('/{id}',ClienteController::class . ":findById");
    $group->post('',ClienteController::class . ":save");
    $group->put('/{id}',ClienteController::class . ":update");
    $group->delete('/{id}',ClienteController::class . ":delete");
});
    

$app->run();