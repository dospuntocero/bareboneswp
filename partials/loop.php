<?php if (have_posts()): while (have_posts()) : the_post(); ?>

    <?php get_template_part('partials/article'); ?>

<?php endwhile; ?>

<?php else: ?>


	<article>
		<h2><?php _e( 'Sorry, nothing to display.', 'bbones' ); ?></h2>
	</article>

<?php endif; ?>
