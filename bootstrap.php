<?php
    require 'vendor/autoload.php';
    use Dotenv\Dotenv;

    $dontenv = Dotenv::createImmutable(__DIR__)->load();
    define("DBHOST", $_ENV['DBHOST']);
    define("DBNAME", $_ENV['DBNAME']);
    define("DBUSER", $_ENV['DBUSER']);
    define("DBPASS", $_ENV['DBPASS']);
    define("DBPORT", $_ENV['DBPORT']);

    