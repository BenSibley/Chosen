<?php $post_title_position = get_theme_mod('post_title_position'); ?>
<div <?php post_class(); ?>>
	<?php do_action( 'page_before' ); ?>
	<article>
		<?php if (empty($post_title_position) || $post_title_position == 'below' ) {
			ct_chosen_featured_image();
		} ?>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
		</div>
		<?php if ($post_title_position == 'above' ) {
			ct_chosen_featured_image();
		} ?>
		<div class="post-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before' => '<p class="singular-pagination">' . esc_html__( 'Pages:', 'chosen' ),
				'after'  => '</p>',
			) ); ?>
			<?php do_action( 'page_after' ); ?>
		</div>
	</article>
	<?php comments_template(); ?>
</div>