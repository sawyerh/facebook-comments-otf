<?php function sh_fbc_help_page($contextual_help, $screen_id, $screen) {
		//options page object
		global $sh_fbc_settings;
		//Contextual Help output
		if ($screen_id == $sh_fbc_settings):
			
			$contextual_help = '<h2>Help - Facebook Comments OTF</h2>';
			
			$contextual_help .= '<p>When you place a plugin function into your theme, you will likely want to wrap it with an `if( function_exists(\'FUNCTION_NAME_HERE\') )` condition.</p>';
			
			$contextual_help .= '<p>This way, if the plugin gets disabled, your theme won\'t explode.</p>';
			
			$contextual_help .= '<h3>fbc_comment_form( $args )</h3>';
			
			$contextual_help .= '<p>Outputs the Facebook comment form onto the page:</p>';
			
			$contextual_help .= '<p>$args is an optional associative array that you can implement to override the following defaults: </p>';
			
			$contextual_help .= '<ul>';
			
			$contextual_help .= '<li>(int) num_comments (Default = 10)</li>';
			
			$contextual_help .= '<li>(int) width (Default = $content_width | 500)</li>';
			
			$contextual_help .= '<li>(string) app_id (Default = option set in settings | null)</li>';
			
			$contextual_help .= '<li>(string) color (light|dark, Default = light)</li>';

			$contextual_help .= '<li>(int) id (Default = $post->ID)</li>';

			$contextual_help .= '<li>(string) notify_email (Default = post author\'s e-mail)</li>';
			
			$contextual_help .= '</ul>';

			$contextual_help .= '<h3>fbc_comment_count( $id, $zero, $single, $plural )</h3>';
			
			$contextual_help .= '<p>Outputs a formatted comment count structured for multiple scenarios (0, 1, and multiple comments) onto the page</p>';
			
			$contextual_help .= '<ul>';
			
			$contextual_help .= '<li>(int) $id - Default = $post->ID</li>';
			
			$contextual_help .= '<li>(string) $zero - Default = 0 comments</li>';
			
			$contextual_help .= '<li>(string) $single - Default = 1 comment</li>';
			
			$contextual_help .= '<li>(string) $plural - Default = comments</li>';
			
			$contextual_help .= '</ul>';
			
			$contextual_help .= '<h3>fbc_get_comment_count( $id )</h3>';
			
			$contextual_help .= '<p>Returns only the comment count number</p>';
						
			$contextual_help .= '<ul>';
			
			$contextual_help .= '<li>(int) $id - Default = $post->ID</li>';
			
			$contextual_help .= '</ul>';

			$contextual_help .= '<h3>'.__('Credits / Support', 'shaken').'</h3>';
			
			$contextual_help .= '<p>'.__( 'The Facebook Comments (OTF) plugin was created by', 'shaken' ).' <a href="http://shakenandstirredweb.com">Shaken and Stirred Web</a>. '.__( 'If you find any bugs, have feature requests, or would like to contribute, please visit the plugin\'s <a href="https://github.com/nickhamze/facebook-comments-otf">GitHub page</a>.', 'shaken').'</p>';
			

		endif;
		
		return $contextual_help;
	}
		
add_filter('contextual_help', 'sh_fbc_help_page', 10, 3); 

?>