<?php

use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectId;
use MongoDB\Driver\Exception\ConnectionTimeoutException as ExceptionError;


require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/../../");
$dotenv->load();



$mongo = new Mongo(getenv("DB_URL"));



class Banco
{
    public function findAll()
    {
        try {
            global $mongo;
            $db=$mongo->banco;
            $collection=$db->cliente;
            $result = $collection->find()->toArray();
            return $result;
        } catch (ExceptionError $e) {
            return $e->getMessage();
        }
    }
    //******************************************************************** */
    public function findById(string $id)
    {
        try {
            global $mongo;
            $db=$mongo->banco;
            $collection=$db->cliente;
            $result = $collection->findOne(["_id"=> new ObjectId($id)]);
            if(empty($result)){
                return "";
            }else{
                return $result;                
            }
        } catch (ExceptionError $e) {
            return $e->getMessage();
        }
    }
    //******************************************************************** */
    public function save(Cliente $cliente){
        try {
            global $mongo;
            $db=$mongo->banco;
            $collection=$db->cliente;
            $result = $collection->insertOne($this->toObject($cliente));
            return $result;
        } catch (ExceptionError $e) {
            return $e->getMessage();
        }

    }
    //******************************************************************** */
    public function update(string $id,Cliente $cliente){
        try {
            global $mongo;
            $db=$mongo->banco;
            $collection=$db->cliente;
            $updateCliente=$collection->updateOne(
            ['_id'=>new ObjectId($id)],
            ['$set'=>[
                "nome"=>$cliente->getNome(),
                "telefone"=>$cliente->getTelefone(),
                "email"=>$cliente->getEmail(),
                "cep"=>$cliente->getCep(),                
                ]]
            );
            return $updateCliente;

        }catch(ExceptionError $e){
            return $e->getMessage();
        }
    }
    //******************************************************************** */
    public function delete(string $id){
        try {
            global $mongo;
            $db=$mongo->banco;
            $collection=$db->cliente;
            $deleteCliente=$collection->deleteOne(["_id"=>new ObjectId($id)]);
            return $deleteCliente;
            //code...
        } catch (ExceptionError $e) {
            return $e->getMessage();
        }

    }
    //******************************************************************** */
    public function toObject(Cliente $cliente){
        $dados = [
            "data"=>$cliente->getData(),
            "nome"=>$cliente->getNome(),
            "telefone"=>$cliente->getTelefone(),
            "email"=>$cliente->getEmail(),
            "cep"=>$cliente->getCep()
        ];
        return $dados;
    } 
}
