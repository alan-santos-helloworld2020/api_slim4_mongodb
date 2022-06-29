<?php


use MongoDB\Client as Mongo;
use MongoDB\BSON\ObjectId;
use MongoDB\Driver\Exception\ConnectionTimeoutException as ExceptionError;
use Teste\Models\Usuario;

require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/../../");
$dotenv->load();



$mongo = new Mongo(getenv("DB_URL"));

final class UserDB
{
    public function findByEmail(Usuario $user){
        try {
            global $mongo;
            $db = $mongo->banco;
            $collection = $db->user;
            $userScan=$collection->findOne(["email"=>$user->getEmail()]);
            return $userScan;
            //code...
        } catch (ExceptionError $e) {
            //throw $th;
            return $e->getMessage();
        }
    }
    //******************************************************************** */
    public function save(Usuario $user)
    {
        try {
            global $mongo;
            $db = $mongo->banco;
            $collection = $db->user;
            $result = $collection->insertOne($this->toObject($user));
            return $result;
        } catch (ExceptionError $e) {
            return $e->getMessage();
        }
    }
    //******************************************************************** */
    public function toObject(Usuario $user)
    {
        $dados = [
            "username" => $user->getUsername(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword()            
        ];
        return $dados;
    }
}
