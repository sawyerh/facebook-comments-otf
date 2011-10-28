<?php add_action( 'admin_menu', 'sh_fbc_help_page' );

function sh_fbc_help_page() {

	/* Add documentation */
	$contextual_help = '<h2>Help - Facebook Comments OTF</h2>';
			
	$contextual_help .= '<p>When you place a plugin function into your theme, you will likely want to wrap it with an <code>if( function_exists(\'FUNCTION_NAME_HERE\') )</code> condition.</p>';
	
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

	$contextual_help .= '<h3>Contribute</h3>';
	
	$contextual_help .= '<p>If you find any bugs, have feature requests, or would like to contribute, please visit the plugin\'s <a href="https://github.com/sawyerh/facebook-comments-otf">GitHub page</a></p>';

	add_contextual_help( 'settings_page_sh_fbc_settings', $contextual_help );
}

?>