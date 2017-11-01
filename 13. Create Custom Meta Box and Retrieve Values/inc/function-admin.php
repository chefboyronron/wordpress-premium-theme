<?php
/**************************
@package theme_name
	=====================
		ADMIN PAGE
	=====================
***************************/


/*==========================================
	CREATING CUSTOM PAGE AND SUBMENU PAGE
  ==========================================*/
function sunset_addmin_page(){

	/* PARAMS
		- add_menu_page( string $page_title, string $menu_title, string $capability, string $menu_slug, string $callback_function, string $icon, integer $menu_location )

		- add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, string $callback_function )
	*/

	//Generate Admin Page
	add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'ronnn_sunset', 'sunset_theme_create_page', get_template_directory_uri() . '/img/sunset-icon.png', 110);
	/*
		Generate Admin Sub Pages
		if first creation of submenu make the [submenu_title == menu_title] [submenu_slug == menu_slug]
		[submenu callback function == menu callback function]
	*/
	add_submenu_page( 'ronnn_sunset', 'Sunset Sidebar Options', 'Sidebar', 'manage_options', 'ronnn_sunset', 'sunset_theme_create_page' );
	add_submenu_page( 'ronnn_sunset', 'Sunset Theme Options', 'Theme Options', 'manage_options', 'ronnn_sunset_theme', 'sunset_theme_support_page' );
	add_submenu_page( 'ronnn_sunset', 'Sunset Contact Form', 'Contact Form', 'manage_options', 'ronnn_sunset_theme_contact', 'sunset_contact_form_page' );
	add_submenu_page( 'ronnn_sunset', 'Sunset CSS Options', 'Custom CSS', 'manage_options', 'ronnn_sunset_css', 'sunset_theme_css_page' );

	//Active custom settings
	add_action('admin_init', 'sunset_custom_settings');

}
add_action( 'admin_menu', 'sunset_addmin_page' );

/*===========================
	TEMPLATE SUBMENU FUNCTION
  ===========================*/

function sunset_theme_create_page(){
	// Generation of our admin page
	require_once( get_template_directory() . '/inc/templates/sunset-admin.php' );
}

function sunset_theme_css_page(){
	// Submenu CSS content
}

function sunset_theme_support_page(){
	// Submenu Theme Options
	require_once( get_template_directory() . '/inc/templates/sunset-theme-support.php' );
}

function sunset_contact_form_page(){
	// Contact Form Options
	require_once( get_template_directory() . '/inc/templates/sunset-contact-form.php' );
}


/*===========================
	CREATING CUSTOM FORM
  ===========================*/
