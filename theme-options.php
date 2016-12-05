<?php

function ct_chosen_register_theme_page() {
	add_theme_page( __( 'Chosen Dashboard', 'chosen' ), __( 'Chosen Dashboard', 'chosen' ), 'edit_theme_options', 'chosen-options', 'ct_chosen_options_content', 'ct_chosen_options_content' );
}
add_action( 'admin_menu', 'ct_chosen_register_theme_page' );

function ct_chosen_options_content() {

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => add_query_arg( 'page', 'chosen-options', admin_url( 'themes.php' ) )
		),
		admin_url( 'customize.php' )
	);
	?>
	<div id="chosen-dashboard-wrap" class="wrap">
		<h2><?php _e( 'Chosen Dashboard', 'chosen' ); ?></h2>
		<?php do_action( 'theme_options_before' ); ?>
		<div class="content-boxes">
			<div class="content content-support">
				<h3><?php _e( 'Get Started', 'chosen' ); ?></h3>
				<p><?php _e( "Not sure where to start? The <strong>Chosen Getting Started Guide</strong> will take you step-by-step through every feature in Chosen.", "chosen" ); ?></p>
				<p>
					<a target="_blank" class="button-primary"
					   href="https://www.competethemes.com/help/getting-started-chosen/"><?php _e( 'View Guide', 'chosen' ); ?></a>
				</p>
			</div>
			<?php if ( !function_exists( 'ct_chosen_pro_init' ) ) : ?>
				<div class="content content-premium-upgrade">
					<h3><?php _e( 'Chosen Pro', 'chosen' ); ?></h3>
					<p><?php _e( 'Download the Chosen Pro plugin and unlock custom colors, new layouts, sliders, and more', 'chosen' ); ?>...</p>
					<p>
						<a target="_blank" class="button-primary"
						   href="https://www.competethemes.com/chosen-pro/"><?php _e( 'See Full Feature List', 'chosen' ); ?></a>
					</p>
				</div>
			<?php endif; ?>
			<div class="content content-review">
				<h3><?php _e( 'Leave a Review', 'chosen' ); ?></h3>
				<p><?php _e( 'Help others find Chosen by leaving a review on wordpress.org.', 'chosen' ); ?></p>
				<a target="_blank" class="button-primary" href="https://wordpress.org/support/theme/chosen/reviews/"><?php _e( 'Leave a Review', 'chosen' ); ?></a>
			</div>
			<div class="content content-delete-settings">
				<h3><?php _e( 'Reset Customizer Settings', 'chosen' ); ?></h3>
				<p>
					<?php printf( __( "<strong>Warning:</strong> Clicking this button will erase the Chosen theme's current settings in the <a href='%s'>Customizer</a>.", 'chosen' ), esc_url( $customizer_url ) ); ?>
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