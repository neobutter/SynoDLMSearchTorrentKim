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
		$regexp = "<tr class=\"bg.*bo_table=torrent_(.*)&wr_id=(.*)\">.*<\/tr>";
		$res=0;
		if(preg_match_all("/$regexp/siU", $response, $matches, PREG_SET_ORDER)) {
			$title="Unknown title";
			$download="Unknown download";
			$size=0;
			$datetime="1900-12-31";
			$page="Default page";
			$hash="Hash unknown";
			$seeds=0;
			$leechs=0;
			$category="Unknown category";

			foreach($matches as $match) {
					$categoryv = $match[1];
					$id        = $match[2];
					$info      = $this->getInfo($categoryv, $id);
					$title     = $info['title'   ];
					$download  = $info['download'];
					$size      = $info['size'    ];
					$datetime  = $info['date'    ];
					$category  = $info['category'];
					$hash      = md5($res.$title);
					$seeds     = 0;
					$leechs    = 0;
					$page      = sprintf($this->purl, $categoryv, $id);
					$plugin->addResult($title, $download, $size, $datetime, $page, $hash, $seeds, $leechs, $category);
					$res++;
			}
		}
		return $res;
	}
}
?>