function sunset_custom_settings(){

	/* PARAMS
		- reguster_setting( string $option_group, string $option_name, callback optional $sanitize_callback  );

		- add_settings_section( string $id, string $title, string $callback, string $page );

		- add_settings_field( string $id, string $title, string $callback, string $page, string $section, array optional $args )
	*/


	// SIDEBAR OPTIONS
	register_setting( 'sunset-settings-group', 'profile_picture' );
	register_setting( 'sunset-settings-group', 'first_name' );
	register_setting( 'sunset-settings-group', 'last_name' );
	register_setting( 'sunset-settings-group', 'user_description', 'sunset_sanitize_input');
	register_setting( 'sunset-settings-group', 'twitter_handler' , 'sunset_sanitize_twitter_handler');
	register_setting( 'sunset-settings-group', 'facebook_handler' );
	register_setting( 'sunset-settings-group', 'gplus_handler' );

	add_settings_section( 'sunset-sidebar-options', 'Sidebar Option', 'sunset_sidebar_options', 'ronnn_sunset' );

	add_settings_field( 'sidebar-profile-picture', 'Profile Picture', 'sunset_sidebar_profile', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-name', 'Full Name', 'sunset_sidebar_name', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-description', 'Description', 'sunset_sidebar_description', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-twitter', 'Tweeter Handler', 'sunset_sidebar_twitter', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-facebook', 'Facebook Handler', 'sunset_sidebar_facebook', 'ronnn_sunset', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-gplus', 'Google+ Handler', 'sunset_sidebar_gplus', 'ronnn_sunset', 'sunset-sidebar-options' );

	// THEME SUPPORT OPTIONS
	register_setting( 'sunset-theme-support', 'post_formats' );
	register_setting( 'sunset-theme-support', 'custom_header' );
	register_setting( 'sunset-theme-support', 'custom_background' );

	add_settings_section( 'sunset-theme-options', 'Theme Options', 'sunset_theme_options', 'ronnn_sunset_theme' );

	add_settings_field( 'post-formats', 'Posts Formats', 'sunset_posts_formats', 'ronnn_sunset_theme', 'sunset-theme-options');
	add_settings_field( 'custom-header', 'Custom Header', 'sunset_custom_header', 'ronnn_sunset_theme', 'sunset-theme-options');
	add_settings_field( 'custom-background', 'Custom Background', 'sunset_custom_background', 'ronnn_sunset_theme', 'sunset-theme-options');

	// CONTACT FORM OPTIONS
	register_setting( 'sunset-contact-options', 'activate_contact' );

	add_settings_section( 'sunset-contact-section', 'Contact Form', 'sunset_contact_section', 'ronnn_sunset_theme_contact' );

	add_settings_field( 'activate-form', 'Activate Contact Form', 'sunset_activate_contact', 'ronnn_sunset_theme_contact', 'sunset-contact-section' );



}

/*========================================
	CALLBACK FUNCTIONS FOR THEME SUPPORT
==========================================*/
function sunset_theme_options(){
	echo 'Activate and Deactivate specific Theme Support Options';
}

function sunset_contact_section(){
	echo 'Activate and Deactivate the Built-in Contact Form';
}

function sunset_activate_contact(){
	$options = get_option( 'activate_contact' );
	$check = ( @$options == 1 ) ? 'checked' : '';
	echo '
		<label>
			<input type="checkbox" id="custom_header" name="activate_contact" value="1" '.$check.'/>
		</label>
		<p class="description">Menu Location : Dashboard->Messages</p>
	';
}

function sunset_posts_formats(){
	$options = get_option( 'post_formats' );
	$formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
	$output = '';
	foreach( $formats as $format ){
		$check = ( @$options[$format] == 1 ) ? 'checked' : '';
		$output .= '
			<label>
				<input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$check.'/> 
				'.$format.'
			</label><br>
		';
	}
	$output .= '<p class="description">Option Location : Posts->All Posts->[Specific Post]->Format</p>';
	echo $output;
}

function sunset_custom_header(){
	$options = get_option( 'custom_header' );
	$check = ( @$options == 1 ) ? 'checked' : '';
	echo '
		<label>
			<input type="checkbox" id="custom_header" name="custom_header" value="1" '.$check.'/> 
			Activate Custom Header
		</label>
		<p class="description">Menu Location : Appearance->Header</p>
	';
}

function sunset_custom_background(){
	$options = get_option( 'custom_background' );
	$check = ( @$options == 1 ) ? 'checked' : '';
	echo '
		<label>
			<input type="checkbox" id="custom_background" name="custom_background" value="1" '.$check.'/> 
			Activate Custom Background
		</label>
		<p class="description">Menu Location : Appearance->Background</p>
	';
}

/*				END
====================================*/


/*==========================================
	CALLBACK FUNCTIONS FOR SIDEBAR OPTIONS
============================================*/

function sunset_sidebar_options(){
	echo 'Customize your Sidebar Information';
}

function sunset_sidebar_profile(){
	$picture = esc_attr( get_option( 'profile_picture' ) );
	if( empty($picture) ){
		echo '
			<input type="hidden" id="profile-picture" name="profile_picture" value="">
			<input type="button" value="Upload Profile Picture" id="upload-button" class="button button-secondary">
		';
	}else{
		echo '
			<input type="hidden" id="profile-picture" name="profile_picture" value="'.$picture.'">
			<input type="button" value="Replace Profile Picture" id="upload-button" class="button button-secondary">
			<input type="button" value="Remove" id="remove-picture" class="button button-secondary">
		';
	}
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

/*				END
====================================*/

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


?>