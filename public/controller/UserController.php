<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Teste\Models\Usuario;

require_once __DIR__ . "/../middleware/Auth.php";
require_once __DIR__ . "/../models/Usuario.php";
require_once __DIR__ . "/../database/UserDB.php";
final class UserController
{

       public  function register(Request $request, Response $response, $args)
       {
              $body = $request->getParsedBody();

              $user = new Usuario();
              $user->setUsername($body["username"]);
              $user->setEmail($body["email"]);
              $user->setPassword($body["password"]);
              $banco=new UserDB();
              $result=$banco->save($user);            

              $response->getBody()->write(json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
              return $response->withHeader("Content-Type", "application/json")->withStatus(201);
       }

       public function login(Request $request, Response $response, $args)
       {
              $body = $request->getParsedBody();
              $banco=new UserDB();

              $user = new Usuario();
              $user->setEmail($body["email"]);
              $user->setPassword($body["password"]);
              $userScan=$banco->findByEmail($user);

              if($userScan["password"] === $body["password"]){                     
                     $auth = new Auth();
                     $token = $auth->GenerateToken($user);
                     $response->getBody()->write(json_encode(["auth"=>true,"token"=>$token], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
                     return $response->withHeader("Content-Type", "application/json")->withStatus(201);
              }

              $response->getBody()->write(json_encode(["auth"=>false,"token"=>null], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
              return $response->withHeader("Content-Type", "application/json")->withStatus(401);

       }
}
