<?php 

/*	Display the settings page
 ******************************************************** */
function sh_fbc_settings(){
	?>
	<div class="wrap">
	<?php screen_icon(); ?>
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
	
	register_setting( 'sh_fbc_options', 'sh_fbc_options', 'sh_fbc_validate_options' );
	add_settings_field(
		'sh_fbc_app_id', // id
		'Facebook App ID',
		'sh_fbc_app_id_input', // Callback
		'sh_fbc_settings', // page to display on
		'sh_fbc_main' // section to display in
	);
	
	register_setting( 'sh_fbc_options', 'sh_fbc_options', 'sh_fbc_validate_options' );
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
	echo '<br /><span class="description">(fb:app_id) When you implement multiple comments boxes on your site and tie them together using an app_id, the moderation settings you choose will apply to all your comments boxes. You can also manage all comments at <a href="http://developers.facebook.com/tools/comments">http://developers.facebook.com/tools/comments</a></span>';
	
}

function sh_fbc_admin_id_input(){
	$options = get_option( 'sh_fbc_options' );
	$app_id = $options['admin_ids'];
	
	echo '<input id="admin_ids" name="sh_fbc_options[admin_ids]" type="text" value="'.$app_id.'" />';
	echo '<br /><span class="description">(fb:admin_ids) To add multiple moderators, separate the uids by comma without spaces.</span>';
	
}

/*	Validation
 ******************************************************** */
function sh_fbc_validate_options( $input ){
	return $input;
}


?>