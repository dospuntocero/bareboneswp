<header class="header clear" role="banner">
	<div class="logo">
		<a href="<?php echo home_url(); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg" alt="Logo" class="logo-img">
		</a>
	</div>
	<nav class="navigation" role="navigation">
        <ul>
	    <?php wp_nav_menu( [
		 'theme_location' => 'main-menu',
		 'container' => '',
		 'items_wrap' => '%3$s'
	    ] ); ?>
        </ul>
	</nav>

</header>
