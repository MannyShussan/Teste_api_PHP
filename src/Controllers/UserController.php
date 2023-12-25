<?php

namespace API\Controllers;

use API\Models\Connection;

require_once 'vendor/autoload.php';

class UserController
{

    protected int $id;
    protected string $userName;
    protected string $password;
    protected string $email;
    protected string $firstName;
    protected string $lastName;
    protected $conn;

    public function __construct(string $user, string $pass, string $method = "GET")
    {
        $this->conn = new Connection("usuarios", "teste_api");
        $this->userName = $user;
        $this->password = $pass;
        $method = mb_strtoupper($method);
        switch ($method) {
            case "GET":
                echo "é um GET";
                var_dump(file_get_contents("php://input"));
                break;
            case "POST":
                echo "é um POST";
                var_dump(file_get_contents("php://input"));
                break;
            case 'DELETE':
                echo "é um DELETE";
                var_dump(file_get_contents("php://input"));
                break;
            case "PUT":
                echo "é um PUT";
                var_dump(file_get_contents("php://input"));
                break;
        }
    }

    public function __destruct()
    {
    }

    protected function getUser(string $user, string $pass)
    {
    }
}
