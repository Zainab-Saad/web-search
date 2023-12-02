<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Web Search</title>
</head>
<body>
<?php
  require_once __DIR__ . '/crawl_url.php';

  set_time_limit(250);
  libxml_set_external_entity_loader(
    crawl_url("https://en.wikipedia.org/wiki/South_Asia", 100)
  );

?>

</body>
</html>