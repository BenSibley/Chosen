<div <?php post_class(); ?>>
	<?php hybrid_do_atomic( 'page_before' ); ?>
	<article>
		<?php ct_chosen_featured_image(); ?>
		<div class='post-header'>
			<h1 class='post-title'><?php the_title(); ?></h1>
		</div>
		<div class="post-content">
			<?php the_content(); ?>
			<?php wp_link_pages(array('before' => '<p class="singular-pagination">' . __('Pages:','chosen'), 'after' => '</p>', ) ); ?>
			<?php hybrid_do_atomic( 'page_after' ); ?>
		</div>
	</article>
	<?php comments_template(); ?>
</div>