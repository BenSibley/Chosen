<?php

/* create theme options page */
function ct_chosen_register_theme_page(){
	add_theme_page( 'Chosen Dashboard', 'Chosen Dashboard', 'edit_theme_options', 'chosen-options', 'ct_chosen_options_content', 'ct_chosen_options_content');
}
add_action( 'admin_menu', 'ct_chosen_register_theme_page' );

/* callback used to add content to options page */
function ct_chosen_options_content(){

	$customizer_url = add_query_arg(
		array(
			'url'    => site_url(),
			'return' => admin_url('themes.php?page=chosen-options')
		),
		admin_url('customize.php')
	);
	?>
	<div id="chosen-dashboard-wrap" class="wrap">
		<h2><?php _e('Chosen Dashboard', 'chosen'); ?></h2>
		<?php hybrid_do_atomic( 'theme_options_before' ); ?>
		<div class="content content-customization">
			<h3><?php _e('Customization', 'chosen'); ?></h3>
			<p><?php _e('Click the "Customize" link in your menu, or use the button below to get started customizing Chosen', 'chosen'); ?>.</p>
			<p>
				<a class="button-primary" href="<?php echo esc_url( $customizer_url ); ?>"><?php _e('Use Customizer', 'chosen') ?></a>
			</p>
		</div>
		<div class="content content-support">
			<h3><?php _e('Support', 'chosen'); ?></h3>
			<p><?php _e("You can find the knowledgebase, changelog, support forum, and more in the chosen Support Center", "chosen"); ?>.</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/documentation/chosen-support-center/"><?php _e('Visit Support Center', 'chosen'); ?></a>
			</p>
		</div>
		<div class="content content-premium-upgrade">
			<h3><?php _e('Upgrade to Chosen Pro', 'chosen'); ?></h3>
			<p><?php _e('Chosen Pro is the premium upgrade for Chosen. It has custom colors, new layouts, sliders, and more', 'chosen'); ?>...</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/chosen-pro/"><?php _e('See Full Feature List', 'chosen'); ?></a>
			</p>
		</div>
		<div class="content content-resources">
			<h3><?php _e('WordPress Resources', 'chosen'); ?></h3>
			<p><?php _e('Save time and money searching for WordPress products by following our recommendations', 'chosen'); ?>.</p>
			<p>
				<a target="_blank" class="button-primary" href="https://www.competethemes.com/wordpress-resources/"><?php _e('View Resources', 'chosen'); ?></a>
			</p>
		</div>
		<div class="content content-delete-settings">
			<h3><?php _e('Reset Customizer Settings', 'chosen'); ?></h3>
			<p>
				<?php printf( __( '<strong>Warning:</strong> Clicking this button will erase your current settings in the <a href="%s">Customizer</a>.', 'chosen' ), esc_url( $customizer_url ) ); ?>
			</p>
			<form method="post">
				<input type="hidden" name="chosen_reset_customizer" value="chosen_reset_customizer_settings" />
				<p>
					<?php wp_nonce_field( 'chosen_reset_customizer_nonce', 'chosen_reset_customizer_nonce' ); ?>
					<?php submit_button( __( 'Reset Customizer Settings', 'chosen' ), 'delete', 'delete', false ); ?>
				</p>
			</form>
		</div>
		<?php hybrid_do_atomic( 'theme_options_after' ); ?>
	</div>
<?php } ?>
