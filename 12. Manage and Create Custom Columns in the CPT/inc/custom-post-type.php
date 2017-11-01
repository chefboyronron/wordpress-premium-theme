<?php
/***********************************
@package theme_name
	==============================
		THEME CUSTOM POST TYPES
	==============================
************************************/
$contact = get_option( 'activate_contact' );
if( @$contact == 1 ){

	add_action( 'init', 'sunset_contact_custom_post_type' );
	
	/*=================================================================================
		add_filter( 'manage_[yourcustomposttype]_posts_columns', 'callback function' );
	===================================================================================*/
	add_filter( 'manage_sunset-contact_posts_columns', 'sunset_set_contact_columns' );
	/*=================================================================================
		add_action('manage_[yourcustomposttype]contact_posts_custom_column', 'callback function', 10, number of argument pass);
	===================================================================================*/
	add_action('manage_sunset-contact_posts_custom_column', 'sunset_contact_custom_column', 10, 2 );


}
/* CONTACT CPT */
function sunset_contact_custom_post_type(){
	$labels = array(
		'name'			 	=> 'Messages',
		'singular_name'		=> 'Message',
		'menu_name'			=> 'Messages',
		'name_admin_bar'	=> 'Message'
	);
	$args = array(
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'capability_type'	=> 'post',
		'heirarchical'		=> false,
		'menu_position'		=> 26,
		'menu_icon'			=> 'dashicons-email-alt',
		'supports'			=> array( 'title', 'editor', 'author' )
	);
	register_post_type( 'sunset-contact', $args );
}


/*==================================================
	Edit table of the custom post type DASHBOARD
====================================================*/
function sunset_set_contact_columns( $columns ){
	
	$newColumns = array();
	$newColumns['title'] = 'Fullname';
	$newColumns['message'] = 'Message';
	$newColumns['email'] = 'Email';
	$newColumns['date'] = 'Date';


	return $newColumns;
}

function sunset_contact_custom_column( $column, $post_id ){

	switch( $column ){
		case 'message' :
			//message column
			$excert = get_the_excerpt();
			if(strlen($excert) > 50){
				$excert = substr($excert, 0, 50) . '[...]';
			}
			echo $excert;
			break;
		case 'email' :
			//email column
			echo 'email address';
			break;
	}

}