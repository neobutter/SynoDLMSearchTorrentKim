<?php
class SynoDLMSearchTorrentKim {
	private $qurl = "https://torrentkim3.net/bbs/rss.php?k=";

	public function __construct() {
	}

	public function prepare($curl, $query) {
		$url = $this->qurl . urlencode($query);
		curl_setopt($curl, CURLOPT_URL, $url);
		// curl_setopt($curl, CURLOPT_REFERER, $url);
		// curl_setopt($curl, CURLOPT_RETURNTRANSFER , TRUE);
		// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
	}

	public function parse($plugin, $response) {
		$response = preg_replace("/<pubDate>/i", "<pubDate>" . date("r"), $response);
		$response = preg_replace("/<\/pubDate>/i", "</pubDate><category>All</category>", $response);
		$response = preg_replace("/\&/i", "&amp;", $response);
		$response = preg_replace("/<description><\/description>/i", "<description><![CDATA[Category: All<br />Subcategory: All<br />Size: 100&nbsp;kilobyte<br />Language: Unknown<br />Uploaded by: Unknown]]></description>", $response);
		$response = preg_replace("/<enclosure[^>]*url=[\"']?([^>\"']+)[\"']?[^>]*>/i", "<enclosure url=\"" . "http://www.mininova.org/get/13265623" . "\" length=\"0\" type=\"application/x-bittorrent\" />", $response);
		// $response = rawurldecode($response);
		return $plugin->addRSSResults($response);
	}
}
?>
