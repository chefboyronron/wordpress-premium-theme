<?php
/*
	=====================
		ADMIN PAGE
	=====================
*/

function sunset_addmin_page(){

	add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'ronnn-sunset', 'sunset_theme_create_page', get_template_directory_uri() . '/img/sunset-icon.png', 110);

}
add_action( 'admin_menu', 'sunset_addmin_page' );
function sunset_theme_create_page(){
	// Generation of our admin page
}

?>