<?php
//----------------------------------------------------------------------------------
//	Include all required files
//----------------------------------------------------------------------------------
require_once(trailingslashit(get_template_directory()) . 'theme-options.php');
require_once(trailingslashit(get_template_directory()) . 'inc/customizer.php');
require_once(trailingslashit(get_template_directory()) . 'inc/last-updated-meta-box.php');
require_once(trailingslashit(get_template_directory()) . 'inc/scripts.php');
// TGMP
require_once(trailingslashit(get_template_directory()) . 'tgm/class-tgm-plugin-activation.php');

function ct_chosen_register_required_plugins()
{
    $plugins = array(

        array(
            'name'      => 'Independent Analytics',
            'slug'      => 'independent-analytics',
            'required'  => false,
        ),
    );
    
    $config = array(
        'id'           => 'ct-chosen',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
            'page_title'                      => __('Install Recommended Plugins', 'chosen'),
            'menu_title'                      => __('Recommended Plugins', 'chosen'),
            'notice_can_install_recommended'     => _n_noop(
                'The makers of the Chosen theme now recommend installing Independent Analytics, their new plugin for visitor tracking: %1$s.',
                'The makers of the Chosen theme now recommend installing Independent Analytics, their new plugin for visitor tracking: %1$s.',
                'chosen'
            ),
        )
    );

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'ct_chosen_register_required_plugins');

if (! function_exists(('ct_chosen_set_content_width'))) {
    function ct_chosen_set_content_width()
    {
        if (! isset($content_width)) {
            $content_width = 891;
        }
    }
}
add_action('after_setup_theme', 'ct_chosen_set_content_width', 0);

if (! function_exists(('ct_chosen_theme_setup'))) {
    function ct_chosen_theme_setup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption'
        ));
        add_theme_support('infinite-scroll', array(
            'container' => 'loop-container',
            'footer'    => 'overflow-container',
            'render'    => 'ct_chosen_infinite_scroll_render'
        ));
        // WooCommerce support
        add_theme_support('woocommerce');
        // Support for WooCommerce image gallery features
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        
        // Gutenberg - wide & full images
        add_theme_support('align-wide');

        // Gutenberg - add support for editor styles
        add_theme_support('editor-styles');

        // Gutenberg - modify the font sizes
        add_theme_support('editor-font-sizes', array(
            array(
                    'name' => __('small', 'chosen'),
                    'shortName' => __('S', 'chosen'),
                    'size' => 12,
                    'slug' => 'small'
            ),
            array(
                    'name' => __('regular', 'chosen'),
                    'shortName' => __('M', 'chosen'),
                    'size' => 17,
                    'slug' => 'regular'
            ),
            array(
                    'name' => __('large', 'chosen'),
                    'shortName' => __('L', 'chosen'),
                    'size' => 28,
                    'slug' => 'large'
            ),
            array(
                    'name' => __('larger', 'chosen'),
                    'shortName' => __('XL', 'chosen'),
                    'size' => 38,
                    'slug' => 'larger'
            )
    ));

        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'chosen')
        ));

        load_theme_textdomain('chosen', get_template_directory() . '/languages');
    }
}
add_action('after_setup_theme', 'ct_chosen_theme_setup', 10);

//-----------------------------------------------------------------------------
// Load custom stylesheet for the post editor
//-----------------------------------------------------------------------------
if (! function_exists('ct_chosen_add_editor_styles')) {
    function ct_chosen_add_editor_styles()
    {
        add_editor_style('styles/editor-style.css');
    }
}
add_action('admin_init', 'ct_chosen_add_editor_styles');

