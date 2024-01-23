<?php

$host = 'localhost';
//$user = 'root';
//$pass = 'root1234';
//$db_name = 'githubblog';
$user = 'ufumrsvjfkmx7';
$pass = 'ufumrsvjfkmx77';
$db_name = 'dbg2tirzvfuazt';

$conn = new MySQLi($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}