<?php
/*
	=====================
		ADMIN PAGE
	=====================
*/

function sunset_addmin_page(){

	//Generate Admin Page
	add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'ronnn_sunset', 'sunset_theme_create_page', get_template_directory_uri() . '/img/sunset-icon.png', 110);
	//Generate Admin Sub Pages
	/*
		if first creation of submenu make the [submenu_title == menu_title] [submenu_slug == menu_slug]
		[submenu callback function == menu callback function]
	*/
	add_submenu_page( 'ronnn_sunset', 'Sunset Theme Options', 'General', 'manage_options', 'ronnn_sunset', 'sunset_theme_create_page' );
	add_submenu_page( 'ronnn_sunset', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 'ronnn_sunset_css', 'sunset_theme_css_page' );
	
	//Active custom settings
	add_action('admin_init', 'sunset_custom_settings');

}
add_action( 'admin_menu', 'sunset_addmin_page' );

function sunset_custom_settings(){

	register_setting( 'sunset-settings-group', 'first_name' );
	add_settings_section( 'sunset-sidebar-options', 'Sidebar Option', 'sunset_sidebar_options', 'ronnn_sunset' );
	add_settings_field( 'sidebar-name', 'First Name', 'sunset_sidebar_name', 'ronnn_sunset', 'sunset-sidebar-options' );

}

function sunset_sidebar_options(){
	echo 'Customize your Sidebar Information';
}

function sunset_sidebar_name(){
	$firstName = esc_attr( get_option( 'first_name' ) );
	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name" />';
}


function sunset_theme_create_page(){
	// Generation of our admin page
	require_once( get_template_directory() . '/inc/templates/sunset-admin.php' );
}

function sunset_theme_css_page(){
	// Submenu CSS content
}

?>