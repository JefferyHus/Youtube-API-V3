<?php
	require 'functions.php';
	if(isset($_GET['query'])){
		$query = $_GET['query'];
		$cc_key = 'AIzaSyAhvh9sWdjNDjsSbBuOi4eZy80RLjNNlaA';
		$url = 'https://www.googleapis.com/youtube/v3/search?part=id&q='.$query.'&maxResults=50&key='.$cc_key;
		$filer = json_decode(file_get_contents($url),true);

		/**
		 * 	@param VideoId
		 * 	@type array
		 *	@desc this array will contain the IDs returned from the first call
		 */
		$VideoId = [];
		/**
		 *	@param data
		 *	@type array
		 *	@desc this array will be used to store details of each video
		 */
		$data = [];
		/**
		 *	@param IDurl
		 *	@type string
		 *	@desc this variable will contain a string of the IDs got from the endpoint
		 */
		$IDurl='';

		//Store IDs to VideoId
		foreach ($filer['items'] as $entry) {
			if (isset($entry['id']['videoId'])) {
				$VideoId [] = $entry['id']['videoId'];
			}
		}
		//Create the IDs string
		foreach ($VideoId as $key => $value) {
			$IDurl .= $value.',';
		}
		//Trim IDurl (',')
		$IDurl = rtrim($IDurl,',');

		//create the second Youtube endpoint URL
		$video_url = 'https://www.googleapis.com/youtube/v3/videos?part=snippet%2Cstatistics%2CcontentDetails&id='.$IDurl.'&key='.$cc_key;
		$video_filer = json_decode(file_get_contents($video_url),true);

		//Store each video details to data
		foreach ($video_filer['items'] as $video) {
			if (isset($video['id'])) {
				$date = new DateTime($video['snippet']['publishedAt']);
				$date->add(new DateInterval($video['contentDetails']['duration']));
				$time = $date->format('H:i:s');
				//convert the date
				$video_date = date_format($date , 'd/m/y');
				//create the video list details
				$data[] = array(
					"thumbnail" => $video['snippet']['thumbnails']['medium']['url'],
					"title" => htmlspecialchars($video['snippet']['title'], ENT_QUOTES, 'UTF-8'),
					"title_short" => short_text_out(htmlspecialchars($video['snippet']['title'], ENT_QUOTES, 'UTF-8'), 4),
					"username" => $video['snippet']['channelTitle'],
					"profile" => "https://www.youtube.com/channel/".$video['snippet']['channelId'],
					"views" => (isset($video['statistics']['viewCount']))?$video['statistics']['viewCount']:'',
					"date" => $video_date,
					"time" => $time,
					"more" =>  'https://www.youtube.com/watch?v='.$video['id'],
					"embed_url" => 'http://www.youtube.com/embed/'.$video['id'].'?autoplay=1'
				);
			}
		}

		//echo out the results in json
		echo "<pre>";
		echo json_encode($data);
	}
?>
