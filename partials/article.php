<article <?php post_class(); ?>>

	<?php if ( has_post_thumbnail()) : // Check if thumbnail exists ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_post_thumbnail(array(120,120)); // Declare pixel size you need inside the array ?>
		</a>
	<?php endif; ?>
	<h2>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
	</h2>
	<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
	<span class="author"><?php _e( 'Published by', 'bboneswp' ); ?> <?php the_author_posts_link(); ?></span>
	<span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'bboneswp' ), __( '1 Comment', 'bboneswp' ), __( '% Comments', 'bboneswp' )); ?></span>

	<?php bboneswp_excerpt('bboneswp_index'); // Build your custom callback length in functions.php ?>

	<?php edit_post_link(); ?>

</article>

