<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Web Search</title>
  <link rel="stylesheet" href="./public/css/main.css">
</head>
<body>
  <h2>Web Search</h2>
  <form action="#" method="POST">
    <label for="url">Enter a seed url</label>
    <input type="text" placeholder="URL e.g; www.google.com" name="url" class="input-field">
    <button type="submit" class="btn">Enter</button>
  </form>
</body>
<?php
  require_once __DIR__."\src\logger.php";
  require_once __DIR__."\src\web_search.php";
  if (isset($_POST["url"])) {
    web_search($_POST["url"]);
  }
?>
</html>