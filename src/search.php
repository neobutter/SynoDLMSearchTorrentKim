<?php
class SynoDLMSearchTorrentKim {
	private $qurl = "https://torrentkim3.net/bbs/rss.php?k=";

	public function __construct() {
	}

	public function prepare($curl, $query) {
		$url = $this->qurl . urlencode($query);
		curl_setopt($curl, CURLOPT_URL, $url);
	}

	public function parse($plugin, $response) {
		$response = preg_replace("/<pubDate>/i", "<pubDate>" . date("r"), $response);
		$response = preg_replace("/<\/pubDate>/i", "</pubDate><category>All</category>", $response);
		$response = preg_replace("/<description><\/description>/i", "<description><![CDATA[Category: All<br />Subcategory: All]]></description>", $response);
		$response = preg_replace("/\&dn=.*?(?=&tr)/i", "", $response);
		$response = preg_replace("/&/i", "%26", $response);
		return $plugin->addRSSResults($response);
	}
}
?>
