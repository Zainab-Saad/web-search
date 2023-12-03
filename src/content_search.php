<style>
  <?php include dirname(__DIR__)."\public\css\main.css"; ?>
</style>
<button class="btn-square">
  <a href="..\index.php">Go To Web Crawler</a>
</button>
<h2>Search Engine</h2>
<form action="#" method="GET">
  <label for="search_string" class="form-label">Enter a search pattern</label>
  <input type="text" placeholder="Search...." name="search_string" class="input-field">
  <button type="submit" class="btn">Start Searching</button>
</form>
<?php
  require_once dirname(__DIR__)."\database\Database.php";
  require_once dirname(__DIR__) . '\config\db_config.php';

  
  if (isset($_GET["search_string"]) && strlen($_GET["search_string"])) {
    $database = new Database($host, 5433, $user, $db, $password);
    $search_str_array = explode(" ", $_GET["search_string"]);
    $search_str = "";
    foreach ($search_str_array as $search_elem) {
      $search_str = $search_str.$search_elem." & ";
    }
    $search_str = substr($search_str, 0, strlen($search_str) - 2 );

    $search_results = $database->search_content($search_str);
  
    foreach ($search_results as $search_result) {
      echo "<h3><a href='".$search_result["url"]."'>".$search_result["title"]."</a></h3>";
      echo "<p>".substr($search_result["content"], 0, 300)."</p>";
    }
  }
?>