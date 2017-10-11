<?php 
session_start();
require("engine/functions.php");

	$direction = $_POST['direction'];
	$pageValue = $_POST['pageValue'];
	$feedType = $_POST['feedType'];
	$query = "";
	$counter = "";
	$title = "";
	$tags = "";
	if ($direction=="" && $feedType=="feed") 
	{
		$pageValue =  $pageValue+8;
		$query = "SELECT * FROM images ORDER BY id DESC LIMIT 10";
		$counter = "0";
		getFeedData($query,$counter);
	}	
	if ($direction=="up" && $feedType=="feed") 
	{
		$pageValue =  $pageValue+8;
		$query = "select * from images limit ".$pageValue.", 1";
		$counter = "0";
		getFeedData($query,$counter);
	}
	else if ($direction=="down"  && $feedType=="feed") 
	{
		$pageValue =  $pageValue-1;
		$query = "select * from images limit ".$pageValue.", 1";
		$counter = "9";
		getFeedData($query,$counter);
	}
	else if($direction==""  && $feedType=="insta")
	{
		$limit = 10;
		getInstaData($limit);
	}
	else if($direction=="up"  && $feedType=="insta")
	{

	}
	else if($direction=="down"  && $feedType=="insta")
	{

	}
	function getFeedData($query,$counter)
	{
		$db = new Connection();
		$conn = $db->dbConnect();
		$st = $conn->prepare($query);
		$st->execute();
		$count = 0;
		while ($img = $st->fetch()) 
		{
			$_SESSION['currentID'] = $imgID = $img['id'];
			$panel .= "<div id='img-".$img['id']."' class='panel pos".$count."'><div class='caption'><h2>".$title."</h2><h3>".$tags."</h3></div><a href='preview.php?img=".$img['name']."'><img src='upload/".$img['name']."' /></a></div>";
			$count++;
		}
		echo $panel;
	}
	function rudr_instagram_api_curl_connect( $api_url )
	{
		$connection_c = curl_init();
		curl_setopt( $connection_c, CURLOPT_URL, $api_url );
		curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
		$json_return = curl_exec( $connection_c );
		curl_close( $connection_c );
		return json_decode( $json_return );
	}
	function getInstaData()
	{
		$panel = "";
		$access_token = '13912890.3a81a9f.e3b482cc330b4aa5abd41bf48d9c7272';
		$username = 'honeybadgem';
		$user_id = 3967824490;
		$return = rudr_instagram_api_curl_connect("https://api.instagram.com/v1/users/" . $user_id . "/media/recent?access_token=" . $access_token."");
		$counter = 0;
		foreach ($return->data as $post) 
		{
			if($counter<=9)
			{
				$panel .= "<div id='img-".$post->id."' class='panel pos".$counter."'><div class='caption'><h2></h2><h3></h3></div><img src=".$post->images->standard_resolution->url." /></div>";
			}	
			else 
			{
				$panel .= "<div id='img-".$post->id."' class='panel pos".$counter." hide_image'><div class='caption'><h2></h2><h3></h3></div><img src=".$post->images->standard_resolution->url." /></div>";
			}				
			$counter++;
		}
		echo $panel;
	}	
?>