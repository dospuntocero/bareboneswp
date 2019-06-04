<?php get_header(); ?>

	<main role="main">
		<section>
			<article class="post-404">

				<h1><?php _e( 'Page not found', 'bboneswp' ); ?></h1>
				<h2>
					<a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'bboneswp' ); ?></a>
				</h2>

			</article>
		</section>
	</main>

<?php get_footer(); ?>
