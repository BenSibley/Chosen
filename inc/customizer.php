<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_chosen_add_customizer_content' );

function ct_chosen_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section( 'title_tagline' )->priority = 2;

	// check if exists in case user has no pages
	if ( is_object( $wp_customize->get_section( 'static_front_page' ) ) ) {
		$wp_customize->get_section( 'static_front_page' )->priority = 5;
	}

	/***** Add PostMessage Support *****/

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct_chosen_logo_upload', array(
		'title'    => __( 'Logo', 'chosen' ),
		'priority' => 20
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
	foreach ( $social_sites as $social_site => $value ) {
		// if email icon
		if ( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_chosen_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Email Address', 'chosen' ),
				'section'  => 'ct_chosen_social_media_icons',
				'priority' => $priority
			) );
		} else if ( $social_site == 'phone' ) {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'sanitize_callback' => 'ct_chosen_sanitize_phone'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'    => __( 'Phone', 'chosen' ),
				'section'     => 'ct_chosen_social_media_icons',
				'priority'    => $priority,
				'type'        => 'text'
			) );
		} else {

			$label = ucfirst( $social_site );

			if ( $social_site == 'rss' ) {
				$label = __('RSS', 'chosen');
			} elseif ( $social_site == 'imdb' ) {
				$label = __('IMDB', 'chosen');
			} elseif ( $social_site == 'diaspora' ) {
				$label = __('diaspora*', 'chosen');
			} elseif ( $social_site == 'researchgate' ) {
				$label = __('ResearchGate', 'chosen');
			} elseif ( $social_site == 'soundcloud' ) {
				$label = __('SoundCloud', 'chosen');
			} elseif ( $social_site == 'slideshare' ) {
				$label = __('SlideShare', 'chosen');
			} elseif ( $social_site == 'codepen' ) {
				$label = __('CodePen', 'chosen');
			} elseif ( $social_site == 'stumbleupon' ) {
				$label = __('StumbleUpon', 'chosen');
			} elseif ( $social_site == 'deviantart' ) {
				$label = __('DeviantArt', 'chosen');
			} elseif ( $social_site == 'hacker-news' ) {
				$label = __('Hacker News', 'chosen');
			} elseif ( $social_site == 'google-wallet' ) {
				$label = __('Google Wallet', 'chosen');
			} elseif ( $social_site == 'whatsapp' ) {
				$label = __('WhatsApp', 'chosen');
			} elseif ( $social_site == 'qq' ) {
				$label = __('QQ', 'chosen');
			} elseif ( $social_site == 'vk' ) {
				$label = __('VK', 'chosen');
			} elseif ( $social_site == 'wechat' ) {
				$label = __('WeChat', 'chosen');
			} elseif ( $social_site == 'tencent-weibo' ) {
				$label = __('Tencent Weibo', 'chosen');
			} elseif ( $social_site == 'paypal' ) {
				$label = __('PayPal', 'chosen');
			} elseif ( $social_site == 'email-form' ) {
				$label = __('Contact Form', 'chosen');
			} elseif ( $social_site == 'ok-ru' ) {
				$label = __('OK.ru', 'chosen');
			} elseif ( $social_site == 'stack-overflow' ) {
				$label = __('Stack Overflow', 'chosen');
			} elseif ( $social_site == 'artstation' ) {
				$label = __('ArtStation', 'chosen');
			}

			if ( $social_site == 'skype' ) {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'ct_chosen_sanitize_skype'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'        => 'url',
					'label'       => $label,
					'description' => sprintf( __( 'Accepts Skype link protocol (<a href="%s" target="_blank">learn more</a>)', 'chosen' ), 'https://www.competethemes.com/blog/skype-links-wordpress/' ),
					'section'     => 'ct_chosen_social_media_icons',
					'priority'    => $priority
				) );
			} else {
				// setting
				$wp_customize->add_setting( $social_site, array(
					'sanitize_callback' => 'esc_url_raw'
				) );
				// control
				$wp_customize->add_control( $social_site, array(
					'type'     => 'url',
					'label'    => $label,
					'section'  => 'ct_chosen_social_media_icons',
					'priority' => $priority
				) );
			}
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}
	// Custom icon 1
	$wp_customize->add_setting( 'social_icon_custom_1_name', array(
		'sanitize_callback' => 'ct_chosen_sanitize_text'
	) );
	$wp_customize->add_control( 'social_icon_custom_1_name', array(
		'label'    => __('Custom icon 1 Name', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_1_name',
		'type'     => 'text',
		'priority' => $priority + 5
	) );
	$wp_customize->add_setting( 'social_icon_custom_1', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( 'social_icon_custom_1', array(
		'label'    => __('Custom icon 1 URL', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_1',
		'type'     => 'url',
		'priority' => $priority + 6
	) );
	$wp_customize->add_setting( 'social_icon_custom_1_image', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'social_icon_custom_1_image', array(
		'label'    => __( 'Custom icon 1 image', 'chosen' ),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_1_image',
		'priority' => $priority + 7
	)));
	$wp_customize->add_setting( 'social_icon_custom_1_size', array(
		'default'			=> '20',
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'social_icon_custom_1_size', array(
		'label'    => __('Custom icon 1 size (px)', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_1_size',
		'type'     => 'number',
		'priority' => $priority + 8
	) );
	// Custom icon 2
	$wp_customize->add_setting( 'social_icon_custom_2_name', array(
		'sanitize_callback' => 'ct_chosen_sanitize_text'
	) );
	$wp_customize->add_control( 'social_icon_custom_2_name', array(
		'label'    => __('Custom icon 2 Name', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_2_name',
		'type'     => 'text',
		'priority' => $priority + 9
	) );
	$wp_customize->add_setting( 'social_icon_custom_2', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( 'social_icon_custom_2', array(
		'label'    => __('Custom icon 2 URL', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_2',
		'type'     => 'url',
		'priority' => $priority + 10
	) );
	$wp_customize->add_setting( 'social_icon_custom_2_image', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'social_icon_custom_2_image', array(
		'label'    => __( 'Custom icon 2 image', 'chosen' ),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_2_image',
		'priority' => $priority + 11
	)));
	$wp_customize->add_setting( 'social_icon_custom_2_size', array(
		'default'			=> '20',
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'social_icon_custom_2_size', array(
		'label'    => __('Custom icon 2 size (px)', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_2_size',
		'type'     => 'number',
		'priority' => $priority + 12
	) );
	// Custom icon 3
	$wp_customize->add_setting( 'social_icon_custom_3_name', array(
		'sanitize_callback' => 'ct_chosen_sanitize_text'
	) );
	$wp_customize->add_control( 'social_icon_custom_3_name', array(
		'label'    => __('Custom icon 3 Name', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_3_name',
		'type'     => 'text',
		'priority' => $priority + 13
	) );
	$wp_customize->add_setting( 'social_icon_custom_3', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control( 'social_icon_custom_3', array(
		'label'    => __('Custom icon 3 URL', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_3',
		'type'     => 'url',
		'priority' => $priority + 14
	) );
	$wp_customize->add_setting( 'social_icon_custom_3_image', array(
		'sanitize_callback' => 'esc_url_raw'
	) );
	$wp_customize->add_control(new WP_Customize_Image_Control( $wp_customize, 'social_icon_custom_3_image', array(
		'label'    => __( 'Custom icon 3 image', 'chosen' ),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_3_image',
		'priority' => $priority + 15
	)));
	$wp_customize->add_setting( 'social_icon_custom_3_size', array(
		'default'			=> '20',
		'sanitize_callback' => 'absint'
	) );
	$wp_customize->add_control( 'social_icon_custom_3_size', array(
		'label'    => __('Custom icon 3 size (px)', 'chosen'),
		'section'  => 'ct_chosen_social_media_icons',
		'settings' => 'social_icon_custom_3_size',
		'type'     => 'number',
		'priority' => $priority + 16
	) );

	/***** Search Bar *****/

	// section
	$wp_customize->add_section( 'chosen_search_bar', array(
		'title'    => __( 'Search Bar', 'chosen' ),
		'priority' => 37
	) );
	// setting
	$wp_customize->add_setting( 'search_bar', array(
		'default'           => 'hide',
		'sanitize_callback' => 'ct_chosen_sanitize_all_show_hide_settings'
	) );
	// control
	$wp_customize->add_control( 'search_bar', array(
		'type'    => 'radio',
		'label'   => __( 'Show search bar at top of site?', 'chosen' ),
		'section' => 'chosen_search_bar',
		'setting' => 'search_bar',
		'choices' => array(
			'show' => __( 'Show', 'chosen' ),
			'hide' => __( 'Hide', 'chosen' )
		),
	) );

	/***** Search Bar *****/

	// section
	$wp_customize->add_section( 'chosen_search_bar', array(
		'title'    => __( 'Search Bar', 'chosen' ),
		'priority' => 37
	) );
	// setting
	$wp_customize->add_setting( 'search_bar', array(
		'default'           => 'hide',
		'sanitize_callback' => 'ct_chosen_sanitize_all_show_hide_settings'
	) );
	// control
	$wp_customize->add_control( 'search_bar', array(
		'type'    => 'radio',
		'label'   => __( 'Show search bar at top of site?', 'chosen' ),
		'section' => 'chosen_search_bar',
		'setting' => 'search_bar',
		'choices' => array(
			'show' => __( 'Show', 'chosen' ),
			'hide' => __( 'Hide', 'chosen' )
		),
	) );

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'chosen_blog', array(
		'title'    => _x( 'Blog', 'noun: the blog section', 'chosen' ),
		'priority' => 45
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings'
	) );
	// control
	$wp_customize->add_control( 'full_post', array(
		'label'    => __( 'Show full posts on blog?', 'chosen' ),
		'section'  => 'chosen_blog',
		'settings' => 'full_post',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'chosen' ),
			'no'  => __( 'No', 'chosen' )
		)
	) );
	// setting
	$wp_customize->add_setting( 'excerpt_length', array(
		'default'           => '25',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( 'excerpt_length', array(
		'label'    => __( 'Excerpt word count', 'chosen' ),
		'section'  => 'chosen_blog',
		'settings' => 'excerpt_length',
		'type'     => 'number'
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
		'title'    => __( 'Additional Options', 'chosen' ),
		'priority' => 70
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
			'yes' => __( 'Yes', 'chosen' ),
			'no'  => __( 'No', 'chosen' )
		)
	) );
	// post title above/below FI - setting
	$wp_customize->add_setting( 'post_title_position', array(
		'default'           => 'below',
		'sanitize_callback' => 'ct_chosen_sanitize_post_title_position_setting'
	) );
	// post title above/below FI - control
	$wp_customize->add_control( 'post_title_position', array(
		'label'    => __( 'Display post titles above or below Feature Images?', 'chosen' ),
		'section'  => 'chosen_additional',
		'settings' => 'post_title_position',
		'type'     => 'radio',
		'choices'  => array(
			'above'  => __( 'Above Featured Image', 'chosen' ),
			'below' => __( 'Below Featured Image', 'chosen' )
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
			'yes' => __( 'Yes', 'chosen' ),
			'no'  => __( 'No', 'chosen' )
		)
	) );
	// setting - scroll-to-top arrow
	$wp_customize->add_setting( 'scroll_to_top', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings'
	) );
	// control - scroll-to-top arrow
	$wp_customize->add_control( 'scroll_to_top', array(
		'label'    => __( 'Display Scroll-to-top arrow?', 'chosen' ),
		'section'  => 'chosen_additional',
		'settings' => 'scroll_to_top',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'chosen' ),
			'no'  => __( 'No', 'chosen' )
		)
	) );
	// setting - last updated
	$wp_customize->add_setting( 'last_updated', array(
		'default'           => 'no',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings'
	) );
	// control - last updated
	$wp_customize->add_control( 'last_updated', array(
		'label'    => __( 'Display the date each post was last updated?', 'chosen' ),
		'section'  => 'chosen_additional',
		'settings' => 'last_updated',
		'type'     => 'radio',
		'choices'  => array(
			'yes' => __( 'Yes', 'chosen' ),
			'no'  => __( 'No', 'chosen' )
		)
	) );

	/***** Custom CSS *****/

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
		// Migrate any existing theme CSS to the core option added in WordPress 4.7.
		$css = get_theme_mod( 'custom_css' );
		if ( $css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return = wp_update_custom_css_post( $core_css . $css );
			if ( ! is_wp_error( $return ) ) {
				// Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
				remove_theme_mod( 'custom_css' );
			}
		}
	} else {
		// section
		$wp_customize->add_section( 'chosen_custom_css', array(
			'title'    => __( 'Custom CSS', 'chosen' ),
			'priority' => 75
		) );
		// setting
		$wp_customize->add_setting( 'custom_css', array(
			'sanitize_callback' => 'ct_chosen_sanitize_css',
			'transport'         => 'postMessage'
		) );
		// control
		$wp_customize->add_control( 'custom_css', array(
			'type'     => 'textarea',
			'label'    => __( 'Add Custom CSS Here:', 'chosen' ),
			'section'  => 'chosen_custom_css',
			'settings' => 'custom_css'
		) );
	}
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_chosen_sanitize_all_show_hide_settings( $input ) {

	$valid = array(
		'show' => __( 'Show', 'chosen' ),
		'hide' => __( 'Hide', 'chosen' )
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
function ct_chosen_sanitize_yes_no_settings( $input ) {

	$valid = array(
		'yes' => __( 'Yes', 'chosen' ),
		'no'  => __( 'No', 'chosen' ),
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_chosen_sanitize_text( $input ) {
	return wp_kses_post( force_balance_tags( $input ) );
}

function ct_chosen_sanitize_skype( $input ) {
	return esc_url_raw( $input, array( 'http', 'https', 'skype' ) );
}

function ct_chosen_sanitize_css( $css ) {
	$css = wp_kses( $css, array( '\'', '\"' ) );
	$css = str_replace( '&gt;', '>', $css );

	return $css;
}

function ct_chosen_sanitize_phone( $input ) {
	if ( $input != '' ) {
		return esc_url_raw( 'tel:' . $input, array( 'tel' ) );
	} else {
		return '';
	}
}

function ct_chosen_sanitize_post_title_position_setting($input) {
	
	$valid = array(
		'above'  => __( 'Above Featured Image', 'chosen' ),
		'below' => __( 'Below Featured Image', 'chosen' )
	);

	return array_key_exists( $input, $valid ) ? $input : '';
}

function ct_chosen_customize_preview_js() {
	if ( !function_exists( 'ct_chosen_pro_init' ) && !(isset($_GET['mailoptin_optin_campaign_id']) || isset($_GET['mailoptin_email_campaign_id'])) ) {
		$url = 'https://www.competethemes.com/chosen-pro/?utm_source=wp-dashboard&utm_medium=Customizer&utm_campaign=Chosen%20Pro%20-%20Customizer';
		$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"". $url ."\" target=\"_blank\">Customize Colors with Chosen Pro <span>&rarr;</span></a></div>')</script>";
		echo apply_filters('ct_chosen_customizer_ad', $content);
	}
}
add_action('customize_controls_print_footer_scripts', 'ct_chosen_customize_preview_js');