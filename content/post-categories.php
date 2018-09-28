<?php

$categories = get_the_category( $post->ID );
$separator  = ' ';
$output     = '';

if ( $categories ) {
	echo '<p class="post-categories">';
		echo '<span>' . esc_html__( 'Categories:', 'chosen' ) . '</span>';
		foreach ( $categories as $category ) {
			$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="' . esc_attr( sprintf( esc_html_x( "View all posts in %s", 'View all posts in CATEGORY', 'chosen' ), $category->name ) ) . '">' . esc_html( $category->cat_name ) . '</a>' . $separator;
		}
		echo trim( $output, $separator );
	echo "</p>";
}