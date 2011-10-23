<?php 

// Add the Settings page menu item
function sh_fbc_add_page(){
	add_options_page( 'Facebook Comments (OTF)', 'Facebook Comments', 'manage_options', 'sh_fbc_settings', 'sh_fbc_settings' );
}

/*	Display the settings page
 ******************************************************** */
function sh_fbc_settings(){
	?>

	<?php if( !current_user_can( 'manage_options' ) ) wp_die( __( 'Insufficient permissions', 'shaken' ) ); ?>
	
	<div class="wrap">
	<?php screen_icon( 'plugins' ); ?>
	<h2>&quot;Facebook Comments (OTF)&quot; Settings</h2>

		<form action="options.php" method="post">
			<?php 
				settings_fields('sh_fbc_options');
				do_settings_sections( 'sh_fbc_settings' );
			?>		
			
			<p class="submit"><input name="Submit" type="submit" value="Save Changes" class="button-primary" /></p>
		</form>

	</div>
	<?php
}

/*	Register the settings
 ******************************************************** */
add_action( 'admin_init', 'sh_fbc_settings_init' );
function sh_fbc_settings_init(){
	add_settings_section(
		'sh_fbc_main', // id
		'Comment Moderation', // Title of section
		'sh_fbc_main_text', // Callback
		'sh_fbc_settings' // page to display on
	);
	
	register_setting( 'sh_fbc_options', 'sh_fbc_options', 'sh_fbc_sanitize_options' );
	add_settings_field(
		'sh_fbc_app_id', // id
		'Facebook App ID',
		'sh_fbc_app_id_input', // Callback
		'sh_fbc_settings', // page to display on
		'sh_fbc_main' // section to display in
	);
	
	register_setting( 'sh_fbc_options', 'sh_fbc_options', 'sh_fbc_sanitize_options' );
	add_settings_field(
		'sh_fbc_admin_ids', // id
		'Facebook User ID(s)',
		'sh_fbc_admin_id_input', // Callback
		'sh_fbc_settings', // page to display on
		'sh_fbc_main' // section to display in
	);
}

function sh_fbc_main_text(){
	echo '<p>Setting one of the following options will allow the users you specify to moderate the Facbeook comments left on your site.</p>';
}

function sh_fbc_app_id_input(){
	$options = get_option( 'sh_fbc_options' );
	$app_id = $options['app_id'];
	
	echo '<input id="app_id" name="sh_fbc_options[app_id]" type="text" value="'.$app_id.'" />';
	echo '<br /><span class="description">(fb:app_id) This is the best method. When using an app_id, the moderation settings you choose will apply to all your comments boxes. <a href="https://developers.facebook.com/apps">Create your App</a>. You can also manage all comments <a href="http://developers.facebook.com/tools/comments">here</a><br />(Example: 257559655952366)</span>';
	
}

function sh_fbc_admin_id_input(){
	$options = get_option( 'sh_fbc_options' );
	$app_id = $options['admin_ids'];
	
	echo '<input id="admin_ids" name="sh_fbc_options[admin_ids]" type="text" value="'.$app_id.'" />';
	echo '<br /><span class="description">(fb:admins) To add multiple moderators, separate the uids by comma without spaces.</span>';
	
}

/*	Validation
 ******************************************************** */
function sh_fbc_sanitize_options( $input ){
	
	$clean_options = array();
	
	foreach( $input as $k => $v ){
		$clean = trim($v);
		$clean = esc_html($v);
		$clean_options[$k] = $clean;
	}
	
	return $clean_options;
}


?>