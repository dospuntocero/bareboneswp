<?php

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');

//    add_image_size('large', 700, '', true); // Large Thumbnail
//    add_image_size('medium', 250, '', true); // Medium Thumbnail
//    add_image_size('small', 120, '', true); // Small Thumbnail
//    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');


	//best wordpress crap cleaner on earth
	add_theme_support('soil-clean-up');
	add_theme_support('soil-disable-rest-api');
	add_theme_support('soil-disable-asset-versioning');
	add_theme_support('soil-disable-trackbacks');
	add_theme_support('soil-google-analytics', 'UA-XXXXX-Y');
	add_theme_support('soil-jquery-cdn');
	add_theme_support('soil-js-to-footer');
	add_theme_support('soil-nav-walker');
	add_theme_support('soil-nice-search');
	add_theme_support('soil-relative-urls');

}




/*------------------------------------*\
	Functions
\*------------------------------------*/

register_nav_menus([
	'main-menu' => __('Header Menu', 'bboneswp'), // Main Menu
	'footer-menu' => __('Footer Menu', 'bboneswp') // Footer Menu
]);


// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function bboneswp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function bboneswp_index($length) // Create 20 Word Callback for Index page Excerpts, call using bboneswp_excerpt('bboneswp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using bboneswp_excerpt('bboneswp_custom_post');
function bboneswp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function bboneswp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}


// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}



/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/


// Add Filters
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)


add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether



/*------------------------------------*\
	wp_enqueue_scripts
\*------------------------------------*/

function basetheme_theme_scripts() {
    /*
    wp_enqueue_script(
        'foundation-js',
        get_template_directory_uri().'/assets/js/lib/foundation.6.5.1.min.js',
        array( 'jquery' ),
        '6.5.1',
        true
    );
    */
    /*
    wp_enqueue_script(
        'font-awesome-js',
        get_template_directory_uri().'/assets/js/lib/font-awesome-all.5.9.0.min.js',
        array( 'jquery' ),
        '5.9.0',
        true
    );
    */
    /*
    wp_enqueue_script(
        'slick-js',
        get_template_directory_uri().'/assets/js/lib/slick.1.9.0.min.js',
        array( 'jquery' ),
        '1.9.0',
        true
    );
    */
    /*
    wp_enqueue_script(
        'jquery-modal-video-js',
        get_template_directory_uri().'/assets/js/lib/jquery-modal-video.2.4.1.min.js',
        array( 'jquery' ),
        '2.4.1',
        true
    );
    */
    /*
    wp_enqueue_script(
        'isotope-js',
        get_template_directory_uri().'/assets/js/lib/isotope.3.0.6.min.js',
        array( 'jquery' ),
        '3.0.6',
        true
    );
    */

	// Theme scripts
	$theme_js = '/assets/js/app.js';
	wp_register_script( 'theme-js', get_stylesheet_directory_uri() . $theme_js, false, filemtime( get_template_directory() . $theme_js ), true );
	wp_enqueue_script( 'theme-js' );

	// Theme styles
	$theme_css = '/assets/css/app.css';
	wp_enqueue_style( 'theme', get_stylesheet_directory_uri() . $theme_css, array(), filemtime( get_template_directory() . $theme_css ), 'all' );

}

add_action( 'wp_enqueue_scripts', 'basetheme_theme_scripts' );



/*------------------------------------*\
	Theme Options
\*------------------------------------*/

if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title'    => 'Theme Settings',
		'menu_title'    => 'Theme Settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	) );
}
