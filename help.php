<?php 

/*	Show the new style help section if user is running WP 3.3
 ******************************************************** */
if( version_compare( '3.3', get_bloginfo( 'version' ), '<=' ) ):

function sh_fbc_help_page() {
	global $sh_fbc_settings;
	$current_screen = get_current_screen();
	if ($current_screen->id != $sh_fbc_settings)
		return;

	// Overview tab
	
	$fbc_overview = '<h2>Help - Facebook Comments OTF</h2>';
	
	$fbc_overview .= 'Facebook Comments (OTF) is part of the <a href="http://onlythefunctions.com">Only the Functions</a> movement - A collection of WordPress plugins that give code-savvy users access to functions which return the information / functionality they are looking for, and allows them to place it where they want, without any hacking to change default behavior.';
	
	$fbc_overview .= 'This plugin includes functions for displaying a Facebook comment form and functions for retrieving the comment count. View the installation instructions for more info regarding these functions.';
				
	$fbc_overview .= '<h3>Note:</h3>';
	
	$fbc_overview .= '<p>When you place a plugin function into your theme, you will likely want to wrap it with an <br><code>if( function_exists(\'FUNCTION_NAME_HERE\') )</code> condition. This way, if the plugin gets disabled, your theme won\'t explode.</p>';
			
	$current_screen->add_help_tab( array(
	    'id'      => 'overview',
		'title'   => __('Overview'),
		'content' => $fbc_overview,
	) );
	
	// Installation tab
	
	$fbc_installation = '<h3>Installation</h3>';
			
	$fbc_installation .= '<p>1. Place the comment form function into your theme code (probably want to put it in single.php)</p>';
	
	$fbc_installation .= '<h3>For Moderation Capabilities</h3>';
	
	$fbc_installation .= '<p>2. <a href="https://developers.facebook.com/apps" target="_blank">Create a Facebook App</a></p>';
		
	$fbc_installation .= '<p>3. Copy the App ID and paste it into the plugin Settings (Settings &raquo; Facebook Comments)</p>';
		
	
	$current_screen->add_help_tab( array(
	    'id'      => 'installation',
		'title'   => __('Installation'),
		'content' => $fbc_installation,
	) );
	
	// Available Functions tab
	
	$fbc_available_functions = '<h3>fbc_comment_form( $args )</h3>';
		
	$fbc_available_functions .= '<p>Outputs the Facebook comment form onto the page:</p>';
	
	$fbc_available_functions .= '<p>$args is an optional associative array that you can implement to override the following defaults: </p>';
		
	$fbc_available_functions .= '<ul>';
		
	$fbc_available_functions .= '<li>(int) num_comments (Default = 10)</li>';
		
	$fbc_available_functions .= '<li>(int) width (Default = $content_width | 500)</li>';
		
	$fbc_available_functions .= '<li>(string) app_id (Default = option set in settings | null)</li>';
		
	$fbc_available_functions .= '<li>(string) color (light|dark, Default = light)</li>';
	
	$fbc_available_functions .= '<li>(int) id (Default = $post->ID)</li>';
	
	$fbc_available_functions .= '<li>(string) notify_email (Default = post author\'s e-mail)</li>';
		
	$fbc_available_functions .= '</ul>';
	
	$fbc_available_functions .= '<h3>fbc_comment_count( $id, $zero, $single, $plural )</h3>';
		
	$fbc_available_functions .= '<p>Outputs a formatted comment count structured for multiple scenarios (0, 1, and multiple comments) onto the page</p>';
		
	$fbc_available_functions .= '<ul>';
		
	$fbc_available_functions .= '<li>(int) $id - Default = $post->ID</li>';
		
	$fbc_available_functions .= '<li>(string) $zero - Default = 0 comments</li>';
		
	$fbc_available_functions .= '<li>(string) $single - Default = 1 comment</li>';
		
	$fbc_available_functions .= '<li>(string) $plural - Default = comments</li>';
		
	$fbc_available_functions .= '</ul>';
		
	$fbc_available_functions .= '<h3>fbc_get_comment_count( $id )</h3>';
		
	$fbc_available_functions .= '<p>Returns only the comment count number</p>';
					
	$fbc_available_functions .= '<ul>';
		
	$fbc_available_functions .= '<li>(int) $id - Default = $post->ID</li>';
		
	$fbc_available_functions .= '</ul>';
	
	$current_screen->add_help_tab( array(
	    'id'      => 'available-functions',
		'title'   => __('Available Functions'),
		'content' => $fbc_available_functions,
	) );
	
	// Sidebar
	
	$current_screen->add_help_sidebar(
		'<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
		'<p><a href="https://github.com/sawyerh/facebook-comments-otf" target="_blank">' . __( 'Contribute on Github' ) . '</a></p>' .
		'<p><a href="http://onlythefunctions.com" target="_blank">' . __( 'Only the Functions' ) . '</a></p>'
	); 

} 

else:

/*	Show the old style contextual help if user isn't running WP 3.3+
 ******************************************************** */

add_action( 'admin_menu', 'sh_fbc_help_page_old' );

function sh_fbc_help_page_old() {

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

endif;
?>