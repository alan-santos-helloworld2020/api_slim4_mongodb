<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Teste\Models\Cliente;


require_once __DIR__ . "/../database/Banco.php";


final class ClienteController
{

    public function findAll(Request $request, Response $response, $args)
    {
        $banco = new Banco();
        $response->getBody()->write(json_encode($banco->findAll(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }

    public function findById(Request $request, Response $response, $args)
    {
        $id = $args["id"];
        $banco = new Banco();
        $res = $banco->findById($id);
        $response->getBody()->write(json_encode($res, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);

    }


    public function save(Request $request, Response $response, $args)
    {

        $body = $request->getParsedBody();
        $data = date('d-m-Y');

        $cliente = new Cliente();
        $cliente->setData($data);
        $cliente->setNome($body["nome"]);
        $cliente->setTelefone($body["telefone"]);
        $cliente->setEmail($body["email"]);
        $cliente->setCep($body["cep"]);

        $banco = new Banco();
        $banco->save($cliente);

        $response->getBody()->write(json_encode($banco->toObject($cliente), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        return $response->withHeader("Content-Type", "application/json")->withStatus(201);
    }


    public function update(Request $request, Response $response, $args)
    {
        $id=$args["id"];
        $body=$request->getParsedBody();
        $banco=new Banco();

        $cliente = new Cliente();
        $cliente->setNome($body["nome"]);
        $cliente->setTelefone($body["telefone"]);
        $cliente->setEmail($body["email"]);
        $cliente->setCep($body["cep"]);

        $res=$banco->update($id,$cliente);

        $response->getBody()->write(json_encode($res, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }


    public function delete(Request $request, Response $response, $args){
        $id=$args["id"];
        $banco=new Banco($id);
        $deleteCliente=$banco->delete($id);
        $response->getBody()->write(json_encode(["id"=>$deleteCliente], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        return $response->withHeader("Content-Type", "application/json")->withStatus(200);
    }
    
}
