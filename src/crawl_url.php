<?php
function crawl_url(Database $database, $url, $depth = 2): void
{
	static $queue = array();

	if (isset($queue[$url]) || $database->url_crawled($url)) {
		warning_log("URL already crawled - URL: " . $url . " (Depth: " . $depth . ")");
		return;
	}

	if ($depth === 0) {
		warning_log("Max depth - URL: " . $url . " (Depth: " . $depth . ")");
		return;
	}

	$queue[$url] = true;

	info_log("Crawling: " . $url . " (Depth: " . $depth . ")");

	// request the resource on the url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$result = curl_exec($ch);
	curl_close($ch);

	// parse the html response
	if (!empty($result)) {
		$dom = new DOMDocument("1.0");
		@$dom->loadHTML($result);
		// uncomment below two lines for debugging
		// $html = $dom->saveHTML();
		// echo "\nThe content is ".$html;

		// get the actual text content
		// Create a DOMXPath object for querying
    $xpath = new DOMXPath($dom);

    // Query all text nodes in the document
    $nodes = $xpath->query('//text()');

    // Initialize a variable to store the extracted text
    $text = '';

    // Loop through each text node and concatenate the text
    foreach ($nodes as $node) {
			// Ignore script and style nodes
			if ($node->parentNode && ($node->parentNode->nodeName == 'script' || $node->parentNode->nodeName == 'style')) {
				continue;
			}
	
			$text .= $node->nodeValue . ' ';
	}
		
		// Trim leading and trailing whitespaces
		$content = trim($text);
		
		// Convert content to UTF-8
		$content = iconv("UTF-8", "UTF-8//IGNORE", $content);

		// save the content in database
		$database->insert_row($url, $content);

		$anchors = $dom->getElementsByTagName("a");

		foreach ($anchors as $anchor) {
				$href = $anchor->getAttribute("href");
				if (str_starts_with($href, "#") || str_starts_with($href, "/")) {
						$href = $url . $href;
				}
				crawl_url($database, $href, $depth - 1);
		}
	} else {
		err_log("Invalid URL - Tried Crawling: " . $url . " (Depth: " . $depth . ")");
	}
}
