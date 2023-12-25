<?php

use API\Controllers\UserController;

require_once './vendor/autoload.php';


$conn = null;
try {
    // var_dump($_SERVER);
    $conn = new UserController("flavio@hotmail.com", "123456789", $_SERVER["REQUEST_METHOD"]);

} catch (\Throwable $e) {
    echo "<h1>Ops, ocorreu um erro inesperado durante a execução.</h1><br><p>O erro ocorreu na linha {$e->getLine()}, no local \"{$e->getFile()}\", no arquivo {$e->getTraceAsString()}.</p><br><p>Mensagem: <span style='color:red'>{$e->getMessage()}</span></p>";
    var_dump($conn);
}
