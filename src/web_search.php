<?php
  require_once __DIR__ . '/crawl_url.php';

  function web_search($url) : void {
    try {
      set_time_limit(250);
      libxml_set_external_entity_loader(
        crawl_url($url, 100)
      );
    }
    catch (Exception $e) {
      err_log("Maximum execution time reached");
    }
  }
?>