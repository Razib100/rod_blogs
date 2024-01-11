<?php

$host = 'localhost';
$user = 'dorjieco_app';
$pass = 'NGm9p5fVHXQ5kxU';
$db_name = 'dorjieco_test_b';

$conn = new MySQLi($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die('Database connection error: ' . $conn->connect_error);
}