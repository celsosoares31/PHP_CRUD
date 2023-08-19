<?php
include_once('../vendor/autoload.php');

$dotEnv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotEnv->safeLoad();
$db_host = $_ENV['DB_HOST'];
$db_username = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASSWORD'];
$db_dbName = $_ENV['DB_NAME'];
