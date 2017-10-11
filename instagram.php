<?php 
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

$access_token = '13912890.3a81a9f.e3b482cc330b4aa5abd41bf48d9c7272';
$username = 'honeybadgem';
//$user_search = rudr_instagram_api_curl_connect("https://api.instagram.com/v1/users/search?q=" . $username . "&access_token=" . $access_token);
// $user_search is an array of objects of all found users
// we need only the object of the most relevant user - $user_search->data[0]
// $user_search->data[0]->id - User ID
// $user_search->data[0]->first_name - User First name
// $user_search->data[0]->last_name - User Last name
// $user_search->data[0]->profile_picture - User Profile Picture URL
// $user_search->data[0]->username - Username

$user_id = 3967824490; // or use string 'self' to get your own media
$return = rudr_instagram_api_curl_connect("https://api.instagram.com/v1/users/" . $user_id . "/media/recent?access_token=" . $access_token."&count=5");
echo "<pre>";
print_r($return);
die(); 
//var_dump( $return ); // if you want to display everything the function returns
echo '<ul class="bxsliderins">';
foreach ($return->data as $post) 
{
	echo '<li><img class="fancybox" src="' . $post->images->standard_resolution->url . '"  /></li>';
	//echo '<a href="' . $post->images->standard_resolution->url . '" class="fancybox"><img src="' . $post->images->thumbnail->url . '" /></a>';
}
echo '</ul>';
//echo do_shortcode('[instagram-feed]');?>
     


 