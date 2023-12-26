<?php

namespace API\Models;

use BadMethodCallException;
use InvalidArgumentException;

require_once "./vendor/autoload.php";

class Token
{
    private $header;
    private $payload;
    private $signature;
    private $token;
    private bool $status = false;

    public function getToken()
    {
        return $this->token;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function __construct($log)
    {
        $this->header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        if (gettype($log) == "array") $this->createToken($log);
        else if (gettype($log) == "string") $this->verifyToken($log);
        else throw new BadMethodCallException("Erro ao validar Token de acesso", 400);
        $this->status = true;
    }

    private function createToken(array $pay)
    {
        $time = time() + timeSession();
        $this->payload = base64_encode(json_encode(['exp' => "$time", 'id' => "{$pay['id']}", 'user' => "{$pay['name_user']}", "first_name" => "{$pay['first_name']}", "last_name" => "{$pay['last_name']}"]));
        $this->signature = base64_encode(hash_hmac('sha256', "{$this->header}.{$this->payload}", secretKey(), true));
        $this->token = "{$this->header}.{$this->payload}.{$this->signature}";
    }

    private function verifyToken(string $token)
    {
        $temp = explode('.', $token);
        $this->payload = $temp[1];
        $this->signature = base64_encode(hash_hmac('sha256', "$token[0].$token[1]", secretkey(), true));
        $temp = json_decode(base64_decode($temp[1]));
        if (!isset($temp->exp)) throw new InvalidArgumentException("Token inválido", 400);
        $temp->exp = (int) $temp->exp;
        $temp->id = (int) $temp->id;
        if ($temp->exp <= time()) {
            throw new \DomainException("Tempo de Conexão expirado", 406);
        }
        $tstPay = base64_encode(json_encode(['exp' => "$temp->exp", 'id' => "{$temp->id}", 'user' => "{$temp->user}", "first_name" => "{$temp->first_name}", "last_name" => "{$temp->last_name}"]));;
        $tstSig = base64_encode(hash_hmac('sha256', "{$this->header}.{$tstPay}", secretKey(), true));
        if ($this->payload == $tstPay) {
            echo "identico";
            $this->status = true;
            return;
        }
        throw new \DomainException("Token inválido", 400);
    }
}
