<?php
	function sh_fbc_process_ajax(){
		
		// Verify the nonce
		check_ajax_referer( 'hollenshead-sawyer', 'security' );
		
		$id = $_POST['postID'];
		
		// A comment was deleted, so update the comment count
		if( $_POST['doWhat'] == 'remove' ):
	
			if( get_post_meta( $id, 'fb_comment_count', true ) ){
				$old_count = get_post_meta( $id, 'fb_comment_count', true );
				$new_count = $old_count - 1;
			} else {
				$new_count = '0';
			}
			update_post_meta( $id, 'fb_comment_count', $new_count );
		
		// A comment was added, so update the comment count and notify the post author
		elseif( $_POST['doWhat'] == 'create' ):
			
			$post_title = get_the_title( $id );
			$post_url = get_permalink( $id );
			
			/* ******************************************************
							Update the comment count
			****************************************************** */
			
			if( get_post_meta( $id, 'fb_comment_count', true ) ){
				$old_count = get_post_meta( $id, 'fb_comment_count', true );
				$new_count = $old_count + 1;
			} else {
				$new_count = '1';
			}
			update_post_meta( $id, 'fb_comment_count', $new_count );
			
			
			/* ******************************************************
							Send notification to author
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
				echo "true";
			} else {
				echo "false";
			}
			
		endif;
	}
?>