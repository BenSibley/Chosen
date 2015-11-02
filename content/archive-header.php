<?php
/* Category header */
if( is_category() ){ ?>
	<div class='archive-header'>
		<h2>
			<i class="fa fa-folder-open" title="<?php _e('archive icon', 'chosen'); ?>"></i>
			<?php printf( __('You are viewing the <span>%s</span> category archive.', 'chosen'), single_cat_title('', false) ); ?>
		</h2>
		<?php if ( category_description() ) echo category_description(); ?>
	</div>
<?php
}
/* Tag header */
elseif( is_tag() ){ ?>
	<div class='archive-header'>
		<h2>
			<i class="fa fa-tag" title="<?php _e('tag icon', 'chosen'); ?>"></i>
			<?php printf( __('You are viewing the <span>%s</span> tag archive.', 'chosen'), single_tag_title('', false) ); ?>
		</h2>
		<?php if ( tag_description() ) echo tag_description(); ?>
	</div>
<?php
}
/* Author header */
elseif( is_author() ){
	$author = get_userdata(get_query_var('author')); ?>
	<div class='archive-header'>
		<h2>
			<i class="fa fa-user" title="<?php _e('author icon', 'chosen'); ?>"></i>
			<?php printf( __("You are viewing <span>%s</span>'s post archive.", "chosen"), $author->nickname ); ?>
		</h2>
		<?php if ( get_the_author_meta( 'description' ) ) echo '<p>' . get_the_author_meta( 'description' ) . '</p>'; ?>
	</div>
<?php
}
/* Date header */
elseif( is_date() ){ ?>
	<div class='archive-header'>
		<h2>
			<i class="fa fa-calendar" title="<?php _e('calendar icon', 'chosen'); ?>"></i>
			<?php printf( __('You are viewing the date archive for <span>%s</span>.', 'chosen'), single_month_title('', false) ); ?>
		</h2>
	</div>
<?php
}