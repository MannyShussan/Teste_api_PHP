<?php

use API\Controllers\UserController;

require_once './vendor/autoload.php';


$conn = null;
try {
    switch ($_GET) {
        case isset($_GET['API/user']):
            $conn = new UserController($_SERVER["REQUEST_METHOD"]);
            break;

        // case isset($_GET['API/devices']):
            
        //     break;

        default:
            echo "Não implementado ainda";
    }
} catch (\Throwable $e) {
    echo "<h1>Ops, ocorreu um erro inesperado durante a execução.</h1><br><p>O erro ocorreu na linha {$e->getLine()}, no local \"{$e->getFile()}\", no arquivo {$e->getTraceAsString()}.</p><br><p>Mensagem: <span style='color:red'>{$e->getMessage()}</span></p>";
    var_dump($conn);
}