if (! function_exists(('ct_chosen_customize_comments'))) {
    function ct_chosen_customize_comments($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        global $post; ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-author">
				<?php
                echo get_avatar(get_comment_author_email(), 36, '', get_comment_author()); ?>
				<span class="author-name"><?php comment_author_link(); ?></span>
			</div>
			<div class="comment-content">
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php esc_html_e('Your comment is awaiting moderation.', 'chosen') ?></em>
					<br/>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
			<div class="comment-footer">
				<span class="comment-date"><?php comment_date(); ?></span>
				<?php comment_reply_link(array_merge($args, array(
                    'reply_text' => esc_html_x('Reply', 'verb: reply to this comment', 'chosen'),
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth']
                ))); ?>
				<?php edit_comment_link(esc_html_x('Edit', 'verb: edit this comment', 'chosen')); ?>
			</div>
		</article>
		<?php
    }
}

if (! function_exists('ct_chosen_update_fields')) {
    function ct_chosen_update_fields($fields)
    {
        $commenter = wp_get_current_commenter();
        $req       = get_option('require_name_email');
        $label     = $req ? '*' : ' ' . esc_html__('(optional)', 'chosen');
        $aria_req  = $req ? "aria-required='true'" : '';

        $fields['author'] =
            '<p class="comment-form-author">
	            <label for="author">' . esc_html_x("Name", "noun", "chosen") . $label . '</label>
	            <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['email'] =
            '<p class="comment-form-email">
	            <label for="email">' . esc_html_x("Email", "noun", "chosen") . $label . '</label>
	            <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) .
            '" size="30" ' . $aria_req . ' />
	        </p>';

        $fields['url'] =
            '<p class="comment-form-url">
	            <label for="url">' . esc_html__("Website", "chosen") . '</label>
	            <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) .
            '" size="30" />
	            </p>';

        return $fields;
    }
}
add_filter('comment_form_default_fields', 'ct_chosen_update_fields');

if (! function_exists('ct_chosen_update_comment_field')) {
    function ct_chosen_update_comment_field($comment_field)
    {

        // don't filter the WooCommerce review form
        if (function_exists('is_woocommerce')) {
            if (is_woocommerce()) {
                return $comment_field;
            }
        }

        $comment_field =
            '<p class="comment-form-comment">
	            <label for="comment">' . esc_html_x("Comment", "noun", "chosen") . '</label>
	            <textarea required id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	        </p>';

        return $comment_field;
    }
}
add_filter('comment_form_field_comment', 'ct_chosen_update_comment_field', 7);

if (! function_exists('ct_chosen_remove_comments_notes_after')) {
    function ct_chosen_remove_comments_notes_after($defaults)
    {
        $defaults['comment_notes_after'] = '';
        return $defaults;
    }
}
add_action('comment_form_defaults', 'ct_chosen_remove_comments_notes_after');

if (! function_exists('ct_chosen_filter_read_more_link')) {
    function ct_chosen_filter_read_more_link($custom = false)
    {
        if (is_feed()) {
            return;
        }
        global $post;
        $ismore             = strpos($post->post_content, '<!--more-->');
        $read_more_text     = get_theme_mod('read_more_text');
        $new_excerpt_length = get_theme_mod('excerpt_length');
        $excerpt_more       = ($new_excerpt_length === 0) ? '' : '&#8230;';
        $output = '';

        // add ellipsis for automatic excerpts
        if (empty($ismore) && $custom !== true) {
            $output .= $excerpt_more;
        }
        // Because i18n text cannot be stored in a variable
        if (empty($read_more_text)) {
            $output .= '<div class="more-link-wrapper"><a class="more-link" href="' . esc_url(get_permalink()) . '">' . esc_html__('Continue Reading', 'chosen') . '<span class="screen-reader-text">' . esc_html(get_the_title()) . '</span></a></div>';
        } else {
            $output .= '<div class="more-link-wrapper"><a class="more-link" href="' . esc_url(get_permalink()) . '">' . esc_html($read_more_text) . '<span class="screen-reader-text">' . esc_html(get_the_title()) . '</span></a></div>';
        }
        return $output;
    }
}
add_filter('the_content_more_link', 'ct_chosen_filter_read_more_link', 9999); // more tags
add_filter('excerpt_more', 'ct_chosen_filter_read_more_link', 9999); // automatic excerpts

