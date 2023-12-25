<?php

namespace API\Models;

use InvalidArgumentException;
use mysqli;

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
        // echo "fechando";
        // var_dump($this->conn);
        $this->conn->close();
    }
}
