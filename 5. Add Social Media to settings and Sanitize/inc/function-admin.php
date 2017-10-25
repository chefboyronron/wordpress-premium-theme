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
	register_setting( 'sunset-settings-group', 'last_name' );
	register_setting( 'sunset-settings-group', 'user_description', 'sunset_sanitize_input');
	register_setting( 'sunset-settings-group', 'twitter_handler' , 'sunset_sanitize_twitter_handler');
	register_setting( 'sunset-settings-group', 'facebook_handler' );
	register_setting( 'sunset-settings-group', 'gplus_handler' );


	add_settings_section( 'sunset-sidebar-options', 'Sidebar Option', 'sunset_sidebar_options', 'ronnn_sunset' );

	add_settings_field( 'sidebar-name', 'Full Name', 'sunset_sidebar_name', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-description', 'Description', 'sunset_sidebar_description', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-twitter', 'Tweeter Handler', 'sunset_sidebar_twitter', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-facebook', 'Facebook Handler', 'sunset_sidebar_facebook', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-gplus', 'Google+ Handler', 'sunset_sidebar_gplus', 'ronnn_sunset', 'sunset-sidebar-options' );

}

function sunset_sidebar_options(){
	echo 'Customize your Sidebar Information';
}

function sunset_sidebar_name(){
	$firstName = esc_attr( get_option( 'first_name' ) );
	$lastName = esc_attr( get_option( 'last_name' ) );
	echo '
		<input type="text" name="first_name" value="'.$firstName.'" placeholder="First Name" />
		<input type="text" name="last_name" value="'.$lastName.'" placeholder="Last Name" />
	';
}

function sunset_sidebar_description(){
	$description = esc_attr( get_option( 'user_description' ) );
	echo '
		<textarea name="user_description" cols="30" rows="5">'.$description.'</textarea>
		<p class="des">Write something smart.</p>
	';
}

function sunset_sidebar_twitter(){
	$twitter = esc_attr( get_option( 'twitter_handler' ) );
	echo '
		<span class="description">https://twitter.com/</span>
		<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter Handler" />
		<p class="des">Enter twitter username without @ character</p>
	';
}

function sunset_sidebar_facebook(){
	$facebook = esc_attr( get_option( 'facebook_handler' ) );
	echo '
		<span class="description">https://www.facebook.com/</span>
		<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook Handler" />
	';
}

function sunset_sidebar_gplus(){
	$gplus = esc_attr( get_option( 'gplus_handler' ) );
	echo '
		<span class="description">https://plus.google.com/</span>
		<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google+ Handler" />
	';
}

// Sanitize input field
function sunset_sanitize_twitter_handler( $input ){
	$output = sanitize_text_field( $input );
	$output = str_replace('@', '', $output);
	return $output;
}

function sunset_sanitize_input( $input ){
	$output = sanitize_text_field( $input );
	return $output;
}


function sunset_theme_create_page(){
	// Generation of our admin page
	require_once( get_template_directory() . '/inc/templates/sunset-admin.php' );
}

function sunset_theme_css_page(){
	// Submenu CSS content
}

?>