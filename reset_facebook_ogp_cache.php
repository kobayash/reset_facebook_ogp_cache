<?php
/*
Plugin Name: ResetFacebookOGPCache
Plugin URI: https://github.com/kobayash/reset_facebook_ogp_cache
Description: This is WordPress Plugin. When a post was published, request for facebook to scraping again.
Version: 0.1
Author: Kobayashi
Author URI: https://github.com/kobayash
License: Public Domain
*/
// Use Post Status Transitions Hook.
// http://codex.wordpress.org/Post_Status_Transitions
add_action('new_to_publish',        'reset_facebook_ogp_cache');
add_action('pending_to_publish',    'reset_facebook_ogp_cache');
add_action('draft_to_publish',      'reset_facebook_ogp_cache');
add_action('auto-draft_to_publish', 'reset_facebook_ogp_cache');
add_action('future_to_publish',     'reset_facebook_ogp_cache');
add_action('private_to_publish',    'reset_facebook_ogp_cache');

/**
 * Request for facebook to scrape the URL.
 * https://developers.facebook.com/docs/payments/product/
 *
 * @param $new_status
 * @param $old_status
 * @param $post
 */
function reset_facebook_ogp_cache($new_status, $old_status, $post){
	$end_point = 'https://graph.facebook.com/?id=%s&scrape=true&method=post';
	$url = get_permalink($post->ID);
	$url = sprintf($end_point, rawurlencode($url));
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);
	curl_close($ch);
}