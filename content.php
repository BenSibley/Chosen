<?php $post_title_position = get_theme_mod('post_title_position'); ?>
<div <?php post_class(); ?>>
	<?php do_action( 'post_before' ); ?>
	<article>
		<?php if (empty($post_title_position) || $post_title_position == 'below' ) {
			ct_chosen_featured_image();
		} ?>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
			<?php get_template_part( 'content/post-byline' ); ?>
		</div>
		<?php if ($post_title_position == 'above' ) {
			ct_chosen_featured_image();
		} ?>
		<div class="post-content">
			<?php ct_chosen_output_last_updated_date(); ?>
			<?php the_content(); ?>
			<?php wp_link_pages( array(
				'before' => '<p class="singular-pagination">' . esc_html__( 'Pages:', 'chosen' ),
				'after'  => '</p>',
			) ); ?>
			<?php do_action( 'post_after' ); ?>
		</div>
		<div class="post-meta">
			<?php get_template_part( 'content/post-categories' ); ?>
			<?php get_template_part( 'content/post-tags' ); ?>
			<?php get_template_part( 'content/post-nav' ); ?>
		</div>
	</article>
	<?php comments_template(); ?>
</div>