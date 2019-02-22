<?php

if ( function_exists( 'is_bbpress' ) ) {
	if ( is_bbpress() ) {
		return;
	} 
}

if ( is_home() ) {
	echo '<h1 class="screen-reader-text">' . esc_html( get_bloginfo("name") ) . ' ' . esc_html_x('Posts', 'noun: Site Title\'s Posts', 'chosen') . '</h1>';
}
if ( ! is_archive() ) {
	return;
}

$icon_class = 'folder-open';

if ( is_tag() ) {
	$icon_class = 'tag';
} elseif ( is_author() ) {
	$icon_class = 'user';
} elseif ( is_date() ) {
	$icon_class = 'calendar';
}
?>

<div class='archive-header'>
	<h1>
		<i class="fas fa-<?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
		<?php the_archive_title(); ?>
	</h1>
	<?php the_archive_description(); ?>
</div>