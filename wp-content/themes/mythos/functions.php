<?php
define( 'MYTHOS_CSS', get_template_directory_uri().'/css/' );
define( 'MYTHOS_JS', get_template_directory_uri().'/js/' );
define( 'MYTHOS_DIR', get_template_directory() );
define( 'MYTHOS_URI', trailingslashit(get_template_directory_uri()) );


/* -------------------------------------------- *
 * Include TGM Plugins
 * -------------------------------------------- */
get_template_part('lib/class-tgm-plugin-activation');


/* -------------------------------------------- *
 * Include Dashboard Options
 * -------------------------------------------- */
get_template_part('lib/dashboard');


/* -------------------------------------------- *
* Navwalker
* -------------------------------------------- */
get_template_part('lib/menu/admin-megamenu-walker');
get_template_part('lib/menu/meagmenu-walker');
get_template_part('lib/menu/mobile-navwalker');

if( !function_exists('mythos_megamenu_walker_callback') ){
	function mythos_megamenu_walker_callback($class, $menu_id){
		return 'mythos_Megamenu_Walker';
	}
}
add_filter( 'wp_edit_nav_menu_walker','mythos_megamenu_walker_callback', 10, 2 );

/* -------------------------------------------- *
 * Mythos Register
 * -------------------------------------------- */
get_template_part('lib/main-function/mythos-register');

/* -------------------------------------------- *
 * Mythos Core
 * -------------------------------------------- */
get_template_part('lib/main-function/mythos-core');
get_template_part('woocommerce/mythos-color-variations');


// Comments
include( get_parent_theme_file_path('lib/mythos_comment.php') );

// Comments Callback Function
include( get_parent_theme_file_path('lib/mythos-comments.php') );

/* -------------------------------------------- *
 * Customizer
 * -------------------------------------------- */
get_template_part('lib/customizer/libs/googlefonts');
get_template_part('lib/customizer/customizer');

/* -------------------------------------------- *
 * Custom Excerpt Length
 * -------------------------------------------- */
if(!function_exists('mythos_excerpt_max_charlength')):
	function mythos_excerpt_max_charlength($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				return mb_substr( $subex, 0, $excut );
			} else {
				return $subex;
			}
		} else {
			return $excerpt;
		}
	}
endif;

/* -------------------------------------------- *
 * Custom body class
 * -------------------------------------------- */
add_filter( 'body_class', 'mythos_body_class' );
function mythos_body_class( $classes ) {
    $layout = get_theme_mod( 'boxfull_en', 'fullwidth' );
    $classes[] = $layout.'-bg'.' body-content';
	return $classes;
}

/* ------------------------------------------- *
 * Add a pingback url auto-discovery header for 
 * single posts, pages, or attachments
 * ------------------------------------------- */
function mythos_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'mythos_pingback_header' );
