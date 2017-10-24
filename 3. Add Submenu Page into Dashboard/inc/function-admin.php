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

}
add_action( 'admin_menu', 'sunset_addmin_page' );
function sunset_theme_create_page(){
	// Generation of our admin page
	require_once( get_template_directory() . '/inc/templates/sunset-admin.php' );
}

function sunset_theme_css_page(){
	// Submenu CSS content
}

?>