<?php

function dbPass(string $table, string  $dbName): array
{
    $arr = ['user' => 'root', 'password' => '', 'dbName' => $dbName, 'table' => $table, 'host' => 'localhost'];
    return $arr;
}

// function key(): string
// {
//     return "0O02982IGTK3QWASMCHO";
// }