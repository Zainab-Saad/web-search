<?php
  require  dirname(__DIR__).'\vendor\autoload.php';
  use Monolog\Logger;
  use Monolog\Handler\StreamHandler;
  
  function err_log($msg) {
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(dirname(__DIR__).'\app.log', Logger::ERROR));
    $log->error($msg);
  }

  function info_log($msg) {
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(dirname(__DIR__).'\app.log', Logger::INFO));
    $log->info($msg);
  }

  function warning_log($msg) {
    $log = new Logger('name');
    $log->pushHandler(new StreamHandler(dirname(__DIR__).'\app.log', Logger::WARNING));
    $log->warning($msg);
  }
?>