<?php

/*
 * Front-end scripts
 */
function ct_chosen_load_scripts_styles() {

	wp_register_style( 'ct-chosen-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,300');

	// main JS file
	wp_enqueue_script('ct-chosen-js', get_template_directory_uri() . '/js/build/production.min.js', array('jquery'),'', true);
	wp_localize_script( 'ct-chosen-js', 'objectL10n', array(
		'openMenu'       => __( 'open menu', 'chosen' ),
		'closeMenu'      => __( 'close menu', 'chosen' ),
		'openChildMenu'  => __( 'open dropdown menu', 'chosen' ),
		'closeChildMenu' => __( 'close dropdown menu', 'chosen' )
	) );

	// Google Fonts
	wp_enqueue_style('ct-chosen-google-fonts');

	// Font Awesome
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/font-awesome.min.css');

	// Stylesheet
	if( is_rtl() ) {
		wp_enqueue_style('ct-chosen-style-rtl', get_template_directory_uri() . '/styles/rtl.min.css');
	} else {
		wp_enqueue_style('ct-chosen-style', get_stylesheet_uri() );
	}

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if( is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* Load Polyfills */

	// HTML5 shiv
	wp_enqueue_script('ct-chosen-html5-shiv', get_template_directory_uri() . '/js/build/html5shiv.min.js');
	wp_script_add_data( 'ct-chosen-html5-shiv', 'conditional', 'IE 8' );

	// respond.js - media query support
	wp_enqueue_script('ct-chosen-respond', get_template_directory_uri() . '/js/build/respond.min.js', '', '', true);
	wp_script_add_data( 'ct-chosen-respond', 'conditional', 'IE 8' );
}
add_action('wp_enqueue_scripts', 'ct_chosen_load_scripts_styles' );

/*
 * Back-end scripts
 */
function ct_chosen_enqueue_admin_styles($hook){

	// if is user profile page
	if('profile.php' == $hook || 'user-edit.php' == $hook ){

		// Enqueues all scripts, styles, settings, and templates necessary to use all media JavaScript APIs.
		wp_enqueue_media();

		// enqueue the JS needed to utilize media uploader on profile image upload
		wp_enqueue_script('ct-chosen-profile-image-uploader', get_template_directory_uri() . '/js/build/profile-image-uploader.min.js');
	}
	// if theme options page
	if( 'appearance_page_chosen-options' == $hook ) {

		// Admin styles
		wp_enqueue_style('ct-chosen-admin-styles', get_template_directory_uri() . '/styles/admin.min.css');
	}
}
add_action('admin_enqueue_scripts',	'ct_chosen_enqueue_admin_styles' );

/*
 * Customizer scripts
 */
function ct_chosen_enqueue_customizer_scripts(){

	// stylesheet for customizer
	wp_enqueue_style('ct-chosen-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css');

	// JS for hiding/showing Customizer options
	wp_enqueue_script('ct-chosen-customizer-js', get_template_directory_uri() . '/js/build/customizer.min.js',array('jquery'),'',true);

}
add_action('customize_controls_enqueue_scripts','ct_chosen_enqueue_customizer_scripts');

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function chosen_enqueue_customizer_post_message_scripts(){

	// JS for live updating with customizer input
	wp_enqueue_script('ct-chosen-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js',array('jquery'),'',true);

}
add_action('customize_preview_init','chosen_enqueue_customizer_post_message_scripts');