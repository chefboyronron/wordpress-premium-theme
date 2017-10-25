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
	wp_register_style( 
		'sunset_admin', 
		get_template_directory_uri() . '/css/sunset.admin.css',
		array(),
		'1.0.0',
		'all' 
	);
	wp_enqueue_style( 'sunset_admin' ); //including css file into front-end
}
add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );

?>