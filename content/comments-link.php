<span class="comments-link">
	<i class="fas fa-comment" title="<?php esc_attr_e( 'comment icon', 'chosen' ); ?>" aria-hidden="true"></i>
	<?php
	if ( ! comments_open() && get_comments_number() < 1 ) :
		comments_number( esc_html__( 'Comments closed', 'chosen' ), esc_html__( '1 Comment', 'chosen' ), esc_html_x( '% Comments', 'noun: 5 comments', 'chosen' ) );
	else :
		echo '<a href="' . esc_url( get_comments_link() ) . '">';
		comments_number( esc_html__( 'Leave a Comment', 'chosen' ), esc_html__( '1 Comment', 'chosen' ), esc_html_x( '% Comments', 'noun: 5 comments', 'chosen' ) );
		echo '</a>';
	endif;
	?>
</span>