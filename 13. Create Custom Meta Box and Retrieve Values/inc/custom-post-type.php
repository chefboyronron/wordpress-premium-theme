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
	/*=================================================================================
		Add Metabox to CPT
	===================================================================================*/
	add_action( 'add_meta_boxes', 'sunset_contact_add_meta_box' );
	// Save metabox post
	add_action( 'save_post', 'sunset_save_contact_email_data' );


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
	Edit table labels of the custom post type
	and add columns
====================================================*/
function sunset_set_contact_columns( $columns ){
	
	$newColumns = array();
	$newColumns['title'] = 'Fullname';
	$newColumns['message'] = 'Message';
	$newColumns['email'] = 'Email';
	$newColumns['date'] = 'Date';


	return $newColumns;
}

/*==================================================
	Manage content of custom columns
====================================================*/
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
			$email = get_post_meta( $post_id, '_contact_email_value_key', true );
			echo '<a href="mailto:'.$email.'">'.$email.'</a>';
			break;
	}

}

/*==========================
	CONTACT META BOXEX
============================*/

function sunset_contact_add_meta_box() {
	/*
		add_meta_box(
			string $id,
			string $title,
			callback $callback,
			mixed $screen (cpt name),
			string $contex, //position of the meta box// posible val = 'normal', 'side'
			string $priority, posible val = 'high', 'core', 'default', 'low'
			array $callback_args [optional]
		);
	*/
	add_meta_box( 'contact_email', 'User Email', 'sunset_contact_email_callback', 'sunset-contact', 'side', 'default' );
}

function sunset_contact_email_callback( $post ){
	/*
		wp_nonce_field(
			mixed $action,
			string $name
			bool $referer,
			bool $echo
		);
		get_post_meta(
			int $post_id,
			string $key,
			bool $single
		);
	*/
	wp_nonce_field( 'sunset_save_contact_email_data', 'sunset_contact_email_meta_box_nonce' );

	$value = get_post_meta( $post->ID, '_contact_email_value_key', true );

	echo '<label for="sunset_contact_email_field">User Email Address: </label>';
	echo '<input type="email" id="sunset_contact_email_field" name="sunset_contact_email_field" value="' . esc_attr( $value ) . '" size="25" />';

}

function sunset_save_contact_email_data( $post_id ){

	if( !isset( $_POST['sunset_contact_email_meta_box_nonce'] ) ){
		return;
	}

	if( !wp_verify_nonce( $_POST['sunset_contact_email_meta_box_nonce'], 'sunset_save_contact_email_data' ) ){
		return;
	}

	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return;
	}

	if( !current_user_can( 'edit_post' ) ){
		return;
	}

	if( !isset($_POST['sunset_contact_email_field']) ){
		return;
	}

	$my_data = sanitize_text_field( $_POST['sunset_contact_email_field'] );
	update_post_meta( $post_id, '_contact_email_value_key', $my_data );

}