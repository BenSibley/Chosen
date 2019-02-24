<div class="post-byline">
    <span class="post-date">
		<?php
		$date = date_i18n( get_option( 'date_format' ), strtotime( get_the_date( 'c' ) ) );
		printf( esc_html_x( 'Published %s', 'Published DATE', 'chosen' ), $date );
		?>
	</span>
	<?php
	$author = get_theme_mod( 'author_byline' );
	if ( $author == 'yes' ) { ?>
		<span class="post-author">
			<span><?php echo esc_html_x( 'By', 'Published DATE by AUTHOR ', 'chosen' ); ?></span>
			<?php the_author(); ?>
		</span>
	<?php } ?>
</div>