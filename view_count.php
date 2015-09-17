<?php

	$facebook_url = 'YOUR_FACEBOOK_PAGE_LINK';
	$twitter_url = 'YOUR_TWITTER_PROFILE_LINK' ;
	$instagram_url = 'YOUR_INSTAGRAM_PROFILE_LINK' ;
	$youtube_url = 'YOUTUBE_LINK';
	$sound_cloud_url = 'YOUR_SOUNDCLOUD_PROFILE_LINK' ;

	require 'social_counter.php';

	$count = new social_counter();

	//count for facebook page start
    $facebook_details = $count->get_count('facebook', array('page_url'=>$facebook_url));

    $facebook_share_count = $facebook_details[0]->share_count;
    $facebook_like_count = $facebook_details[0]->like_count;
    $facebook_comment_count = $facebook_details[0]->comment_count;
	//count for facebook page end


	//count for twitter page start
    $twitter_username = substr($twitter_url, strrpos($twitter_url, '/') + 1);
    $twitter_follower_count = $count->get_count('twitter' , array('username' => $twitter_username));

	//count for twitter page end

	//count for google plus page start 
    $user = 'YOUR_GOOGLE_USERNAME'; //eg +BBCNews
    $apikey = 'YOUR_GOOGLE_API_KEY';

    $googleplus_circle = $count->get_count('googlePlus' , array('user' => $user , 'api_key' => $apikey));
	//count for google plus page end

	//count for Instagram followed by start
     $access_token = 'YOUR_INSTAGRAM_ACCESS_TOKEN';
     $instagram_follower = $count->get_count('instagram' , array('instagram_url'=>$instagram_url, 'access_token' => $access_token));

	//count for Instagram followed by end

	//count for youtube subscribers start
    $api_key = 'YOUR_YOUTUBE_API_KEY';
    $youtube_stat = (array)$count->get_count('youtube' ,array('api_key' => $api_key , 'youtube_video_link' => $youtube_url));

     if (strpos($youtube_url,'v=') !== false) {
        $youtubeviewCount = $youtube_stat['viewCount'];
        $likeCount = $youtube_stat['likeCount'];
        $dislikeCount = $youtube_stat['dislikeCount'];
        $favoriteCount = $youtube_stat['favoriteCount'];
        $youtube_stat = $youtube_stat['commentCount'];
    }
    else
    {
        $youtubeviewCount = $youtube_stat['viewCount'];
        $commentCount = $youtube_stat['commentCount'];
        $youtubesubscriberCount = $youtube_stat['subscriberCount'];
    }
    //count for youtube subscribers end

    //count for soundcloud subscribers start
    $soundcloud_username = substr($sound_cloud_url, strrpos($sound_cloud_url, '/') + 1);
    $client_id = 'YOUR_SOUNDCLOUD_CLIENT_ID';

    $soundcloud_details = $count->get_count('soundcloud', array('username' => $soundcloud_username , 'client_id' => $client_id));
    $soundcloud_total_followers = $soundcloud_details['followers_count'];
	$total_playback_count = $soundcloud_details['playback_sum_count'];
	//count for soundcloud subscribers end
	
	
//count for dribbble followers start
    $dribbble_username = 'YOUR_DRIBBLE_CLIENT_ID';
    $count->get_count('dribbble', array('dribbble_username' => $dribbble_username ));
//count for dribbble followers end

