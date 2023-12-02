<?php
  require_once dirname(__DIR__) . '\config\db_config.php';

  require_once dirname(__DIR__)."\src\logger.php";

  try {
    $dsn = "pgsql:host=$host;port=5432;dbname=$db;";
    // make a database connection
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($pdo) {
      info_log( "Connected to the".$db." database successfully!");
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  } finally {
    if ($pdo) {
      $pdo = null;
    }
  }
?>