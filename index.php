<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Web Search</title>
</head>
<style>
  <?php include __DIR__."\public\css\main.css"; ?>
</style>
<body>
  <button class="btn-square">
    <a href=".\src\content_search.php">Go To Search Engine</a>
  </button>
  <h2>Web Crawler</h2>
  <form action="#" method="POST">
    <label for="url" class="form-label">Enter a seed url</label>
    <input type="text" placeholder="URL e.g; www.google.com" name="url" class="input-field" value="<?php echo isset($_POST["url"]) ? $_POST["url"]: "" ?>">
    <button type="submit" class="btn">Start Crawling</button>
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