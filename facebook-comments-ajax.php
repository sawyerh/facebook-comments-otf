<?php

// What actually processes the ajax request
function sh_fbc_process_ajax(){
	
	// Verify the nonce
	check_ajax_referer( 'hollenshead-sawyer', 'security' );
	
	$id = $_POST['postID'];
	$action = $_POST['doWhat'];
	
	// A comment was deleted, so update the comment count
	if( $action  == 'remove' ):
		
		/* We have to ask FB for the count, since it's too unpredictable 
		 * when a comment has replies. This should be fine, since the removal
		 * of a comment shouldn't be a rapid occurance.
		 */ 
		if( _fbc_get_external_count($id) ){
			$new_count = _fbc_get_external_count($id);
		} else {
			$new_count = '0';
		}
		update_post_meta( $id, 'fb_comment_count', $new_count );
	
	// A comment was added, so update the comment count and notify the post author
	elseif( $action == 'create' ):
		
		$post_title = get_the_title( $id );
		$post_url = get_permalink( $id );
		
		/*	Update the comment count
		****************************************************** */
		if( get_post_meta( $id, 'fb_comment_count', true ) ){
			$old_count = get_post_meta( $id, 'fb_comment_count', true );
			$new_count = $old_count + 1;
		} else {
			$new_count = '1';
		}
		update_post_meta( $id, 'fb_comment_count', $new_count );
		
		
		/*	Send notification to author
		****************************************************** */
		$to = $_POST['author'];
		
		$sitename = strtolower( $_SERVER['SERVER_NAME'] );
		if ( substr( $sitename, 0, 4 ) == 'www.' ) {
			$sitename = substr( $sitename, 4 );
		}
		
		$from = 'wordpress@' . $sitename;
		
		$subject = "[WordPress] New Facebook comment: \"{$post_title}\"";
		$message = "A new comment has been posted on the post, \"{$post_title}\"\n\n" .
				   "You can view all comments on this post here: {$post_url}#comments";
		
		// Wordwrap the message and strip slashes that may have wrapped quotes
		$message = stripslashes(wordwrap($message, 70));
		
		$headers = "From: WordPress <$from>\r\n" .
					   "Reply-To: $from\r\n" .
					   "X-Mailer: PHP" . phpversion();
		
		// Send the email notification
		if (wp_mail($to, $subject, $message, $headers)) {
			return true;
		} else {
			return false;
		}
		
	endif;
}

/* Doesn't work, since the response doesn't provide the correct comment ID...
 * Find number of replies a comment has
		function sh_fbc_get_comment_replies( $comment_id ){
		
			// Check if the comment has replies, and return the amount if there are
			
			$request_url = "https://graph.facebook.com/" . $comment_id;
		    $requests = file_get_contents($request_url);
		    $requests = json_decode($requests);
		 	
		 	if( $requests->comments->count ){
		 		//return $requests->comments->count;
		 		echo $requests->comments->count;
			} else {
				echo 'no request';
			}
			
			// If there weren't any replies, we return 0
			return '50';
		} 
*/
?>