<?php
class social_counter
{
    function get_count($social_media, $data='')
	{
		switch($social_media)
		{
	        case 'facebook':
	       
				$page_url = $data['page_url'];
				$fql  = "SELECT share_count, like_count, comment_count";
				$fql .= " FROM link_stat WHERE url = '$page_url'";

				$fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);

				$response = file_get_contents($fqlURL);
				$response = json_decode($response);

				return $response; 
	                   
	        break;
	        case 'twitter': 

		        $twitter = file_get_contents('https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names='.$data['username']);
			    $twitter_count = json_decode($twitter);
			    return $twitter_count[0]->followers_count;

	        break;
	    	case 'googlePlus':

		        $user= $data['user'];
		        $apikey = $data['api_key'];

		        $google = file_get_contents( 'https://www.googleapis.com/plus/v1/people/' . $user . '?key=' . $apikey );

		        return  json_decode( $google )->circledByCount;
	            
	        break;
	        case 'instagram':

	            $instagram_url = $data['instagram_url'];
	            $username = substr($instagram_url, strrpos($instagram_url, '/') + 1);
	            $access_token = $data['access_token'];
	            $user_detail = 'https://api.instagram.com/v1/users/search?q='.$username.'&count=1&access_token=' . $access_token;
	            $data = (array)json_decode(file_get_contents( $user_detail)); 
	            //$data will return user details

	            $user_id = $data['data'][0]->id;
	            $api_url = 'https://api.instagram.com/v1/users/' . $user_id . '?access_token=' . $access_token;
	            $instagram_count = file_get_contents( $api_url);
	            $instagram_count_data =  (array)json_decode( $instagram_count );
	            $data =  (array)$instagram_count_data['data'];
	            $data_count =  (array)$data['counts'];

	            return $data_count['followed_by'];
	            
	        break;
	        case 'youtube':

	            $api_key = $data['api_key'];
	            $youtube_video_link = $data['youtube_video_link'];

	            if (strpos($youtube_video_link,'v=') !== false) { //if the links is single video link
	                $video_id = $username = substr($youtube_video_link, strrpos($youtube_video_link, '/') + 1);
	                $youtube_view_count = (array)json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$video_id.'&key='.$api_key));
	                return $youtube_view_count['items'][0]->statistics; 
	                
	            }
	            else //if the link is youtube channel link
	            {
	                $channel_id = substr($data['youtube_video_link'], strrpos($data['youtube_video_link'], '/') + 1);
	                $api_url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_id.'&key='.$api_key;
	                $youtube_count = file_get_contents( $api_url);
	                $youtube_count_data =  (array)json_decode( $youtube_count );
	                $data =  (array)$youtube_count_data['items'];
	                $data_count =  (array)$data[0];
	                $data_statistisc =  (array)$data_count['statistics'];

	                return $data_statistisc;
	            }                   

	        break;
	        case 'soundcloud':

	            $username = $data['username'];
	            $client_id = $data['client_id'];
				
				$api_url = 'https://api.soundcloud.com/users/' . $username . '.json?client_id=' . $client_id;
	            
	            $soundcloud = file_get_contents( $api_url);
	            $soundcloud_data =  (array)json_decode( $soundcloud );
	            $soundcloud_followers = $soundcloud_data['followers_count'];

	            $userid = $soundcloud_data['id'];                  
	            $soundcloud_url = "http://api.soundcloud.com/users/{$userid}/tracks.json?client_id={$client_id}";
	             
	            $tracks_json = file_get_contents($soundcloud_url);
	            $tracks = json_decode($tracks_json);
	            //$tracks will return all track details 

	            $total_playback_count = 0;                     
	            foreach ($tracks as $track) 
	            {
	                 $total_playback_count = $track->playback_count + $total_playback_count;
	            }

	            $soundcloud_info = array(
	                'followers_count'=> $soundcloud_followers,
	                'playback_sum_count' => $total_playback_count
	                );

	            return $soundcloud_info;

	        break;
	        case 'dribbble':

	            $dribbble_username = $data['dribbble_username'];
	            $social_profile_url = 'http://dribbble.com/';

	            $api_url = 'http://api.dribbble.com/' . $dribbble_username;
	            $dribbble = file_get_contents( $api_url);
	            $dribbble_data =  (array)json_decode( $dribbble );
	            
	            return $dribbble_data['followers_count'];
	            
	        default:
	        break;
		}
	}

}

///////////////////////////////////////
////Created by Sujan Shrestha//////////
////////Copyright ©2015////////////////
///////////////////////////////////////
