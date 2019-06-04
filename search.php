<?php get_header(); ?>

<main role="main">

		<h1>SEARCH RESULTS</h1>
		<h2>"<span><?php the_search_query(); ?></span>"</h2>

	<section class="search-results">
		<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post();?>
				<?php get_template_part('partials/article'); ?>
			<?php endwhile; ?>
			<?php get_template_part('partials/pagination'); ?>

		<?php else : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'bboneswp' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</section>

</main>

<?php get_footer(); ?>
