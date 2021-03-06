<?php

// Front-end scripts
function ct_chosen_load_scripts_styles() {

	$font_args = array(
		'family' 	=> urlencode( 'Playfair Display:400|Raleway:400,700,400i' ),
		'subset' 	=> urlencode( 'latin,latin-ext' ),
		'display' => 'swap'
	);
	$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );

	wp_enqueue_style( 'ct-chosen-google-fonts', $fonts_url );

	wp_enqueue_script( 'ct-chosen-js', get_template_directory_uri() . '/js/build/production.min.js', array( 'jquery' ), '', true );
	wp_localize_script( 'ct-chosen-js', 'ct_chosen_objectL10n', array(
		'openMenu'       => esc_html_x( 'open menu', 'verb: open the menu', 'chosen' ),
		'closeMenu'      => esc_html_x( 'close menu', 'verb: close the menu', 'chosen' ),
		'openChildMenu'  => esc_html_x( 'open dropdown menu', 'verb: open the dropdown menu', 'chosen' ),
		'closeChildMenu' => esc_html_x( 'close dropdown menu', 'verb: close the dropdown menu', 'chosen' )
	) );

	wp_enqueue_style( 'ct-chosen-font-awesome', get_template_directory_uri() . '/assets/font-awesome/css/all.min.css' );

	wp_enqueue_style( 'ct-chosen-style', get_stylesheet_uri() );

	// enqueue comment-reply script only on posts & pages with comments open ( included in WP core )
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/* Load Polyfills */

	wp_enqueue_script( 'ct-chosen-html5-shiv', get_template_directory_uri() . '/js/build/html5shiv.min.js' );

	wp_enqueue_script( 'ct-chosen-respond', get_template_directory_uri() . '/js/build/respond.min.js', '', '', true );

	// prevent fatal error on < WP 4.2 (load files unconditionally instead)
	if ( function_exists( 'wp_script_add_data' ) ) {
		wp_script_add_data( 'ct-chosen-html5-shiv', 'conditional', 'IE 8' );
		wp_script_add_data( 'ct-chosen-respond', 'conditional', 'IE 8' );
	}
}
add_action( 'wp_enqueue_scripts', 'ct_chosen_load_scripts_styles' );

// Back-end scripts
function ct_chosen_enqueue_admin_styles( $hook ) {

	if ( $hook == 'appearance_page_chosen-options' ) {
		wp_enqueue_style( 'ct-chosen-admin-styles', get_template_directory_uri() . '/styles/admin.min.css' );
	}
	if ( $hook == 'post.php' || $hook == 'post-new.php' ) {

		$font_args = array(
			'family' => urlencode( 'Playfair Display:400|Raleway:400,700,400italic' ),
			'subset' => urlencode( 'latin,latin-ext' )
		);
		$fonts_url = add_query_arg( $font_args, '//fonts.googleapis.com/css' );
	
		wp_enqueue_style( 'ct-chosen-google-fonts', $fonts_url );
	}
}
add_action( 'admin_enqueue_scripts', 'ct_chosen_enqueue_admin_styles' );

// Customizer scripts
function ct_chosen_enqueue_customizer_scripts() {
	wp_enqueue_style( 'ct-chosen-customizer-styles', get_template_directory_uri() . '/styles/customizer.min.css' );
}
add_action( 'customize_controls_enqueue_scripts', 'ct_chosen_enqueue_customizer_scripts' );

/*
 * Script for live updating with customizer options. Has to be loaded separately on customize_preview_init hook
 * transport => postMessage
 */
function ct_chosen_enqueue_customizer_post_message_scripts() {
	wp_enqueue_script( 'ct-chosen-customizer-post-message-js', get_template_directory_uri() . '/js/build/postMessage.min.js', array( 'jquery' ), '', true );

}
add_action( 'customize_preview_init', 'ct_chosen_enqueue_customizer_post_message_scripts' );