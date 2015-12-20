<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_chosen_add_customizer_content' );

function ct_chosen_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section('title_tagline')->priority = 1;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
		$wp_customize->get_section( 'static_front_page' )->title    = __( 'Front Page', 'chosen' );
	}

	/***** Add PostMessage Support *****/

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	/***** Add Custom Controls *****/

	/* Ad Controls */
	class chosen_description_control extends WP_Customize_Control {

		public function render_content() {
			echo $this->description;
		}
	}

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct_chosen_logo_upload', array(
		'title'      => __( 'Logo', 'chosen' ),
		'priority'   => 20
	) );
	// setting
	$wp_customize->add_setting( 'logo_upload', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	// control
	$wp_customize->add_control( new WP_Customize_Image_Control(
		$wp_customize, 'logo_image', array(
			'label'    => __( 'Upload custom logo.', 'chosen' ),
			'section'  => 'ct_chosen_logo_upload',
			'settings' => 'logo_upload'
		)
	) );

	/***** Social Media Icons *****/

	// get the social sites array
	$social_sites = ct_chosen_social_array();

	// set a priority used to order the social sites
	$priority = 5;

	// section
	$wp_customize->add_section( 'ct_chosen_social_media_icons', array(
		'title'       => __( 'Social Media Icons', 'chosen' ),
		'priority'    => 25,
		'description' => __( 'Add the URL for each of your social profiles.', 'chosen' )
	) );

	// create a setting and control for each social site
	foreach( $social_sites as $social_site => $value ) {
		// if email icon
		if( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_chosen_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'   => __('Email Address', 'chosen' ),
				'section' => 'ct_chosen_social_media_icons',
				'priority'=> $priority
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'google-plus' ) {
				$label = 'Google Plus';
			} elseif ( $social_site == 'rss' ) {
				$label = 'RSS';
			} elseif ( $social_site == 'soundcloud' ) {
				$label = 'SoundCloud';
			} elseif ( $social_site == 'slideshare' ) {
				$label = 'SlideShare';
			} elseif ( $social_site == 'codepen' ) {
				$label = 'CodePen';
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = 'StumbleUpon';
			} elseif ( $social_site == 'deviantart' ) {
				$label = 'DeviantArt';
			} elseif ( $social_site == 'hacker-news' ) {
				$label = 'Hacker News';
			} elseif ( $social_site == 'whatsapp' ) {
				$label = 'WhatsApp';
			} elseif ( $social_site == 'qq' ) {
				$label = 'QQ';
			} elseif ( $social_site == 'vk' ) {
				$label = 'VK';
			} elseif ( $social_site == 'wechat' ) {
				$label = 'WeChat';
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = 'Tencent Weibo';
			} elseif ( $social_site == 'paypal' ) {
				$label = 'PayPal';
			}
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'esc_url_raw'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'type' => 'url',
				'label'    => $label,
				'section'  => 'ct_chosen_social_media_icons',
				'priority' => $priority
			) );
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'chosen_blog', array(
		'title'      => __( 'Blog', 'chosen' ),
		'priority'   => 45
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'          => __( 'Show full posts on blog?', 'chosen' ),
		'section'        => 'chosen_blog',
		'settings'       => 'full_post',
		'type'           => 'radio',
		'choices'        => array(
			'yes' => __('Yes', 'chosen'),
			'no'  => __('No', 'chosen')
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'          => __( 'Excerpt word count', 'chosen' ),
		'section'        => 'chosen_blog',
		'settings'       => 'excerpt_length',
		'type'           => 'number'
	) );
	// Read More text - setting
	$wp_customize->add_setting( 'read_more_text', array(
		'default'           => __( 'Continue Reading', 'chosen' ),
		'sanitize_callback' => 'ct_chosen_sanitize_text'
	) );
	// Read More text - control
	$wp_customize->add_control( 'read_more_text', array(
		'label'    => __( 'Read More button text', 'chosen' ),
		'section'  => 'chosen_blog',
		'settings' => 'read_more_text',
		'type'     => 'text'
	) );

	/***** Additional Options *****/

	// section
	$wp_customize->add_section( 'chosen_additional', array(
		'title'      => __( 'Additional Options', 'chosen' ),
		'priority'   => 70
	) );
	// extra-wide post - setting
	$wp_customize->add_setting( 'full_width_post', array(
		'default'           => 'yes',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings'
	) );
	// extra-wide post - control
	$wp_customize->add_control( 'full_width_post', array(
		'label'    => __( 'Make first post on blog extra wide?', 'chosen' ),
		'section'  => 'chosen_additional',
		'settings' => 'full_width_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __('Yes', 'chosen'),
			'no'  => __('No', 'chosen')
		)
	) );
	// author byline - setting
	$wp_customize->add_setting( 'author_byline', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings'
	) );
	// author byline - control
	$wp_customize->add_control( 'author_byline', array(
		'label'    => __( 'Display post author name in byline?', 'chosen' ),
		'section'  => 'chosen_additional',
		'settings' => 'author_byline',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __('Yes', 'chosen'),
			'no'  => __('No', 'chosen')
		)
	) );

	/***** Custom CSS *****/

	// section
	$wp_customize->add_section( 'chosen_custom_css', array(
		'title'      => __( 'Custom CSS', 'chosen' ),
		'priority'   => 75
	) );
	// setting
	$wp_customize->add_setting( 'custom_css', array(
		'sanitize_callback' => 'wp_filter_nohtml_kses'
	) );
	// control
	$wp_customize->add_control( 'custom_css', array(
		'type'     => 'textarea',
		'label'    => __( 'Add Custom CSS Here:', 'chosen' ),
		'section'  => 'chosen_custom_css',
		'settings' => 'custom_css'
	) );

	/*
	 * PRO only sections
	 */

	/***** Header Image *****/

	// section
	$wp_customize->add_section( 'chosen_header_image', array(
		'title'      => __( 'Header Image', 'chosen' ),
		'priority'   => 35
	) );
	// setting
	$wp_customize->add_setting( 'header_image_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_control(
		$wp_customize, 'header_image_ad', array(
			'section'        => 'chosen_header_image',
			'settings'       => 'header_image_ad',
			'description' => sprintf( __('Activate the <a target="_blank" href="%s">Chosen Pro Plugin</a> for advanced header image functionality.', 'chosen'), 'https://www.competethemes.com/chosen-pro/' )
		)
	) );

	/***** Colors *****/

	// section
	$wp_customize->add_section( 'chosen_colors', array(
		'title'      => __( 'Colors', 'chosen' ),
		'priority'   => 50
	) );
	// setting
	$wp_customize->add_setting( 'colors_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_control(
		$wp_customize, 'colors_ad', array(
			'section'        => 'chosen_colors',
			'settings'       => 'colors_ad',
			'description' => sprintf( __('Activate the <a target="_blank" href="%s">Chosen Pro Plugin</a> to change your colors.', 'chosen'), 'https://www.competethemes.com/chosen-pro/' )
		)
	) );

	/***** Fonts *****/

	// section
	$wp_customize->add_section( 'chosen_font', array(
		'title'      => __( 'Font', 'chosen' ),
		'priority'   => 40
	) );
	// setting
	$wp_customize->add_setting( 'font_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_control(
		$wp_customize, 'font_ad', array(
			'section'        => 'chosen_font',
			'settings'       => 'font_ad',
			'description' => sprintf( __('Activate the <a target="_blank" href="%s">Chosen Pro Plugin</a> to change your font.', 'chosen'), 'https://www.competethemes.com/chosen-pro/' )
		)
	) );

	/***** Display Control *****/

	// section
	$wp_customize->add_section( 'chosen_display_control', array(
		'title'      => __( 'Display Controls', 'chosen' ),
		'priority'   => 70
	) );
	// setting
	$wp_customize->add_setting( 'display_control_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_control(
		$wp_customize, 'display_control_ad', array(
			'section'        => 'chosen_display_control',
			'settings'       => 'display_control_ad',
			'description' => sprintf( __('Activate the <a target="_blank" href="%s">Chosen Pro Plugin</a> to get hide/show controls.', 'chosen'), 'https://www.competethemes.com/chosen-pro/' )
		)
	) );

	/***** Footer Text *****/

	// section
	$wp_customize->add_section( 'chosen_footer_text', array(
		'title'      => __( 'Footer Text', 'chosen' ),
		'priority'   => 85
	) );
	// setting
	$wp_customize->add_setting( 'footer_text_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_control(
		$wp_customize, 'footer_text_ad', array(
			'section'        => 'chosen_footer_text',
			'settings'       => 'footer_text_ad',
			'description' => sprintf( __('Activate the <a target="_blank" href="%s">Chosen Pro Plugin</a> to customize the footer text.', 'chosen'), 'https://www.competethemes.com/chosen-pro/' )
		)
	) );

	/***** Layout *****/

	// section
	$wp_customize->add_section( 'chosen_layout', array(
		'title'      => __( 'Layout', 'chosen' ),
		'priority'   => 47
	) );
	// setting
	$wp_customize->add_setting( 'layout_text_ad', array(
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_control(
		$wp_customize, 'layout_ad', array(
			'section'        => 'chosen_layout',
			'settings'       => 'layout_text_ad',
			'description' => sprintf( __('Activate the <a target="_blank" href="%s">Chosen Pro Plugin</a> to change your layout.', 'chosen'), 'https://www.competethemes.com/chosen-pro/' )
		)
	) );
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_chosen_sanitize_all_show_hide_settings($input){

	$valid = array(
		'show' => __('Show', 'chosen'),
		'hide' => __('Hide', 'chosen')
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_chosen_sanitize_email( $input ) {
	return sanitize_email( $input );
}

// sanitize yes/no settings
function ct_chosen_sanitize_yes_no_settings($input){

	$valid = array(
		'yes' => __('Yes', 'chosen'),
		'no'  => __('No', 'chosen'),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

function ct_chosen_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

/***** Helper Functions *****/

function ct_chosen_customize_preview_js() {

	$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"https://www.competethemes.com/chosen-pro/\" target=\"_blank\">" . __('View the Chosen Pro Plugin', 'chosen') . " <span>&rarr;</span></a></div>')</script>";
	echo apply_filters('ct_chosen_customizer_ad', $content);
}
add_action('customize_controls_print_footer_scripts', 'ct_chosen_customize_preview_js');