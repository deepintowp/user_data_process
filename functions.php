<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script ( 'our-script',  get_stylesheet_directory_uri().'/js/myajax.js', array('jquery'), '1.0', true );
	wp_localize_script( 'our-script', 'data_container', array(
	'ajaxurl'=> admin_url('admin-ajax.php'),
	'security' => wp_create_nonce('submitted-data')
	
	) );
}

// cpt  
 
 // create cpt



function register_user_question_content_type() {
	$post_labels = array(
		'name' 			    => 'Contact',
		'singular_name' 	=> 'Contacts',
		'add_new' 		    => 'Add New',
		'add_new_item'  	=> 'Add New Contact',
		'edit'		        => 'Edit',
		'edit_item'	        => 'Edit User Contact',
		'new_item'	        => 'New User Contact',
		'view' 			    => 'View User Contact',
		'view_item' 		=> 'View User Contact',
		'search_term'   	=> 'Search User Contact',
		'parent' 		    => 'Parent User Contact',
		'not_found' 		=> 'No User Questions found',
		'not_found_in_trash' 	=> 'No User Questions in Trash'
	);
	register_post_type( 'contact_us', array( 'labels' => $post_labels, 'public' => true ) );
	$tax_labels = array(
		'name'              => _x( 'Query', 'text-domain' ),
		'singular_name'     => _x( 'Queries', 'text-domain' ),
		'search_items'      => __( 'Search Queries', 'text-domain' ),
		'all_items'         => __( 'All Queries', 'text-domain' ),
		'parent_item'       => __( 'Parent Query', 'text-domain' ),
		'parent_item_colon' => __( 'Parent Query:', 'text-domain' ),
		'edit_item'         => __( 'Edit Query', 'text-domain' ),
		'update_item'       => __( 'Update Query', 'text-domain' ),
		'add_new_item'      => __( 'Add New Query', 'text-domain' ),
		'new_item_name'     => __( 'New Query Name', 'text-domain' ),
		'menu_name'         => __( 'Query', 'text-domain' ),
	);
	register_taxonomy( 'query_cat', 'contact_us', array( 'labels' => $tax_labels, 'rewrite' =>  array('slug' => 'query_cat', 'with_front' => false) ) );
add_action( 'add_meta_boxes', 'my_contact_add_meta_box' );
add_action( 'save_post', 'my_save_contact_email_data' );
	
}
add_action( 'init', 'register_user_question_content_type' );



// crteate meta box

function my_contact_add_meta_box() {
	add_meta_box( 'contact_email', 'User Email', 'my_contact_email_callback', 'contact_us', 'side' );
}
 function my_contact_email_callback( $post ) {
	wp_nonce_field( 'my_save_contact_email_data', 'my_contact_email_meta_box_nonce' );
	
	$value = get_post_meta( $post->ID, '_contact_email_value_key', true );
	
	echo '<label for="my_contact_email_field">User Email Address: </label>';
	echo '<input type="email" id="my_contact_email_field" name="my_contact_email_field" value="' . esc_attr( $value ) . '" size="25" />';
}


function my_save_contact_email_data( $post_id ) {
	
	if( ! isset( $_POST['my_contact_email_meta_box_nonce'] ) ){
		return;
	}
	
	if( ! wp_verify_nonce( $_POST['my_contact_email_meta_box_nonce'], 'my_save_contact_email_data') ) {
		return;
	}
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return;
	}
	
	if( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	if( ! isset( $_POST['my_contact_email_field'] ) ) {
		return;
	}
	
	$my_data = sanitize_text_field( $_POST['my_contact_email_field'] );
	
	update_post_meta( $post_id, '_contact_email_value_key', $my_data );
	
}



function our_action_function(){
	
	$data = $_POST['data'];
	$security = $_POST['security'];
	$honeypot = $_POST['honeypot'];
	if(!empty($honeypot)){
		wp_send_json_error('HONEY POT CHECK FAILED');
		return;
	}
	if(!check_ajax_referer('submitted-data','security')){
		wp_send_json_error('Security CHECK FAILED');
		return;
	}
	if(empty($data['email'])){
		//wp_send_json_error('HONEY POT CHECK FAILED');
		echo 'enter email';
		return;
	}
	
	
	
	
	
	
	
	$pstdata =  array(
		'post_title' =>$data['name'],
		'post_content' =>$data['content'],
		'post_status' => 'draft',
		'post_type' => 'contact_us'
		
		);
	$post_id = wp_insert_post($pstdata, true);
		
	if($post_id){
	update_post_meta($post_id, '_contact_email_value_key',  $data['email'] );
	wp_set_object_terms( $post_id, $data['option'], 'query_cat', true);
	
	}
	
	echo $post_id;
	
	
	die();
	
	
}
add_action('wp_ajax_nopriv_our_action_function', 'our_action_function');
add_action('wp_ajax_our_action_function', 'our_action_function');






