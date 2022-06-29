<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Middleware\MethodOverrideMiddleware;


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/controller/ClienteController.php';
require __DIR__ . '/controller/UserController.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/../");
$dotenv->load();

$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$overrideMidleware = new MethodOverrideMiddleware();
$app->add($overrideMidleware);

//***********configuração do cors***********************/
$app->add(function(Request $request,RequestHandler $handler){
    $response = $handler->handle($request);
    return $response->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Credentials', 'true')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

//***********configuração da autorização***************/
$app->add(new Tuupola\Middleware\JwtAuthentication([
    "ignore"=>["/user"],
    "header"=>"Authorization",
    "attribute" => "jwt",
    "algorithm" => ["HS256"],
    "secret" => getenv("SECRET_KEY"),
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        $response->getBody()->write(
            json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
        return $response->withHeader("Content-Type", "application/json");
    }
]));

//***********grupo de rota usuário*********************/
$app->group("/user",function(RouteCollectorProxy $group){
    $group->post('/register',UserController::class . ":register");
    $group->post('/login',UserController::class . ":login");
});


//***********grupo de rota cliente*********************/
$app->group("/cliente",function(RouteCollectorProxy $group){
    $group->get('',ClienteController::class . ":findAll");   
    $group->get('/{id}',ClienteController::class . ":findById");
    $group->post('',ClienteController::class . ":save");
    $group->put('/{id}',ClienteController::class . ":update");
    $group->delete('/{id}',ClienteController::class . ":delete");
});



$app->run();