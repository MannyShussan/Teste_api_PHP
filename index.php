<?php

use API\Controllers\UserController;

require_once './vendor/autoload.php';


$conn = null;
try {
    if (isset($_GET['ac'])) {
        $type = mb_strtoupper($_GET['ac']);
        switch ($type) {
            case "USER":
                $conn = new UserController($_SERVER["REQUEST_METHOD"]);
                break;
        }
    }
} catch (\Throwable $e) {
    echo "<h1>Ops, ocorreu um erro inesperado durante a execução.</h1><br><p>O erro ocorreu na linha {$e->getLine()}, no local \"{$e->getFile()}\", no arquivo {$e->getTraceAsString()}.</p><br><p>Mensagem: <span style='color:red'>{$e->getMessage()}</span></p>";
    var_dump($conn);
}
