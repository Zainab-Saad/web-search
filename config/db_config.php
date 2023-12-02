<?php
  require  dirname(__DIR__).'\vendor\autoload.php';
  use Dotenv\Dotenv;

  $dotenv = Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->load();

  $host = $_ENV["HOST"];
  $db =  $_ENV["DATABASE"];
  $user =  $_ENV["USER"];
  $password =  $_ENV["PASSWORD"];
?>