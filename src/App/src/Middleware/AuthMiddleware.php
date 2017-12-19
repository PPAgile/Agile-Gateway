<?php

namespace App\Middleware;

use Slim\Middleware\HttpBasicAuthentication;
use Zend\Diactoros\Response\JsonResponse;

class AuthMiddleware extends HttpBasicAuthentication {

    public function __construct() {
        $options = [
            "secure" => false,
            "users" => $this->getAllowedUsers(),
            "error" => function ($request, $response, $arguments) {
                        $data = [];
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return new JsonResponse("errrror", 200, array('Access-Control-Allow-Origin' => '*'));
            }
        ];
        
        parent::__construct($options);
    }
    
    private function getAllowedUsers() {
        $allowedUsers = [];
        
        $allowedUsers = [
                "root" => "ab",
                "user" => "passw0rd"
            ];
        return $allowedUsers;
    }
    
}