// Yoast OG description has "Continue ReadingTitle of the Post" due to its use of get_the_excerpt(). This fixes that.
function ct_chosen_update_yoast_og_description($ogdesc)
{
    $read_more_text = get_theme_mod('read_more_text');
    if (empty($read_more_text)) {
        $read_more_text = esc_html__('Continue Reading', 'chosen');
    }
    // If user has meta description, it will be used causing OG description to NOT use excerpt with read more link
    if (strpos($ogdesc, $read_more_text) != 0) {
        $ogdesc = substr($ogdesc, 0, strpos($ogdesc, $read_more_text));
    }
    
    return $ogdesc;
}
add_filter('wpseo_opengraph_desc', 'ct_chosen_update_yoast_og_description');

// handle manual excerpts
if (! function_exists('ct_chosen_filter_manual_excerpts')) {
    function ct_chosen_filter_manual_excerpts($excerpt)
    {
        $excerpt_more = '';
        if (has_excerpt()) {
            $excerpt_more = ct_chosen_filter_read_more_link(true);
        }
        return $excerpt . $excerpt_more;
    }
}
add_filter('get_the_excerpt', 'ct_chosen_filter_manual_excerpts');

if (! function_exists('ct_chosen_excerpt')) {
    function ct_chosen_excerpt()
    {
        global $post;
        $show_full_post = get_theme_mod('full_post');
        $ismore         = strpos($post->post_content, '<!--more-->');

        if ($show_full_post === 'yes' || $ismore) {
            the_content();
        } else {
            the_excerpt();
        }
    }
}

if (! function_exists('ct_chosen_custom_excerpt_length')) {
    function ct_chosen_custom_excerpt_length($length)
    {
        $new_excerpt_length = get_theme_mod('excerpt_length');

        if (! empty($new_excerpt_length) && $new_excerpt_length != 25) {
            return $new_excerpt_length;
        } elseif ($new_excerpt_length === 0) {
            return 0;
        } else {
            return 25;
        }
    }
}
add_filter('excerpt_length', 'ct_chosen_custom_excerpt_length', 99);

if (! function_exists('ct_chosen_remove_more_link_scroll')) {
    function ct_chosen_remove_more_link_scroll($link)
    {
        $link = preg_replace('|#more-[0-9]+|', '', $link);
        return $link;
    }
}
add_filter('the_content_more_link', 'ct_chosen_remove_more_link_scroll');

if (! function_exists('ct_chosen_featured_image')) {
    function ct_chosen_featured_image()
    {
        global $post;
        $featured_image = '';

        if (has_post_thumbnail($post->ID)) {
            if (is_singular()) {
                $featured_image = '<div class="featured-image">' . get_the_post_thumbnail($post->ID, 'full') . '</div>';
            } else {
                $featured_image = '<div class="featured-image"><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . get_the_post_thumbnail($post->ID, 'full') . '</a></div>';
            }
        }

        $featured_image = apply_filters('ct_chosen_featured_image', $featured_image);

        if ($featured_image) {
            echo $featured_image;
        }
    }
}

