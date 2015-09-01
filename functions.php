<?php

// theme setup
if( ! function_exists( ( 'ct_chosen_theme_setup' ) ) ) {
	function ct_chosen_theme_setup() {

		// add functionality from WordPress core
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );

		// load theme options page
		require_once( trailingslashit( get_template_directory() ) . 'theme-options.php' );

		// add inc folder files
		foreach ( glob( trailingslashit( get_template_directory() ) . 'inc/*' ) as $filename ) {
			include $filename;
		}

		// load text domain
		load_theme_textdomain( 'chosen', get_template_directory() . '/languages' );

		// register Primary menu
		register_nav_menus( array(
			'primary' => __( 'Primary', 'chosen' )
		) );
	}
}
add_action( 'after_setup_theme', 'ct_chosen_theme_setup', 10 );

/* added to customize the comments. Same as default except -> added use of gravatar images for comment authors */
if( ! function_exists( ( 'ct_chosen_customize_comments' ) ) ) {
	function ct_chosen_customize_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
					echo get_avatar( get_comment_author_email(), 36, '', get_comment_author() );
				?>
				<span class="author-name"><?php comment_author_link(); ?></span>
			</div>
			<div class="comment-content">
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'chosen' ) ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<span class="comment-date"><?php comment_date(); ?></span>
				<?php comment_reply_link( array_merge( $args, array(
					'reply_text' => __( 'Reply', 'chosen' ),
					'depth'      => $depth,
					'max_depth'  => $args['max_depth']
				) ) ); ?>
				<?php edit_comment_link( __('Edit', 'chosen') ); ?>
			</div>
		</article>
	<?php
	}
}

/* added HTML5 placeholders for each default field and aria-required to required */
if( ! function_exists( 'chosen_update_fields' ) ) {
    function chosen_update_fields( $fields ) {

        // get commenter object
        $commenter = wp_get_current_commenter();

        // are name and email required?
        $req = get_option( 'require_name_email' );

        // required or optional label to be added
        if ( $req == 1 ) {
            $label = '*';
        } else {
            $label = ' ' . __("optional", "chosen");
        }

        // adds aria required tag if required
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields['author'] =
            '<p class="comment-form-author">
	            <label>' . __( "Name", "chosen" ) . $label . '</label>
	            <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['email'] =
            '<p class="comment-form-email">
	            <label>' . __( "Email", "chosen" ) . $label . '</label>
	            <input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['url'] =
            '<p class="comment-form-url">
	            <label>' . __( "Website", "chosen" ) . '</label>
	            <input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) .
            '" size="30" />
	            </p>';

        return $fields;
    }
}
add_filter('comment_form_default_fields','chosen_update_fields');

if( ! function_exists( 'chosen_update_comment_field' ) ) {
    function chosen_update_comment_field( $comment_field ) {

        $comment_field =
            '<p class="comment-form-comment">
	            <label>' . __( "Comment", "chosen" ) . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

        return $comment_field;
    }
}
add_filter('comment_form_field_comment','chosen_update_comment_field');

// remove allowed tags text after comment form
if( ! function_exists( 'ct_chosen_remove_comments_notes_after' ) ) {
	function ct_chosen_remove_comments_notes_after( $defaults ) {

		$defaults['comment_notes_after'] = '';

		return $defaults;
	}
}
add_action('comment_form_defaults', 'ct_chosen_remove_comments_notes_after');

