<?php

use Teste\Models\Usuario;

require __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . "/../../");
$dotenv->load();
$key=getenv("SECRET_KEY");
final class Auth{
    
    public function GenerateToken(Usuario $user){
        global $key;
        $payload = array(
            'iss' => 'slim4framework@gmail.com',
            "int" => time(),  
            "exp" => time() + (60 * 60),
            "email" => $user->getEmail()
        );
        $jwt = Firebase\JWT\JWT::encode($payload,$key);
        return $jwt;
    }

}