<?php

function dbPass(string $table, string  $dbName): array
{
    $arr = ['user' => 'root', 'password' => '', 'dbName' => $dbName, 'table' => $table, 'host' => 'localhost'];
    return $arr;
}

function timeSession(): int
{
    return 60 * 10;
}

function secretKey(): string
{
    $str = "0O02982IGTK3QWASMCHO";
    return $str;
}
