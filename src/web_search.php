<?php
  require_once dirname(__DIR__).'\database\Database.php';
  require_once dirname(__DIR__) . '\config\db_config.php';
  require_once __DIR__ . '/crawl_url.php';

  function web_search($url) : void {
    global $host, $user, $db, $password;
    $database = new Database($host, 5433, $user, $db, $password);
    $database->create_table();
    set_time_limit(120);
    libxml_set_external_entity_loader(
      crawl_url($database, $url, 100)
    );
  }
?>