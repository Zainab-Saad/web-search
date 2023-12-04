<?php 

require_once __DIR__.'\logger.php';

function check_robot_compliance($url) {
    $position = strpos($url, ".com");
    $base_url = null;

    $robotsTxtUrl = null;
    if ($position !== false) {
        $base_url = substr($url, 0, $position+4);
        $robotsTxtUrl = $base_url."/robots.txt";
    } else {
        err_log("Robots Compliance Failed - Invalid URL given - ".$url);
        die( "<p>Invalid URL given - ".$url."</p>");
    }

    $robotsTxt = file_get_contents($robotsTxtUrl);

    $parsedRules = parse_robots_txt($robotsTxt);
    $t = is_url_allowed($base_url, $url, $parsedRules);
    echo $t;
    return is_url_allowed($base_url, $url, $parsedRules);
}

/**
 * parse the robots.txt file and read each line
 * to check if there is a disallow statement, add
 * the disallowed urls to a returned array
 */
function parse_robots_txt($robotsTxt) {
    $lines = explode("\n", $robotsTxt);
    $rules = [];

    foreach ($lines as $line) {
      $line = trim($line);

      // skip empty lines, comments
      if (empty($line) || $line[0] == '#') {
        continue;
      }

      list($directive, $value) = explode(':', $line, 2) + [NULL, NULL];
      $directive = strtolower(trim($directive));
      
      if ($directive === 'user-agent' || $directive === 'disallow') {
        $rules[$directive][] = trim($value);
      }
    }

    return $rules;
}

/**
 * check if url is disallowed by checking in the parsedRules
 * array which is simply an associative array holding all the disallowed urls
 */
function is_url_allowed($base_url, $url, $parsedRules) {
    $disallowedPaths = $parsedRules['disallow'] ?? [];

    foreach ($disallowedPaths as $disallowedPath) {
      if (strpos($url, $base_url.$disallowedPath) === 0) {
        return false;
      }
    }

    return true;
}
?>
