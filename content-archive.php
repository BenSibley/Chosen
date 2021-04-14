<?php $post_title_position = get_theme_mod('post_title_position'); ?>
<div <?php post_class(); ?>>
	<?php do_action( 'archive_post_before' ); ?>
	<article>
		<?php if (empty($post_title_position) || $post_title_position == 'below' ) {
			ct_chosen_featured_image();
		} ?>
		<div class='post-header'>
			<?php do_action( 'sticky_post_status' ); ?>
			<h2 class='post-title'>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h2>
			<?php get_template_part( 'content/post-byline' ); ?>
		</div>
		<?php if ($post_title_position == 'above' ) {
			ct_chosen_featured_image();
		} ?>
		<div class="post-content">
			<?php ct_chosen_excerpt(); ?>
			<?php get_template_part( 'content/comments-link' ); ?>
		</div>
	</article>
	<?php do_action( 'archive_post_after' ); ?>
</div>