if (! function_exists('ct_chosen_social_array')) {
    function ct_chosen_social_array()
    {
        $social_sites = array(
            'twitter'       => 'chosen_twitter_profile',
            'facebook'      => 'chosen_facebook_profile',
            'instagram'     => 'chosen_instagram_profile',
            'linkedin'      => 'chosen_linkedin_profile',
            'pinterest'     => 'chosen_pinterest_profile',
            'youtube'       => 'chosen_youtube_profile',
            'rss'           => 'chosen_rss_profile',
            'email'         => 'chosen_email_profile',
            'phone'			=> 'chosen_phone_profile',
            'email-form'    => 'chosen_email_form_profile',
            'amazon'        => 'chosen_amazon_profile',
            'artstation'    => 'chosen_artstation_profile',
            'bandcamp'      => 'chosen_bandcamp_profile',
            'behance'       => 'chosen_behance_profile',
            'bitbucket'     => 'chosen_bitbucket_profile',
            'codepen'       => 'chosen_codepen_profile',
            'delicious'     => 'chosen_delicious_profile',
            'deviantart'    => 'chosen_deviantart_profile',
            'diaspora'      => 'chosen_diaspora_profile',
            'digg'          => 'chosen_digg_profile',
            'discord'       => 'chosen_discord_profile',
            'dribbble'      => 'chosen_dribbble_profile',
            'etsy'          => 'chosen_etsy_profile',
            'flickr'        => 'chosen_flickr_profile',
            'foursquare'    => 'chosen_foursquare_profile',
            'github'        => 'chosen_github_profile',
            'goodreads'     => 'chosen_goodreads_profile',
            'google-wallet' => 'chosen_google-wallet_profile',
            'hacker-news'   => 'chosen_hacker-news_profile',
            'imdb'   		=> 'chosen_imdb_profile',
            'mastodon'      => 'chosen_mastodon_profile',
            'medium'        => 'chosen_medium_profile',
            'meetup'        => 'chosen_meetup_profile',
            'mixcloud'		=> 'chosen_mixcloud_profile',
            'ok-ru'         => 'chosen_ok_ru_profile',
            'orcid'         => 'chosen_orcid_profile',
            'patreon'       => 'chosen_patreon_profile',
            'paypal'        => 'chosen_paypal_profile',
            'pocket'       	=> 'chosen_pocket_profile',
            'podcast'       => 'chosen_podcast_profile',
            'qq'            => 'chosen_qq_profile',
            'quora'         => 'chosen_quora_profile',
            'ravelry'       => 'chosen_ravelry_profile',
            'reddit'        => 'chosen_reddit_profile',
            'researchgate'  => 'chosen_researchgate_profile',
            'skype'         => 'chosen_skype_profile',
            'slack'         => 'chosen_slack_profile',
            'slideshare'    => 'chosen_slideshare_profile',
            'snapchat'      => 'chosen_snapchat_profile',
            'soundcloud'    => 'chosen_soundcloud_profile',
            'spotify'       => 'chosen_spotify_profile',
            'stack-overflow' => 'chosen_stack_overflow_profile',
            'steam'         => 'chosen_steam_profile',
            'strava'        => 'chosen_strava_profile',
            'stumbleupon'   => 'chosen_stumbleupon_profile',
            'telegram'      => 'chosen_telegram_profile',
            'tencent-weibo' => 'chosen_tencent_weibo_profile',
            'tumblr'        => 'chosen_tumblr_profile',
            'twitch'        => 'chosen_twitch_profile',
            'untappd'       => 'chosen_untappd_profile',
            'vimeo'         => 'chosen_vimeo_profile',
            'vine'          => 'chosen_vine_profile',
            'vk'            => 'chosen_vk_profile',
            'wechat'        => 'chosen_wechat_profile',
            'weibo'         => 'chosen_weibo_profile',
            'whatsapp'      => 'chosen_whatsapp_profile',
            'xing'          => 'chosen_xing_profile',
            'yahoo'         => 'chosen_yahoo_profile',
            'yelp'          => 'chosen_yelp_profile',
            '500px'         => 'chosen_500px_profile',
            'social_icon_custom_1' => 'social_icon_custom_1_profile',
            'social_icon_custom_2' => 'social_icon_custom_2_profile',
            'social_icon_custom_3' => 'social_icon_custom_3_profile'
        );

        return apply_filters('ct_chosen_social_array_filter', $social_sites);
    }
}

