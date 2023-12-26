<?php

namespace API\Models;

class User
{
    protected int $id;              // auto increment
    protected string $userName;     // nome de usuario
    private string $password;     // senha
    protected string $email;        // email
    protected string $firstName;    // primeiro nome
    protected string $lastName;     // restante do nome

    //{$query->user}\", \"{$query->password}\", \"{$query->email}\", \"{$query->f_name}\", \"{$query->l_name}
    public function __construct(array $temp)
    {
        $this->id = $temp["id"];
        $this->userName = $temp["name_user"];
        $this->password = $temp["pass_word"];
        $this->email = $temp["email"];
        $this->firstName = $temp["first_name"];
        $this->lastName = $temp["last_name"];
    }

    protected function getInfo()
    {
        return ["id" => "{$this->id}", "user_name" => "{$this->userName}", "email" => "{$this->email}", "first_name" => "{$this->firstName}", "last_name" => "{$this->lastName}"];
    }
}
