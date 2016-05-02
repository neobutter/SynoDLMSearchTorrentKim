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
		return $plugin->addRSSResults($response);
	}
}
?>