if (! function_exists('ct_chosen_social_icons_output')) {
    function ct_chosen_social_icons_output()
    {

        // Get the social icons array
        $social_sites = ct_chosen_social_array();
        // Store only icons with URLs saved
        $saved = array();

        /* Store the site name and ID if saved
        /* name: twitter
        /* id: chosen_twitter_profile */
        foreach ($social_sites as $name => $id) {
            if (strlen(get_theme_mod($name)) > 0) {
                $saved[ $name ] = $id;
            }
        }

        // If there are any social profiles saved
        if (!empty($saved)) {
            echo "<ul class='social-media-icons'>";

            // Output list item for every saved profile
            foreach ($saved as $name => $id) {
                if ($name == 'rss') {
                    $class = 'fas fa-rss';
                } elseif ($name == 'email') {
                    $class = 'fas fa-envelope';
                } elseif ($name == 'email-form') {
                    $class = 'far fa-envelope';
                } elseif ($name == 'podcast') {
                    $class = 'fas fa-podcast';
                } elseif ($name == 'ok-ru') {
                    $class = 'fab fa-odnoklassniki';
                } elseif ($name == 'wechat') {
                    $class = 'fab fa-weixin';
                } elseif ($name == 'pocket') {
                    $class = 'fab fa-get-pocket';
                } elseif ($name == 'phone') {
                    $class = 'fas fa-phone';
                } elseif ($name == 'twitter') {
                    $class = 'fab fa-square-x-twitter';
                } else {
                    $class = 'fab fa-' . $name;
                }

                $url = get_theme_mod($name);
                $title = $name;

                // Escape the URL based on protocol being used
                if ($name == 'email') {
                    $href = 'mailto:' . antispambot(is_email($url));
                    $title = antispambot(is_email($url));
                } elseif ($name == 'skype') {
                    $href = esc_url($url, array( 'http', 'https', 'skype' ));
                } elseif ($name == 'phone') {
                    $href = esc_url($url, array( 'tel' ));
                    $title = str_replace('tel:', '', esc_url($url, array( 'tel' )));
                } else {
                    $href = esc_url($url);
                }
                if ($name == 'social_icon_custom_1' || $name == 'social_icon_custom_2' || $name == 'social_icon_custom_3') { ?>
					<li>
						<a class="custom-icon" target="_blank" href="<?php echo $href; ?>">
						<img class="icon" src="<?php echo esc_url(get_theme_mod($name .'_image')); ?>" style="width: <?php echo absint(get_theme_mod($name . '_size', '20')); ?>px;" />
							<span class="screen-reader-text"><?php echo esc_html(get_theme_mod($name .'_name'));  ?></span>
						</a>
					</li>
				<?php } else { ?>
					<li>
						<a class="<?php echo esc_attr($name); ?>" target="_blank" href="<?php echo $href; ?>">
							<i class="<?php echo esc_attr($class); ?>" aria-hidden="true" title="<?php echo esc_attr($title); ?>"></i>
							<span class="screen-reader-text"><?php echo esc_html($name);  ?></span>
						</a>
					</li>
				<?php }
            }
            echo "</ul>";
        }
    }
}

/*
 * WP will apply the ".menu-primary-items" class & id to the containing <div> instead of <ul>
 * making styling difficult and confusing. Using this wrapper to add a unique class to make styling easier.
 */
if (! function_exists('ct_chosen_wp_page_menu')) {
    function ct_chosen_wp_page_menu()
    {
        wp_page_menu(
            array(
                "menu_class" => "menu-unset",
                "depth"      => - 1
            )
        );
    }
}

if (! function_exists('ct_chosen_nav_dropdown_buttons')) {
    function ct_chosen_nav_dropdown_buttons($item_output, $item, $depth, $args)
    {
        if ($args->theme_location == 'primary') {
            if (in_array('menu-item-has-children', $item->classes) || in_array('page_item_has_children', $item->classes)) {
                $item_output = str_replace($args->link_after . '</a>', $args->link_after . '</a><button class="toggle-dropdown" aria-expanded="false" name="toggle-dropdown"><span class="screen-reader-text">' . esc_html_x("open menu", "verb: open the menu", "chosen") . '</span><i class="fas fa-angle-down"></i></button>', $item_output);
            }
        }

        return $item_output;
    }
}
add_filter('walker_nav_menu_start_el', 'ct_chosen_nav_dropdown_buttons', 10, 4);

