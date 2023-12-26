<?php

namespace API\Models;

use DomainException;
use InvalidArgumentException;
use mysqli;
use Throwable;

class Connection
{
    public $conn;
    public array $log;

    public function __construct(string $dbName, string $user)
    {
        $this->log = dbPass($dbName, $user);
        $this->conn = new mysqli($this->log['host'], $this->log['user'], $this->log['password'], $this->log['dbName']);
        if ($this->conn->connect_error) {
            throw new InvalidArgumentException("Access denied for user {$this->log['user']}");
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }

    public function createNewUser(object $query)
    {
        $sql = "SELECT * FROM usuarios WHERE email = \"{$query->email}\";";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            throw new InvalidArgumentException("E-mail já está em uso", 401);
        }
        $sql = "INSERT INTO usuarios (name_user, pass_word, email, first_name, last_name) VALUE (\"{$query->user}\", \"{$query->password}\", \"{$query->email}\", \"{$query->f_name}\", \"{$query->l_name}\");";
        if (!$this->conn->query($sql)) {
            throw new InvalidArgumentException("Erro na requisição");
        }
        $sql = "SELECT * FROM usuarios WHERE email = \"{$query->email}\";";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 0) {
            throw new InvalidArgumentException("Erro ao cadastrar novo usuário");
        }
        return $result->fetch_assoc();
    }

    public function accesUser(string $user, string $pass)
    {
        $sql = "SELECT * FROM usuarios WHERE email = \"{$user}\"";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 0) $this->erro("Usuário ou senha inválida");
        $result = $result->fetch_assoc();
        if ($pass <> $result['pass_word']) $this->erro("Usuário ou senha inválida");
        return $result;
    }

    public function deleteUser(object $query)
    {
        $sql = "SELECT * FROM usuarios WHERE id = \"{$query->id}\"";
        $result = $this->conn->query($sql);
        if ($result->num_rows == 0) $this->erro("Usuário não encontrado", 404);
        $result = $result->fetch_assoc();
        $user = $result;
        $token = new Token($query->token);
        if (!$token->getStatus()) $this->erro("Token inválido");

        if ($query->id != $result['id'] && $query->password != $result['pass_word'] && $query->email != $result['email']) throw new DomainException("Usuário não encontrado", 404);
        $sql = "DELETE FROM usuarios WHERE id = \"{$query->id}\"";
        $this->conn->query($sql);
        try {
            $res = $this->accesUser($user['email'],$user['pass_word']);
            return ["status" => "403", "response" => "Erro ao deletar usuário"];
        } catch (Throwable $e) {
            return ["status" => "410", "response" => "Usuário removido com sucesso"];
        }
    }
    private function erro(string $message, int $code = 406)
    {
        throw new DomainException($message, $code);
    }
}
