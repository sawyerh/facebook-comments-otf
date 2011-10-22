<?php
/*
Plugin Name: Facebook Comments (OTF)
Plugin URI: http://wordpress.org/extend/plugins/social-bartender
Description: Place a Facebook comment form on your site and access the comment count. 
Version: 1.0.0
Author: Sawyer Hollenshead (Shaken &amp; Stirred Web)
Author URI: http://shakenandstirredweb.com
License: GPLv2

Copyright 2011 Sawyer Hollenshead (hello@shakenandstirredweb.com)

This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; either version 2 of the License, or (at 
your option) any later version.This program is distributed in the hope 
that it will be useful, but WITHOUT ANY WARRANTY; without even the 
implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA

*/

define( 'SH_FBC_DIR', plugin_dir_url(__FILE__) );

add_action('init',  'sh_fbc_init');

function sh_fbc_init(){

	load_plugin_textdomain( 'shaken', FALSE, SH_FBC_DIR.'languages' );
		 	
}

// This plugin requires jQuery in order for it to function
add_action( 'wp_print_scripts', 'sh_fbc_theme_scripts' );
function sh_fbc_theme_scripts(){
	if ( is_admin() ) return;
	
	wp_enqueue_script( 'jquery' );
}

// AJAX processing
add_action('wp_ajax_sh_fbc_ajax', 'sh_fbc_process_ajax');
add_action('wp_ajax_nopriv_sh_fbc_ajax', 'sh_fbc_process_ajax');

// Add the Settings page
add_action( 'admin_menu', 'sh_fbc_add_page' );
function sh_fbc_add_page(){
	add_options_page( 'Facebook Comments (OTF)', 'Facebook Comments', 'manage_options', 'sh_fbc_settings', 'sh_fbc_settings' );
}

/**
 * social_bartender
 *
 * Outputs the links with an image or title inside 
 *
 * @param string		$link_before 	Sets the text or html that precedes the <a> tag.
 * @param string		$link_after 	Sets the text or html that follows the <a> tag.
 * @param string		$echo 			Echo the content if true (1) or return if false (0)
 *
 * @return string
*/
function fbc_comment_form($num_comments = 10, $width = 0, $app_id = '', $color = 'light', $id = false, $notify_email = false){
	
	// Who should be notified of new comments?
	if( $notify_email ){
		$author = $notify_email;
	} else {
		global $authordata;
		$author = get_the_author_meta('user_email', $authordata->ID);
	}
	
	if( !$id ){
		global $post;
		$id = $post->ID;
	}
	
	// How wide should the form be?
	global $content_width;
	
	if( $width != 0 ){
		$form_width = $width;
	} elseif ( isset( $content_width ) ){
		$form_width = $content_width;
	} else {
		$form_width = 500;
	}

	$ajax_file = admin_url('admin-ajax.php');
	$ajax_nonce = wp_create_nonce( 'hollenshead-sawyer' );
	
	echo '<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) {return;}
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));</script>
	
	<script>
	    window.fbAsyncInit = function() {
	        FB.init({
	            appId:  \''.$app_id.'\',
	            status: true,
	            cookie: true,
	            xfbml:  true
	        });
			
			// Send e-mail notification
	        FB.Event.subscribe(\'comment.create\', function(response) {
	            
	            jQuery.post(\''.$ajax_file.'\', { 
		            action: \'sh_fbc_ajax\',
		            security: \''.$ajax_nonce.'\',
		            cID: response.commentID, 
		            doWhat: \'create\',
		            author: \''.$author.'\',
		            postID: \''.$id.'\' 
	            }, function(resp) {
					if (resp === \'true\') {
						//console.log(\'fbComments: Sent email notification\');
					}
				});
	            
	        });
	        
	         FB.Event.subscribe(\'comment.remove\', function(response) {
	         	jQuery.post(\''.$ajax_file.'\', {
	         		action: \'sh_fbc_ajax\',
	         		security: \''.$ajax_nonce.'\',
	            	cID: response.commentID,
	            	postID: \''.$id.'\',
	            	doWhat: \'remove\'
	            }, function(resp) {
					if (resp === \'true\') {
						//console.log(\'fbComments: Remove and reduce\');
					} else {
						//console.log(\'fbComments: Remove fail\');
					}
				});
	         });  
	
	    };
	    (function() {
	        var e = document.createElement(\'script\'); e.async = true;
	        e.src = document.location.protocol + \'//connect.facebook.net/en_US/all.js\';
	        document.getElementById(\'fb-root\').appendChild(e);
	    }());
	</script>
	
	<div class="fb-comments" notify="true" data-href="'.get_permalink( $id ).'" data-num-posts="'.$num_comments.'" data-width="'.$form_width.'" data-colorscheme="'.$color.'"></div>';
}

// Returns comment count structured for multiple scenarios (0, 1, and multiple comments)
function fbc_comment_count($id, $zero = '0 comments', $single = ' comment', $plural = ' comments'){
	$count = fbc_get_comment_count($id);
	
	if( $count ){
		if( $count == '1' ){
			echo $count.$single;
		} elseif( $count == '0'){
			echo $zero;
		} else{
			echo $count.$plural;
		}
	} else {
		echo $zero;
	}
	
}

// Return comment count number only
function fbc_get_comment_count($id){
	$count = get_post_meta( $id, 'fb_comment_count', true );	
	
	if( $count ){
		return $count;
	} elseif( _fbc_get_external_count($id) ){		
		// A comment count from Facebook is available
		$new_count = _fbc_get_external_count($id);
		update_post_meta( $id, 'fb_comment_count', $new_count );
		return _fbc_get_external_count($id);
	} else {
		// There are zero comments
		update_post_meta( $id, 'fb_comment_count', '0' );
		return '0';
	}
}

function _fbc_get_external_count($id){
	
	$request_url ="https://graph.facebook.com/?ids=" . get_permalink($id);
    $requests = file_get_contents($request_url);
    $requests = json_decode($requests);
 	$p_fb = get_permalink($id);
 	
 	if( $requests->$p_fb->comments ){
 		$comment_count = $requests->$p_fb->comments;
 		return $comment_count;
	} else {
		return false;
	}
	
}

require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/facebook-comments-ajax.php");
require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/settings.php");

?>