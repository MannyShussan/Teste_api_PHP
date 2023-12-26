<?php

namespace API\Controllers;

use API\Models\Connection;
use API\Models\Token;
use API\Models\User;
use Throwable;

class UserController extends User
{
    protected $conn;                // objeto de conexão
    protected $body;                // corpo da requisição
    protected $token;

    public function __construct(string $method = "GET")
    {
        $this->conn = new Connection("usuarios", "teste_api");
        $method = mb_strtoupper($method);
        $this->body = json_decode(file_get_contents("php://input"));
        try {
            switch ($method) {

                case "GET":
                    $res = $this->getUser();
                    parent::__construct($res);
                    $this->token = new Token($res);
                    $res = ["status" => "200", "response" => ["id" => "{$res["id"]}", "name" => "{$res['name_user']}", "email" => "{$res['email']}", "first_name" => "{$res['first_name']}", "last_name" => "{$res['last_name']}", "token" => "{$this->token->getToken()}"]];
                    $this->encoderJson($res, 200);
                    break;

                case "POST":
                    $res = $this->conn->createNewUser($this->body);
                    parent::__construct($res);
                    $res = ["status" => "201", "response" => $this->getInfo()];
                    $this->encoderJson($res, 201);
                    break;

                case 'DELETE':
                    $res = $this->conn->deleteUser($this->body);
                    $this->encoderJson($res, 410);
                    break;

                case "PUT":
                    echo "é um PUT";
                    break;

                default:
                    throw new \InvalidArgumentException("Argumento inválido", 404);
            }
        } catch (Throwable $e) {
            $arr = ["status" => "{$e->getCode()}", "response" => ["message" => "{$e->getMessage()}"]];
            $this->encoderJson($arr, $e->getCode());
        }
    }

    public function __destruct()
    {
    }

    private function getUser()
    {
        if (isset($_GET['user']) && isset($_GET['password'])) {
            return $this->conn->accesUser($_GET['user'], $_GET['password']);
        } else if (isset($_GET['token'])) {
            $this->token = new Token($_GET['token']);
            return;
        }
        throw new \DomainException("Argumento inválido", 404);
    }

    private function encoderJson($res, $code)
    {
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        http_response_code($code);
    }
}
