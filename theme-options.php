<?php

function ct_chosen_register_theme_page() {
	add_theme_page( sprintf( esc_html__( '%s Dashboard', 'chosen' ), wp_get_theme() ), sprintf( esc_html__( '%s Dashboard', 'chosen' ), wp_get_theme() ), 'edit_theme_options', 'chosen-options', 'ct_chosen_options_content', 'ct_chosen_options_content' );
}
add_action( 'admin_menu', 'ct_chosen_register_theme_page' );

function ct_chosen_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => get_home_url(),
			'return' => add_query_arg( 'page', 'chosen-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	?>
	<div id="chosen-dashboard-wrap" class="wrap chosen-dashboard-wrap">
		<h2><?php printf( esc_html__( '%s Dashboard', 'chosen' ), wp_get_theme() ); ?></h2>
		<?php do_action( 'theme_options_before' ); ?>
		<!-- new dashboard -->
		<div class="main">
			<div class="getting-started">
				<h3>Get Started with Chosen</h3>
				<p>Follow with this step-by-step guide to customize your website with Chosen:</p>
				<a href="https://www.competethemes.com/help/getting-started-chosen/" target="_blank">Read the Getting Started Guide</a>
			</div>
			<div class="pro">
				<h3>Customize More with Chosen Pro</h3>
				<p>Add 10 new customization features to your site with the <a href="https://www.competethemes.com/chosen-pro/" target="_blank">Chosen Pro</a> plugin.</p>
				<ul class="feature-list">
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/layouts.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>New Layouts</h4>
							<p>New layouts help your content look and perform its best. You can switch to new layouts effortlessly from the Customizer, or from specific posts or pages.</p>
							<p>Chosen Pro adds 6 new layouts.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/custom-colors.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>Custom Colors</h4>
							<p>Custom colors let you match the color of your site with your brand. Point-and-click to select a color, and watch your site update instantly.</p>
							<p>With 44 color controls, you can change the color of any element on your site.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/fonts.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>New Fonts</h4>
							<p>Stylish new fonts add character and charm to your content. Select and instantly preview fonts from the Customizer.</p>
							<p>Since Chosen Pro is powered by Google Fonts, it comes with 728 fonts for you to choose from.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/header-image.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>Flexible Header Image</h4>
							<p>Header images welcome visitors and set your site apart. Upload your image and quickly resize it to the perfect size.</p>
							<p>Display the header image on just the homepage, or leave it sitewide and link it to the homepage.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/featured-videos.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>Featured Videos</h4>
							<p>Featured Videos are an easy way to share videos in place of Featured Images. Instantly embed a Youtube video by copying and pasting its URL into an input.</p>
							<p>Chosen Pro auto-embeds videos from Youtube, Vimeo, DailyMotion, Flickr, Animoto, TED, Blip, Cloudup, FunnyOrDie, Hulu, Vine, WordPress.tv, and VideoPress.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/featured-sliders.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>Featured Sliders</h4>
							<p>Featured Sliders are an easy way to share image sliders in place of Featured Images. Quickly add responsive sliders to any page or post.</p>
							<p>Chosen Pro integrates with the free Meta Slider plugin with styling and sizing controls for your sliders.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/featured-image-size.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>Featured Image Size</h4>
							<p>Set each Featured Image to the perfect size. You can change the aspect ratio for all Featured Images and individual Featured Images with ease.</p>
							<p>Chosen Pro includes twelve different aspect ratios for your Featured Images.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/widget-areas.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>New Widget Areas</h4>
							<p>Utilize a sidebar and four additional widget areas for greater flexibility. Increase ad revenue and generate more email subscribers by adding widgets throughout your site.</p>
							<p>Chosen Pro adds 5 new widget areas.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/display-controls.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>Display Controls</h4>
							<p>Display controls let you display the parts of your site you want to show off, and hide the rest. Remove elements with just one click.</p>
							<p>Chosen Pro includes display controls for 11 different elements.</p>
						</div>
					</li>
					<li>
						<div class="image">
							<a class="image-link" href="https://www.competethemes.com/chosen-pro/" target="_blank">
								<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/footer-text.png'; ?>" />
							</a>
						</div>
						<div class="text">
							<h4>Custom Footer Text</h4>
							<p>Custom footer text lets you further brand your site. Just start typing to add your own text to the footer.</p>
							<p>The footer text supports plain text and full HTML for adding links.</p>
						</div>
					</li>
				</ul>
				<p><a href="https://www.competethemes.com/chosen-pro/" target="_blank">Click here</a> to view Chosen Pro now, and see what it can do for your site.</p>
			</div>
			<div class="pro-ad" style="background-image: url(<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/bg-texture.png'; ?>)">
				<h3>Add Incredible Flexibility to Your Site</h3>
				<p>Start customizing with Chosen Pro today</p>
				<a href="https://www.competethemes.com/chosen-pro/" target="_blank">View Chosen Pro</a>
			</div>
		</div>
		<div class="sidebar">
			<div class="dashboard-widget">
				<h4>More Amazing Resources</h4>
				<ul>
					<li><a href="https://www.competethemes.com/documentation/chosen-support-center/" target="_blank">Chosen Support Center</a></li>
					<li><a href="https://wordpress.org/support/theme/chosen" target="_blank">Support Forum</a></li>
					<li><a href="https://www.competethemes.com/help/chosen-changelog/" target="_blank">Changelog</a></li>
					<li><a href="https://www.competethemes.com/help/chosen-css-snippets/" target="_blank">CSS Snippets</a></li>
					<li><a href="https://www.competethemes.com/help/child-theme-chosen/" target="_blank">Starter child theme</a></li>
					<li><a href="">Chosen demo data</a></li>
					<li><a href="https://www.competethemes.com/chosen-pro/" target="_blank">Chosen Pro</a></li>
				</ul>
			</div>
			<div class="dashboard-widget">
				<h4>User Reviews</h4>
				<img src="<?php echo trailingslashit(get_template_directory_uri()) . 'assets/images/reviews.png'; ?>" />
				<p>Users are loving Chosen! <a href="https://wordpress.org/support/theme/chosen/reviews/?filter=5#new-post" target="_blank">Click here</a> to leave your own review</p>
			</div>
			<div class="dashboard-widget">
				<h4>Reset Customizer Settings</h4>
				<p><b>Warning:</b> Clicking this buttin will erase the Chosen theme's current settings in the Customizer.</p>
				<form method="post">
					<input type="hidden" name="chosen_reset_customizer" value="chosen_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'chosen_reset_customizer_nonce', 'chosen_reset_customizer_nonce' ); ?>
						<?php submit_button( 'Reset Customizer Settings', 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<!-- new dashboard end -->
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php esc_html_e( 'Get Started', 'chosen' ); ?></h3>
				<p><?php printf( __( 'Not sure where to start? The <strong>%1$s Getting Started Guide</strong> will take you step-by-step through every feature in %1$s.', 'chosen' ), wp_get_theme( get_template() ) ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/help/getting-started-chosen/"><?php esc_html_e( 'View Guide', 'chosen' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_chosen_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php printf( esc_html__( '%s Pro', 'chosen' ), wp_get_theme( get_template() ) ); ?></h3>
					<p><?php printf( esc_html__( 'Download the %s Pro plugin and unlock custom colors, new layouts, sliders, and more', 'chosen' ), wp_get_theme( get_template() ) ); ?>...</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/chosen-pro/"><?php esc_html_e( 'See Full Feature List', 'chosen' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php esc_html_e( 'Leave a Review', 'chosen' ); ?></h3>
				<p><?php printf( esc_html__( 'Help others find %s by leaving a review on wordpress.org.', 'chosen' ), wp_get_theme() ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/<?php echo sanitize_title(wp_get_theme()); ?>/reviews/"><?php esc_html_e( 'Leave a Review', 'chosen' ); ?></a>
			</div>
			<div class="content content-presspad">
				<h3><?php printf( esc_html__( 'Turn %s into a Mobile App', 'chosen' ), wp_get_theme() ); ?></h3>
				<p><?php printf( esc_html__( '%s can be converted into a mobile app and listed on the App Store and Google Play Store with the help of PressPad News. Read our tutorial to learn more.', 'chosen' ), wp_get_theme() ); ?></p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/help/convert-mobile-app-chosen/"><?php esc_html_e( 'Read Tutorial', 'chosen' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php esc_html_e( 'Reset Customizer Settings', 'chosen' ); ?></h3>
				<p>
					<?php printf( __( '<strong>Warning:</strong> Clicking this button will erase the %2$s theme\'s current settings in the <a href="%1$s">Customizer</a>.', 'chosen' ), esc_url( $customizer_url ), wp_get_theme() ); ?>
				</p>
				<form method="post">
					<input type="hidden" name="chosen_reset_customizer" value="chosen_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'chosen_reset_customizer_nonce', 'chosen_reset_customizer_nonce' ); ?>
						<?php submit_button( esc_html__( 'Reset Customizer Settings', 'chosen' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'theme_options_after' ); ?>
	</div>
<?php }