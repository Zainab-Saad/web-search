<?php
  require_once dirname(__DIR__)."\src\logger.php";

  class Database {
    private $pdo;

    public function __construct($host, $port, $user, $db, $password) {
      $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
      $this->pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
    public function create_table() {
      $sql =  "CREATE TABLE IF NOT EXISTS crawl_result (".
              "url TEXT PRIMARY KEY,".
              "title TEXT,".
              "content TEXT,".
              "search_content tsvector GENERATED ALWAYS AS (to_tsvector('english', content)) STORED,".
              "updated_on TIMESTAMP".
              ");".
              "CREATE INDEX IF NOT EXISTS search_content_idx ON crawl_result USING GIN (search_content);";
      $this->pdo->exec($sql);
    }

    public function insert_row($url, $content, $title) {
      $sql = "INSERT INTO crawl_result (url, title, content, updated_on) VALUES ".
            "(:url, :title, :content, :updated_on)";

      $stmt = $this->pdo->prepare($sql);

      $updated_on = date('Y-m-d H:i:s');

      $stmt->bindValue(':url', $url);
      $stmt->bindValue(':title', $title);
      $stmt->bindValue(':content', $content);
      $stmt->bindValue(':updated_on', $updated_on);

      $stmt->execute();
    }

    public function close_connection() {
      $this->pdo = null;
    }

    public function url_crawled($url) {
      $sql = "SELECT url FROM crawl_result WHERE url =  ".
              "'".$url."'";

      $stmt = $this->pdo->query($sql);

      $results = [];
      while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
          $results[] = [
              'url' => $row['url'],
          ];
      }
      return count($results);
    }

    public function search_content($search_string) {
      $sql = "SELECT url, title, content FROM crawl_result ".
              "WHERE search_content @@ to_tsquery('english', '".$search_string."')";
      
      $stmt = $this->pdo->query($sql);

      $results = [];

      while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $results[] = [
          'url' => $row['url'],
          'title' => $row['title'],
          'content' => $row['content']
        ];
      }

      return $results;
    }
  }
?>