// excerpt handling
if( ! function_exists( 'ct_chosen_excerpt' ) ) {
	function ct_chosen_excerpt() {

		// make post variable available
		global $post;

		// check for the more tag
		$ismore = strpos( $post->post_content, '<!--more-->' );

		// get the show full post setting
		$show_full_post = get_theme_mod( 'full_post' );

		// if show full post is on and not on a search results page
		if ( ( $show_full_post == 'yes' ) && ! is_search() ) {

			// use the read more link if present
			if ( $ismore ) {
				the_content( __( 'Continue reading', 'chosen' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
			} else {
				the_content();
			}
		}
		// use the read more link if present
		elseif ( $ismore ) {
			the_content( __( 'Continue reading', 'chosen' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span>" );
		} // otherwise the excerpt is automatic, so output it
		else {
			the_excerpt();
		}
	}
}

// filter the link on excerpts
if( ! function_exists( 'ct_chosen_excerpt_read_more_link' ) ) {
	function ct_chosen_excerpt_read_more_link( $output ) {
		global $post;

		return $output . "<p><a class='more-link' href='" . get_permalink() . "'>" . __( 'Continue reading', 'chosen' ) . " <span class='screen-reader-text'>" . get_the_title() . "</span></a></p>";
	}
}
add_filter('the_excerpt', 'ct_chosen_excerpt_read_more_link');

// change the length of the excerpts
if( ! function_exists( 'chosen_custom_excerpt_length' ) ) {
	function chosen_custom_excerpt_length( $length ) {

		$new_excerpt_length = get_theme_mod('excerpt_length');

		// if there is a new length set and it's not 15, change it
		if( ! empty( $new_excerpt_length ) && $new_excerpt_length != 25 ){
			return $new_excerpt_length;
		} // return 0 if user explicitly sets it to 0
		elseif ( $new_excerpt_length === 0 ) {
			return 0;
		}
		else {
			return 25;
		}
	}
}
add_filter( 'excerpt_length', 'chosen_custom_excerpt_length', 99 );

// switch [...] to ellipsis on automatic excerpt
if( ! function_exists( 'ct_chosen_new_excerpt_more' ) ) {
	function ct_chosen_new_excerpt_more( $more ) {

		// get user set excerpt length
		$new_excerpt_length = get_theme_mod('excerpt_length');

		// if set to 0, return nothing
		if ( $new_excerpt_length === 0 ) {
			return '';
		}
		// else add the ellipsis
		else {
			return '&#8230;';
		}
	}
}
add_filter('excerpt_more', 'ct_chosen_new_excerpt_more');

// turns of the automatic scrolling to the read more link
if( ! function_exists( 'ct_chosen_remove_more_link_scroll' ) ) {
	function ct_chosen_remove_more_link_scroll( $link ) {
		$link = preg_replace( '|#more-[0-9]+|', '', $link );

		return $link;
	}
}
add_filter( 'the_content_more_link', 'ct_chosen_remove_more_link_scroll' );

// for displaying featured images
if( ! function_exists( 'ct_chosen_featured_image' ) ) {
	function ct_chosen_featured_image() {

		// get post object
		global $post;

		// default to no featured image
		$has_image = false;

		// establish featured image var
		$featured_image = '';

		// if post has an image
		if ( has_post_thumbnail( $post->ID ) ) {

			// get the featured image ID
			$image_id = get_post_thumbnail_id( $post->ID );

			// get the image's alt text
			$image_alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

			// get the full-size version of the image
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

			// set $image = the url
			$image = $image[0];

			// if alt text is empty, nothing else equal to title string
			$title = empty($image_alt_text) ? '' : "title='" . esc_attr( $image_alt_text ) . "'";

			// set to true
			$has_image = true;
		}
		if ( $has_image == true ) {

			// on posts/pages display the featured image
			if ( is_singular() ) {
				$featured_image = "<div class='featured-image' style=\"background-image: url('" . esc_url( $image ) . "')\" " . $title . "></div>";
			} // on blog/archives display with a link
			else {
				$featured_image = "
                <div class='featured-image' style=\"background-image: url('" . esc_url( $image ) . "')\" " . $title . ">
                    <a href='" . get_permalink() . "'>" . get_the_title() . "</a>
                </div>
                ";
			}
		}

		// allow videos to be added
		$featured_image = apply_filters( 'ct_chosen_featured_image', $featured_image );

		if( $featured_image ) {
			echo $featured_image;
		}
	}
}

// associative array of social media sites
if ( !function_exists( 'ct_chosen_social_array' ) ) {
	function ct_chosen_social_array() {

		$social_sites = array(
			'twitter'       => 'chosen_twitter_profile',
			'facebook'      => 'chosen_facebook_profile',
			'google-plus'   => 'chosen_googleplus_profile',
			'pinterest'     => 'chosen_pinterest_profile',
			'linkedin'      => 'chosen_linkedin_profile',
			'youtube'       => 'chosen_youtube_profile',
			'vimeo'         => 'chosen_vimeo_profile',
			'tumblr'        => 'chosen_tumblr_profile',
			'instagram'     => 'chosen_instagram_profile',
			'flickr'        => 'chosen_flickr_profile',
			'dribbble'      => 'chosen_dribbble_profile',
			'rss'           => 'chosen_rss_profile',
			'reddit'        => 'chosen_reddit_profile',
			'soundcloud'    => 'chosen_soundcloud_profile',
			'spotify'       => 'chosen_spotify_profile',
			'vine'          => 'chosen_vine_profile',
			'yahoo'         => 'chosen_yahoo_profile',
			'behance'       => 'chosen_behance_profile',
			'codepen'       => 'chosen_codepen_profile',
			'delicious'     => 'chosen_delicious_profile',
			'stumbleupon'   => 'chosen_stumbleupon_profile',
			'deviantart'    => 'chosen_deviantart_profile',
			'digg'          => 'chosen_digg_profile',
			'git'           => 'chosen_git_profile',
			'hacker-news'   => 'chosen_hacker-news_profile',
			'steam'         => 'chosen_steam_profile',
			'vk'            => 'chosen_vk_profile',
			'weibo'         => 'chosen_weibo_profile',
			'tencent-weibo' => 'chosen_tencent_weibo_profile',
			'email'         => 'chosen_email_profile'
		);

		return apply_filters( 'ct_chosen_social_array_filter', $social_sites );
	}
}

// used in ct_chosen_social_icons_output to return urls
function ct_chosen_get_social_url($source, $site){

    if( $source == 'header' ) {
        return get_theme_mod($site);
    } elseif( $source == 'author' ) {
        return get_the_author_meta($site);
    }
}

// output social icons
if( ! function_exists('ct_chosen_social_icons_output') ) {
    function ct_chosen_social_icons_output($source) {

        // get social sites array
        $social_sites = ct_chosen_social_array();

        // store the site name and url
        foreach ( $social_sites as $social_site => $profile ) {

            if( $source == 'header') {

                if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
                    $active_sites[$social_site] = $social_site;
                }
            }
            elseif( $source == 'author' ) {

                if ( strlen( get_the_author_meta( $profile ) ) > 0 ) {
                    $active_sites[$profile] = $social_site;
                }
            }
        }

        // for each active social site, add it as a list item
        if ( ! empty( $active_sites ) ) {

            echo "<ul class='social-media-icons'>";

            foreach ( $active_sites as $key => $active_site ) {

	            if ( $active_site == 'email' ) {
		            ?>
		            <li>
			            <a class="email" target="_blank" href="mailto:<?php echo antispambot( is_email( ct_chosen_get_social_url( $source, $key ) ) ); ?>">
				            <i class="fa fa-envelope" title="<?php _e('email icon', 'chosen'); ?>"></i>
			            </a>
		            </li>
	            <?php } else { ?>
		            <li>
			            <a class="<?php echo esc_attr( $active_site ); ?>" target="_blank" href="<?php echo esc_url( ct_chosen_get_social_url( $source, $key ) ); ?>">
				            <i class="fa fa-<?php echo esc_attr( $active_site ); ?>" title="<?php printf( __('%s icon', 'chosen'), $active_site ); ?>"></i>
			            </a>
		            </li>
	            <?php
	            }
            }
            echo "</ul>";
        }
    }
}

/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling difficult and confusing. Using this wrapper to add a unique class to make styling easier.
 */
function ct_chosen_wp_page_menu() {
    wp_page_menu(array(
            "menu_class" => "menu-unset",
            "depth"      => -1
        )
    );
}

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function chosen_add_title_tag() {
        ?>
        <title><?php wp_title( ' | ' ); ?></title>
    <?php
    }
    add_action( 'wp_head', 'chosen_add_title_tag' );
endif;

function ct_chosen_nav_dropdown_buttons( $item_output, $item, $depth, $args ) {

	if ( 'primary' == $args->theme_location) {

		if( in_array('menu-item-has-children', $item->classes ) || in_array('page_item_has_children', $item->classes ) ) {
			$item_output = str_replace( $args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><span class="screen-reader-text">' . __("open menu", "chosen") . '</span></button>', $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'ct_chosen_nav_dropdown_buttons', 10, 4 );

function ct_chosen_sticky_post_marker() {

	if( is_sticky() && !is_archive() ) {
		echo '<div class="sticky-status"><span>' . __("Featured Post", "chosen") . '</span></div>';
	}
}
add_action( 'sticky_post_status', 'ct_chosen_sticky_post_marker' );

function ct_chosen_reset_customizer_options() {

	// validate name and value
	if( empty( $_POST['chosen_reset_customizer'] ) || 'chosen_reset_customizer_settings' !== $_POST['chosen_reset_customizer'] )
		return;

	// validate nonce
	if( ! wp_verify_nonce( $_POST['chosen_reset_customizer_nonce'], 'chosen_reset_customizer_nonce' ) )
		return;

	// validate user permissions
	if( ! current_user_can( 'manage_options' ) )
		return;

	// delete customizer mods
	remove_theme_mods();

	$redirect = admin_url( 'themes.php?page=chosen-options' );
	$redirect = add_query_arg( 'chosen_status', 'deleted', $redirect );

	// safely redirect
	wp_safe_redirect( $redirect ); exit;
}
add_action( 'admin_init', 'ct_chosen_reset_customizer_options' );

function ct_chosen_delete_settings_notice() {

	if ( isset( $_GET['chosen_status'] ) ) {
		?>
		<div class="updated">
			<p><?php _e( 'Customizer settings deleted', 'chosen' ); ?>.</p>
		</div>
	<?php
	}
}
add_action( 'admin_notices', 'ct_chosen_delete_settings_notice' );

function ct_chosen_body_class( $classes ) {

	global $post;

	/* get full post setting */
	$full_post = get_theme_mod('full_post');

	/* if full post setting on */
	if( $full_post == 'yes' ) {
		$classes[] = 'full-post';
	}

	// get pagination page on blog/archive
	$pagination = (get_query_var('paged')) ? get_query_var('paged') : 1;

	$full_width_post = get_theme_mod('full_width_post');

	// if on blog and on the first page
	if( is_home() && $pagination == 1 && $full_width_post != 'no' ) {
		$classes[] = 'posts-page-1';
	}
	if ( is_singular() ) {
		$classes[] = 'singular';
		if ( is_singular('page') ) {
			$classes[] = 'singular-page';
			$classes[] = 'singular-page-' . $post->ID;
		} elseif ( is_singular('post') ) {
			$classes[] = 'singular-post';
			$classes[] = 'singular-post-' . $post->ID;
		}
	}
	return $classes;
}
add_filter( 'body_class', 'ct_chosen_body_class' );

function ct_chosen_post_class($classes) {

	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'ct_chosen_post_class' );

// custom css output
function ct_chosen_custom_css_output(){

	$custom_css = get_theme_mod('custom_css');

	/* output custom css */
	if( $custom_css ) {
		wp_add_inline_style( 'ct-chosen-style', $custom_css );
		wp_add_inline_style( 'ct-chosen-style-rtl', $custom_css );
	}
}
add_action('wp_enqueue_scripts', 'ct_chosen_custom_css_output', 20);

function ct_chosen_svg_output($type) {

	$svg = '';

	if( $type == 'toggle-navigation' ) {

		$svg = '<svg width="24px" height="18px" viewBox="0 0 24 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
				    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
				        <g transform="translate(-148.000000, -36.000000)" fill="#6B6B6B">
				            <g transform="translate(123.000000, 25.000000)">
				                <g transform="translate(25.000000, 11.000000)">
				                    <rect x="0" y="16" width="24" height="2"></rect>
				                    <rect x="0" y="8" width="24" height="2"></rect>
				                    <rect x="0" y="0" width="24" height="2"></rect>
				                </g>
				            </g>
				        </g>
				    </g>
				</svg>';
	}

	return $svg;
}