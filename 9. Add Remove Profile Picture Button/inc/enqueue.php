<?php
/*
	=============================
		ADMIN ENQUEUE SETTINGS
	=============================
*/

function sunset_load_admin_scripts( $hook ){
	// Detection of including style to other admin page
	if( 'toplevel_page_ronnn_sunset' != $hook ){
		return;
	}
	//include CSS file
	wp_register_style( 
		'sunset_admin', 
		get_template_directory_uri() . '/css/sunset.admin.css',
		array(),
		'1.0.0',
		'all'
	);
	wp_enqueue_style( 'sunset_admin' ); //including css file into front-end

	// WordPress Media Uploader HOOK
	wp_enqueue_media();

	//include JS file
	wp_register_script(
		'sunset-admin-script', // register ID
		get_template_directory_uri() . '/js/sunset.admin.js', // Url of the js file
		array(),
		'1.0.0', // version
		true // is_in_the_footer
	);
	wp_enqueue_script( 'sunset-admin-script' );

	
}
add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );

?>