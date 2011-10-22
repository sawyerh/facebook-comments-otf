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
	register_setting( 'sh_fbc_options', 'sh_fbc_options', 'sh_fbc_validate_options' );
	
	add_settings_section(
		'sh_fbc_main', // id
		false, // Title of section
		false, // Callback
		'sh_fbc_settings' // page to display on
	);
	
	add_settings_field(
		'sh_fbc_text_string', // id
		'Application ID',
		'sh_fbc_app_id_input', // Callback
		'sh_fbc_settings', // page to display on
		'sh_fbc_main' // section to display in
	);
}

function sh_fbc_main_text(){
	echo '<p>Enter settings here.</p>';
}

function sh_fbc_app_id_input(){
	$options = get_option( 'sh_fbc_options' );
	$app_id = $options['app_id'];
	
	echo '<input id="app_id" name="sh_fbc_options[app_id]" type="text" value="'.$app_id.'" />';
	echo '<br /><span class="description">fb:app_id</span>';
	
}

/*	Validation
 ******************************************************** */
function sh_fbc_validate_options( $input ){
	return $input;
}


?>