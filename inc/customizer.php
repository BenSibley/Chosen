<?php

/* Add customizer panels, sections, settings, and controls */
add_action( 'customize_register', 'ct_chosen_add_customizer_content' );

function ct_chosen_add_customizer_content( $wp_customize ) {

	/***** Reorder default sections *****/

	$wp_customize->get_section('title_tagline')->priority     = 1;
	$wp_customize->get_section('static_front_page')->priority = 5;
	$wp_customize->get_section('static_front_page')->title    = __('Front Page', 'chosen');
	$wp_customize->get_section('nav')->priority               = 10;
	$wp_customize->get_section('nav')->title                  = __('Menus', 'chosen');

	/***** Add PostMessage Support *****/
	
	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	/***** Add Custom Controls *****/

	// create url input control
	class ct_chosen_url_input_control extends WP_Customize_Control {
		// create new type called 'url'
		public $type = 'url';
		// the content to be output in the Customizer
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="url" <?php $this->link(); ?> value="<?php echo esc_url_raw( $this->value() ); ?>" />
			</label>
		<?php
		}
	}

	// number input control
	class ct_chosen_number_input_control extends WP_Customize_Control {
		public $type = 'number';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="number" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
			</label>
		<?php
		}
	}

	// create multi-checkbox/select control
	class ct_chosen_multi_checkbox_control extends WP_Customize_Control {
		public $type = 'multi-checkbox';

		public function render_content() {

			if ( empty( $this->choices ) )
				return;
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<select id="comment-display-control" <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
					<?php
					foreach ( $this->choices as $value => $label ) {
						$selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
						echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
					}
					?>
				</select>
			</label>
		<?php }
	}

	// create textarea control
	class ct_chosen_textarea_control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="8" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php
		}
	}

	/* Ad Controls */
	class chosen_description_header_image_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/chosen-pro/';
			echo "<p>" . sprintf( __('Activate <a target="_blank" href="%s">Chosen Pro</a> for advanced header image functionality.', 'chosen'), $link ) . "</p>";
		}
	}
	class chosen_description_color_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/chosen-pro/';
			echo "<p>" . sprintf( __('Activate <a target="_blank" href="%s">Chosen Pro</a> to change your colors.', 'chosen'), $link ) . "</p>";
		}
	}
	class chosen_description_font_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/chosen-pro/';
			echo "<p>" . sprintf( __('Activate <a target="_blank" href="%s">Chosen Pro</a> to change your font.', 'chosen'), $link ) . "</p>";
		}
	}
	class chosen_description_display_control_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/chosen-pro/';
			echo "<p>" . sprintf( __('Activate <a target="_blank" href="%s">Chosen Pro</a> to get hide/show controls.', 'chosen'), $link ) . "</p>";
		}
	}
	class chosen_description_footer_text_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/chosen-pro/';
			echo "<p>" . sprintf( __('Activate <a target="_blank" href="%s">Chosen Pro</a> to customize the footer text.', 'chosen'), $link ) . "</p>";
		}
	}
	class chosen_description_layout_control extends WP_Customize_Control {

		public function render_content() {
			$link = 'https://www.competethemes.com/chosen-pro/';
			echo "<p>" . sprintf( __('Activate <a target="_blank" href="%s">Chosen Pro</a> to change your layout.', 'chosen'), $link ) . "</p>";
		}
	}

	/***** Logo Upload *****/

	// section
	$wp_customize->add_section( 'ct_chosen_logo_upload', array(
		'title'      => __( 'Logo Upload', 'chosen' ),
		'priority'   => 20,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'logo_upload', array(
		'default'           => '',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
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
		'title'    => __('Social Media Icons', 'chosen'),
		'priority' => 25
	) );

	// create a setting and control for each social site
	foreach( $social_sites as $social_site => $value ) {
		// if email icon
		if( $social_site == 'email' ) {
			// setting
			$wp_customize->add_setting( "$social_site", array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'ct_chosen_sanitize_email'
			) );
			// control
			$wp_customize->add_control( $social_site, array(
				'label'   => $social_site . ' ' . __('address:', 'chosen' ),
				'section' => 'ct_chosen_social_media_icons',
				'priority'=> $priority
			) );
		} else {
			// setting
			$wp_customize->add_setting( $social_site, array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url_raw'
			) );
			// control
			$wp_customize->add_control( new ct_chosen_url_input_control(
				$wp_customize, $social_site, array(
					'label'    => $social_site . ' ' . __('url:', 'chosen' ),
					'section'  => 'ct_chosen_social_media_icons',
					'priority' => $priority
				)
			) );
		}
		// increment the priority for next site
		$priority = $priority + 5;
	}

	/***** Blog *****/

	// section
	$wp_customize->add_section( 'chosen_blog', array(
		'title'      => __( 'Blog', 'chosen' ),
		'priority'   => 45,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'full_post', array(
		'default'           => 'no',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings',
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
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new ct_chosen_number_input_control(
		$wp_customize, 'excerpt_length', array(
			'label'          => __( 'Excerpt length', 'chosen' ),
			'section'        => 'chosen_blog',
			'settings'       => 'excerpt_length',
			'type'           => 'number'
		)
	) );

	/***** Additional Options *****/

	// section
	$wp_customize->add_section( 'chosen_additional', array(
		'title'      => __( 'Additional Options', 'chosen' ),
		'priority'   => 70,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'full_width_post', array(
		'default'           => 'yes',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ct_chosen_sanitize_yes_no_settings'
	) );
	// control
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

	/***** Custom CSS *****/

	// section
	$wp_customize->add_section( 'chosen_custom_css', array(
		'title'      => __( 'Custom CSS', 'chosen' ),
		'priority'   => 75,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'custom_css', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_filter_nohtml_kses'
	) );
	// control
	$wp_customize->add_control( new ct_chosen_textarea_control(
		$wp_customize, 'custom_css', array(
			'label'          => __( 'Add Custom CSS Here:', 'chosen' ),
			'section'        => 'chosen_custom_css',
			'settings'       => 'custom_css'
		)
	) );

	/*
	 * PRO only sections
	 */

	/***** Header Image *****/

	// section
	$wp_customize->add_section( 'chosen_header_image', array(
		'title'      => __( 'Header Image', 'chosen' ),
		'priority'   => 35,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'header_image_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_header_image_control(
		$wp_customize, 'header_image_ad', array(
			'section'        => 'chosen_header_image',
			'settings'       => 'header_image_ad'
		)
	) );

	/***** Colors *****/

	// section
	$wp_customize->add_section( 'chosen_colors', array(
		'title'      => __( 'Colors', 'chosen' ),
		'priority'   => 50,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'colors_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_color_control(
		$wp_customize, 'colors_ad', array(
			'section'        => 'chosen_colors',
			'settings'       => 'colors_ad'
		)
	) );

	/***** Fonts *****/

	// section
	$wp_customize->add_section( 'chosen_font', array(
		'title'      => __( 'Font', 'chosen' ),
		'priority'   => 40,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'font_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_font_control(
		$wp_customize, 'font_ad', array(
			'section'        => 'chosen_font',
			'settings'       => 'font_ad'
		)
	) );

	/***** Display Control *****/

	// section
	$wp_customize->add_section( 'chosen_display_control', array(
		'title'      => __( 'Display Controls', 'chosen' ),
		'priority'   => 70,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'display_control_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_display_control_control(
		$wp_customize, 'display_control_ad', array(
			'section'        => 'chosen_display_control',
			'settings'       => 'display_control_ad'
		)
	) );

	/***** Footer Text *****/

	// section
	$wp_customize->add_section( 'chosen_footer_text', array(
		'title'      => __( 'Footer Text', 'chosen' ),
		'priority'   => 85,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'footer_text_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_footer_text_control(
		$wp_customize, 'footer_text_ad', array(
			'section'        => 'chosen_footer_text',
			'settings'       => 'footer_text_ad'
		)
	) );

	/***** Layout *****/

	// section
	$wp_customize->add_section( 'chosen_layout', array(
		'title'      => __( 'Layout', 'chosen' ),
		'priority'   => 47,
		'capability' => 'edit_theme_options'
	) );
	// setting
	$wp_customize->add_setting( 'layout_text_ad', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'absint'
	) );
	// control
	$wp_customize->add_control( new chosen_description_layout_control(
		$wp_customize, 'layout_ad', array(
			'section'        => 'chosen_layout',
			'settings'       => 'layout_text_ad'
		)
	) );
}

/***** Custom Sanitization Functions *****/

/*
 * Sanitize settings with show/hide as options
 * Used in: search bar
 */
function ct_chosen_sanitize_all_show_hide_settings($input){
	// create array of valid values
	$valid = array(
		'show' => __('Show', 'chosen'),
		'hide' => __('Hide', 'chosen')
	);
	// if returned data is in array use it, else return nothing
	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/*
 * sanitize email address
 * Used in: Social Media Icons
 */
function ct_chosen_sanitize_email( $input ) {

	return sanitize_email( $input );
}

// sanitize comment display multi-check
function ct_chosen_sanitize_comments_setting($input){

	// valid data
	$valid = array(
		'post'        => __('Posts', 'chosen'),
		'page'        => __('Pages', 'chosen'),
		'attachment'  => __('Attachments', 'chosen'),
		'none'        => __('Do not show', 'chosen')
	);

	// loop through array
	foreach( $input as $selection ) {

		// if it's in the valid data, return it
		if ( array_key_exists( $selection, $valid ) ) {
			return $input;
		} else {
			return '';
		}
	}
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

/***** Helper Functions *****/

function ct_chosen_customize_preview_js() {

	$content = "<script>jQuery('#customize-info').prepend('<div class=\"upgrades-ad\"><a href=\"https://www.competethemes.com/chosen-pro/\" target=\"_blank\">View the Chosen Pro Upgrade <span>&rarr;</span></a></div>')</script>";
	echo apply_filters('ct_chosen_customizer_ad', $content);
}
add_action('customize_controls_print_footer_scripts', 'ct_chosen_customize_preview_js');