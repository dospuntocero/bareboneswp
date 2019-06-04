<?php
/**
 * Template Name: demo template
 */
get_header();
?>


<main role="main" <?php post_class(); ?>>
	<section>
		<article>

			<h1><?php the_title( ); ?></h1>
			<?php the_content(); ?>

		</article>
	</section>
</main>

<?php get_footer(); ?>
