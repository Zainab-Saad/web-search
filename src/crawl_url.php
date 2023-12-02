<?php
require_once __DIR__."\logger.php";
function crawl_url($url, $depth = 2): void
{
	static $queue = array();

	if (isset($queue[$url])) {
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

			$anchors = $dom->getElementsByTagName("a");

			foreach ($anchors as $anchor) {
					$href = $anchor->getAttribute("href");
					if (str_starts_with($href, "#") || str_starts_with($href, "/")) {
							$href = $url . $href;
					}
					crawl_url($href, $depth - 1);
			}
	} else {
			err_log("Invalid URL - Tried Crawling: " . $url . " (Depth: " . $depth . ")");
	}

	return;
}
