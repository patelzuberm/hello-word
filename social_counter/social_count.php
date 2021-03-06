<?php
/**
 * Social count - Social Network Followers Counter
 *
 * @package    social count
 * @author     Amine Kacem <amine@webcodo.net>
 * @copyright  Copyright (c) 2013 - present Stephan Schmitz
 * @license    MIT License
 * @updated    2013/08/25
 */



$youtube_channel = '1i13y4RIfDU';
/*$facebook_page = '';
$dribbble_username = '';
$vimeo_username = '';

/* Twitter */
// to create a new app go to this link https://dev.twitter.com/apps/new
/*$twitter_username = '';
$oauth_access_token = "";
$oauth_access_token_secret = "";
$consumer_key = "";
$consumer_secret = "";

//instagram
$instagram_userID = '';
$instagram_accessToken = '';
*/
// Google plus
// To create a new app : https://code.google.com/apis/console/
$gplus_pageID = '105336093288440092989'; //105286435552581273822 This is must be a PAGE ID not a profile
$gplus_api_key = 'AIzaSyDksehOi4G_812ZPNYgqd2YNP53uLVEbg0';

// SoundCloud
// To create a new app : http://soundcloud.com/you/apps/new
/*$soundcloud_username = '';
$soundcloud_clientID = '';

*/
$cache = "cache/count.wcd";
$expire = 900; // valable 15 minutes


/*********************************************** */


//create the cache file if dont exist
if(!file_exists($cache) or (filemtime($cache) > $expire)){
	file_put_contents($cache, '{}');
}
	function update_cache($cache_url, $cache_data){
		//update the cache file
		$fh = fopen($cache_url, 'w')or die("Error opening output file");
		fwrite($fh, json_encode($cache_data,JSON_UNESCAPED_UNICODE));
		fclose($fh);
	}
	
	function nbr_format($nbr){
		if(is_numeric($nbr)){
			return number_format($nbr);
		}else{ return null;}
	}


	function gplus_cercles($gplus_id, $gplus_key, $cache, $expire){
		if(strlen($gplus_id) > 1){
			$gplusLink = 'https://www.googleapis.com/plus/v1/people/'.$gplus_id.'?key='.$gplus_key;
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire) or (!isset($cache_data->gplus))){
				$gplus_followers = $cache_data->gplus = FetchData($gplusLink)->circledByCount;
				update_cache($cache, $cache_data);
			}else{
				$gplus_followers = $cache_data->gplus;
			}
			return nbr_format($gplus_followers);
		}else{ return null;}
	}
	
	function gplus_cerclesprfl($gplus_id, $gplus_key, $cache, $expire){
		if(strlen($gplus_id) > 1){
			$gplusLink = 'https://www.googleapis.com/plus/v1/people/'.$gplus_id.'?key='.$gplus_key;
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			if((filemtime($cache) < $expire) or (!isset($cache_data->gplus))){
				$gplus_followers = $cache_data->gplus = FetchData($gplusLink)->image->url;
				update_cache($cache, $cache_data);
			}else{
				$gplus_followers = $cache_data->gplus;
			}
			return $gplus_followers;
		}else{ return null;}
	}

	function youtube_subscribers($yt_channel, $cache, $expire){
			$expire = time()-$expire;
			$cache_data = FetchData($cache);
			$ytUrl = 'http://gdata.youtube.com/feeds/api/users/'.$yt_channel.'?alt=json';
			if((filemtime($cache) < $expire) or (!isset($cache_data->youtube))){
				$yt_subscribers =$cache_data->youtube = FetchData($ytUrl)->entry->{'yt$statistics'}->subscriberCount;
				update_cache($cache, $cache_data);
			}else{
				$yt_subscribers = $cache_data->youtube;
			}
			return nbr_format($yt_subscribers);
	}



	function FetchData($json_url='',$use_curl=false){
	    if($use_curl){
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_URL, $json_url);
	        $json_data = curl_exec($ch);
	        curl_close($ch);
	        return json_decode($json_data);
	    }else{
	        $json_data = @file_get_contents($json_url);
	        if($json_data == true){
	        	return json_decode($json_data);
	    	}else{ return null;}
	    }
	}

	extract($_POST);
	switch ($act) {
		case 'wcd_youtube'		:	echo youtube_subscribers($youtube_channel, $cache, $expire);	break;
		case 'wcd_gplus'		: 	echo gplus_cercles($gplus_pageID, $gplus_api_key, $cache, $expire);	break;
		case 'wcd_gplusprfl'	: 	echo gplus_cerclesprfl($gplus_pageID, $gplus_api_key, $cache, $expire);	break;
		
		
		default: echo '...'; break;
	}





?>