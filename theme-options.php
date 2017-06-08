<?php

function ct_chosen_register_theme_page() {
	add_theme_page( sprintf( __( '%s Dashboard', 'chosen' ), wp_get_theme( get_template() ) ), sprintf( __( '%s Dashboard', 'chosen' ), wp_get_theme( get_template() ) ), 'edit_theme_options', 'chosen-options', 'ct_chosen_options_content', 'ct_chosen_options_content' );
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
	<div id="chosen-dashboard-wrap" class="wrap">
		<h2><?php printf( __( '%s Dashboard', 'chosen' ), wp_get_theme( get_template() ) ); ?></h2>
		<?php do_action( 'theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php _e( 'Get Started', 'chosen' ); ?></h3>
				<p><?php printf( __( 'Not sure where to start? The <strong>%1$s Getting Started Guide</strong> will take you step-by-step through every feature in %1$s.', 'chosen' ), wp_get_theme( get_template() ) ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/help/getting-started-chosen/"><?php _e( 'View Guide', 'chosen' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_chosen_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php printf( __( '%s Pro', 'chosen' ), wp_get_theme( get_template() ) ); ?></h3>
					<p><?php printf( __( 'Download the %s Pro plugin and unlock custom colors, new layouts, sliders, and more', 'chosen' ), wp_get_theme( get_template() ) ); ?>...</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/chosen-pro/"><?php _e( 'See Full Feature List', 'chosen' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php _e( 'Leave a Review', 'chosen' ); ?></h3>
				<p><?php printf( __( 'Help others find %s by leaving a review on wordpress.org.', 'chosen' ), wp_get_theme( get_template() ) ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/chosen/reviews/"><?php _e( 'Leave a Review', 'chosen' ); ?></a>
			</div>
			<div class="content content-presspad">
				<h3><?php _e( 'Turn Chosen into a Mobile App', 'chosen' ); ?></h3>
				<p><?php printf( __( '%s can be converted into a mobile app and listed on the App Store with the help of PressPad News. Read our tutorial to learn more.', 'chosen' ), wp_get_theme( get_template() ) ); ?></p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/help/convert-mobile-app-chosen/"><?php _e( 'Read Tutorial', 'chosen' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php _e( 'Reset Customizer Settings', 'chosen' ); ?></h3>
				<p>
					<?php printf( __( '<strong>Warning:</strong> Clicking this button will erase the %2$s theme\'s current settings in the <a href="%1$s">Customizer</a>.', 'chosen' ), esc_url( $customizer_url ), wp_get_theme( get_template() ) ); ?>
				</p>
				<form method="post">
					<input type="hidden" name="chosen_reset_customizer" value="chosen_reset_customizer_settings"/>
					<p>
						<?php wp_nonce_field( 'chosen_reset_customizer_nonce', 'chosen_reset_customizer_nonce' ); ?>
						<?php submit_button( __( 'Reset Customizer Settings', 'chosen' ), 'delete', 'delete', false ); ?>
					</p>
				</form>
			</div>
		</div>
		<?php do_action( 'theme_options_after' ); ?>
	</div>
<?php }