if (! function_exists('ct_chosen_sticky_post_marker')) {
    function ct_chosen_sticky_post_marker()
    {
        if (is_sticky() && !is_archive() && !is_search()) {
            echo '<div class="sticky-status"><span>' . esc_html__("Featured Post", "chosen") . '</span></div>';
        }
    }
}
add_action('sticky_post_status', 'ct_chosen_sticky_post_marker');

if (! function_exists('ct_chosen_reset_customizer_options')) {
    function ct_chosen_reset_customizer_options()
    {
        if (empty($_POST['chosen_reset_customizer']) || 'chosen_reset_customizer_settings' !== $_POST['chosen_reset_customizer']) {
            return;
        }

        if (! wp_verify_nonce($_POST['chosen_reset_customizer_nonce'], 'chosen_reset_customizer_nonce')) {
            return;
        }

        if (! current_user_can('edit_theme_options')) {
            return;
        }

        $mods_array = array(
            'logo_upload',
            'search_bar',
            'full_post',
            'excerpt_length',
            'read_more_text',
            'full_width_post',
            'author_byline',
            'custom_css'
        );

        $social_sites = ct_chosen_social_array();

        // add social site settings to mods array
        foreach ($social_sites as $social_site => $value) {
            $mods_array[] = $social_site;
        }

        $mods_array = apply_filters('ct_chosen_mods_to_remove', $mods_array);

        foreach ($mods_array as $theme_mod) {
            remove_theme_mod($theme_mod);
        }

        $redirect = admin_url('themes.php?page=chosen-options');
        $redirect = add_query_arg('chosen_status', 'deleted', $redirect);

        // safely redirect
        wp_safe_redirect($redirect);
        exit;
    }
}
add_action('admin_init', 'ct_chosen_reset_customizer_options');

if (! function_exists('ct_chosen_delete_settings_notice')) {
    function ct_chosen_delete_settings_notice()
    {
        if (isset($_GET['chosen_status'])) {
            if ($_GET['chosen_status'] == 'deleted') {
                ?>
				<div class="updated">
					<p><?php esc_html_e('Customizer settings deleted.', 'chosen'); ?></p>
				</div>
				<?php
            }
        }
    }
}
add_action('admin_notices', 'ct_chosen_delete_settings_notice');

if (! function_exists('ct_chosen_body_class')) {
    function ct_chosen_body_class($classes)
    {
        global $post;
        $full_post       = get_theme_mod('full_post');
        $pagination      = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $full_width_post = get_theme_mod('full_width_post');

        if ($full_post == 'yes') {
            $classes[] = 'full-post';
        }

        if (is_home() && $pagination == 1 && $full_width_post != 'no') {
            $classes[] = 'posts-page-1';
        }
        if (is_singular()) {
            $classes[] = 'singular';
            if (is_singular('page')) {
                $classes[] = 'singular-page';
                $classes[] = 'singular-page-' . $post->ID;
            } elseif (is_singular('post')) {
                $classes[] = 'singular-post';
                $classes[] = 'singular-post-' . $post->ID;
            } elseif (is_singular('attachment')) {
                $classes[] = 'singular-attachment';
                $classes[] = 'singular-attachment-' . $post->ID;
            }
        }

        if (get_theme_mod('keep_mobile_menu') == 'yes') {
            $classes[] = 'mobile-menu-always';
        }

        return $classes;
    }
}
add_filter('body_class', 'ct_chosen_body_class');

if (! function_exists('ct_chosen_post_class')) {
    function ct_chosen_post_class($classes)
    {
        $classes[] = 'entry';

        return $classes;
    }
}
add_filter('post_class', 'ct_chosen_post_class');

if (! function_exists('ct_chosen_custom_css_output')) {
    function ct_chosen_custom_css_output()
    {
        if (function_exists('wp_get_custom_css')) {
            $custom_css = wp_get_custom_css();
        } else {
            $custom_css = get_theme_mod('custom_css');
        }

        if ($custom_css) {
            $custom_css = ct_chosen_sanitize_css($custom_css);

            wp_add_inline_style('ct-chosen-style', $custom_css);
            wp_add_inline_style('ct-chosen-style-rtl', $custom_css);
        }
    }
}
add_action('wp_enqueue_scripts', 'ct_chosen_custom_css_output', 20);

if (! function_exists('ct_chosen_svg_output')) {
    function ct_chosen_svg_output($type)
    {
        $svg = '';

        if ($type == 'toggle-navigation') {
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
}

if (! function_exists('ct_chosen_add_meta_elements')) {
    function ct_chosen_add_meta_elements()
    {
        $meta_elements = '';

        $meta_elements .= sprintf('<meta charset="%s" />' . "\n", esc_attr(get_bloginfo('charset')));
        $meta_elements .= '<meta name="viewport" content="width=device-width, initial-scale=1" />' . "\n";

        $theme    = wp_get_theme(get_template());
        $template = sprintf('<meta name="template" content="%s %s" />' . "\n", esc_attr($theme->get('Name')), esc_attr($theme->get('Version')));
        $meta_elements .= $template;

        echo $meta_elements;
    }
}
add_action('wp_head', 'ct_chosen_add_meta_elements', 1);

if (! function_exists('ct_chosen_infinite_scroll_render')) {
    function ct_chosen_infinite_scroll_render()
    {
        while (have_posts()) {
            the_post();
            get_template_part('content', 'archive');
        }
    }
}

if (! function_exists('ct_chosen_get_content_template')) {
    function ct_chosen_get_content_template()
    {
        if (function_exists('is_bbpress')) {
            if (is_bbpress()) {
                get_template_part('content/bbpress');
                return;
            }
        }
        if (is_home() || is_archive()) {
            get_template_part('content-archive', get_post_type());
        } else {
            get_template_part('content', get_post_type());
        }
    }
}

// prevent odd number of posts on page 2+ of blog if extra-wide post used
if (! function_exists('ct_chosen_adjust_post_count')) {
    function ct_chosen_adjust_post_count($query)
    {

        // Don't affect any WC pages...
        if (function_exists('is_woocommerce')) {
            if (is_woocommerce()) {
                return;
            }
        }
        $extra_wide = get_theme_mod('full_width_post');

        if ($extra_wide != 'no') {
            if (!is_admin() && $query->is_home() && $query->is_main_query() && $query->is_paged()) {
                $posts_per_page = get_option('posts_per_page');

                // get number of previous posts
                $offset = ($query->query_vars['paged'] - 1) * $posts_per_page;

                // offset post count minus one for every page after page 2
                $query->set('offset', $offset - ($query->query_vars['paged'] - 2));

                // drop the posts per page by 1
                $query->set('posts_per_page', $posts_per_page - 1);
            } elseif (!is_admin() && $query->is_main_query() && $query->is_archive()) {
                $posts_per_page = get_option('posts_per_page');

                // get number of previous posts
                $offset = ($query->query_vars['paged'] - 1) * $posts_per_page;

                if ($query->is_paged()) {
                    $query->set('offset', $offset - ($query->query_vars['paged'] - 1));
                }

                // drop the posts per page by 1
                $query->set('posts_per_page', $posts_per_page - 1);
            }
        }
    }
}
add_action('pre_get_posts', 'ct_chosen_adjust_post_count', 99);

function ct_chosen_fix_pagination_count($found_posts, $query)
{

    // Return right away if there isn't the extra wide post
    if (get_theme_mod('full_width_post') == 'no') {
        return $found_posts;
    }
    if (!is_admin() && $query->is_home() && $query->is_main_query() && !$query->is_paged()) {
        // The non-homepage posts per page
        $real_posts_per_page = get_option('posts_per_page') - 1;
        // Adjust by the +1 on the homepage for the extra post
        $found_posts -= 1;
        // add extra pages based on artificially inflated count
        $found_posts += $found_posts/$real_posts_per_page;
        return $found_posts;
    } elseif (!is_admin() && $query->is_main_query() && $query->is_paged()) {
        // offset for the 1 homepage post to prevent 404 if off by one
        return $found_posts - 1;
    } else {
        return $found_posts;
    }
}
add_filter('found_posts', 'ct_chosen_fix_pagination_count', 10, 2);

// allow skype URIs to be used
if (! function_exists('ct_chosen_allow_skype_protocol')) {
    function ct_chosen_allow_skype_protocol($protocols)
    {
        $protocols[] = 'skype';

        return $protocols;
    }
}
add_filter('kses_allowed_protocols', 'ct_chosen_allow_skype_protocol');

if (function_exists('ct_chosen_pro_plugin_updater')) {
    remove_action('admin_init', 'ct_chosen_pro_plugin_updater', 0);
    add_action('admin_init', 'ct_chosen_pro_plugin_updater', 0);
}

//----------------------------------------------------------------------------------
// Add paragraph tags for author bio displayed in content/archive-header.php.
// the_archive_description includes paragraph tags for tag and category descriptions, but not the author bio.
//----------------------------------------------------------------------------------
if (! function_exists('ct_chosen_modify_archive_descriptions')) {
    function ct_chosen_modify_archive_descriptions($description)
    {
        if (is_author()) {
            $description = wpautop($description);
        }
        return $description;
    }
}
add_filter('get_the_archive_description', 'ct_chosen_modify_archive_descriptions');

function ct_chosen_scroll_to_top_arrow()
{
    $setting = get_theme_mod('scroll_to_top');
    
    if ($setting == 'yes') {
        echo '<button id="scroll-to-top" class="scroll-to-top"><span class="screen-reader-text">'. esc_html__('Scroll to the top', 'chosen') .'</span><i class="fas fa-arrow-up"></i></button>';
    }
}
add_action('body_bottom', 'ct_chosen_scroll_to_top_arrow');

//----------------------------------------------------------------------------------
// Output the "Last Updated" date on posts
//----------------------------------------------------------------------------------
function ct_chosen_output_last_updated_date()
{
    global $post;

    if (get_the_modified_date() != get_the_date()) {
        $updated_post = get_post_meta($post->ID, 'ct_chosen_last_updated', true);
        $updated_customizer = get_theme_mod('last_updated');
        if (
            ($updated_customizer == 'yes' && ($updated_post != 'no'))
            || $updated_post == 'yes'
            ) {
            echo '<p class="last-updated">'. esc_html__("Last updated on", "chosen") . ' ' . get_the_modified_date() . ' </p>';
        }
    }
}

//----------------------------------------------------------------------------------
// Output standard pagination and account for bbPress forum archives
//----------------------------------------------------------------------------------
function ct_chosen_pagination()
{
    if (function_exists('is_bbpress')) {
        if (is_bbpress()) {
            return;
        }
    }
    the_posts_pagination(array(
    'prev_text' => esc_html__('Previous', 'chosen'),
    'next_text' => esc_html__('Next', 'chosen')
    ));
}

//----------------------------------------------------------------------------------
// Add support for Elementor headers & footers
//----------------------------------------------------------------------------------
function ct_chosen_register_elementor_locations($elementor_theme_manager)
{
    $elementor_theme_manager->register_location('header');
    $elementor_theme_manager->register_location('footer');
}
add_action('elementor/theme/register_locations', 'ct_chosen_register_elementor_locations');
