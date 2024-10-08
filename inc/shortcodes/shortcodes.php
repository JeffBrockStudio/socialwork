<?php
/**
 * Shortcodes for socialwork theme.
 *
 * @package socialwork
 */

/**
 * Main function. Runs everything.
 */
function socialwork_shortcodes() {

	// If this is the admin page, do nothing.
	// if ( is_admin() ) {
	// return;
	// }

	$parent = get_stylesheet_directory() . '/inc/shortcodes/';
	// require_once( $parent . 'class.modal-shortcode.php' );
	// require_once( $parent . 'class.button-shortcode.php' );
	// require_once( $parent . 'class.uw-2014-button-shortcode.php' );
	// require_once( $parent . 'class.tile-box-shortcode.php' );
	// require_once( $parent . 'class.trumba-shortcode.php' );
	// require_once( $parent . 'class.trumba-rss-shortcode.php' );
	// require_once( $parent . 'class.menu-shortcode.php' );
	// require_once( $parent . 'class.tagboard-shortcode.php' );
	// require_once( $parent . 'class.grid-shortcode.php' );
	// require_once( $parent . 'class.subpage-list-shortcode.php' );
	// require_once( $parent . 'class.custom-link-shortcode.php' );	
	require_once( $parent . 'class.accordion-shortcode.php' );
	// require_once( $parent . 'class.tabs-tours-shortcode.php' );
	// require_once( $parent . 'class.youtube-shortcode.php' );
	// require_once( $parent . 'class.uw-iframes.php' );
	require_once( $parent . 'class.cards-shortcode.php' );
	// require_once( $parent . 'class.blockquote-shortcode.php' );
	// require_once( $parent . 'class.gallery-shortcode.php' );
	// require_once( $parent . 'class.jumbotron-shortcode.php' );

	// $tilebox     = new UW_TileBox();
	// $button      = new UW_Button();
	// $oldButton   = new UW_2014_Button();
	// $modal       = new UW_Modal();
	// $trumba      = new UW_Trumba();
	// $trumbaRss   = new UW_TrumbaRSS();
	// $menu        = new UW_Menu();
	// $tagboard    = new UW_Tagboard();
	// $grid        = new UW_Grid();
	// $subpageList = new UW_SubpageList();
	// $customLink  = new UW_CustomLinks();
	$accordion   = new SocialWork_Accordion();
	// $tabsTours   = new UW_Tabs_Tours();
	// $youtube     = new UW_Youtube();
	// $iframes     = new UW_Iframes();
	$uwcard      = new SocialWork_Card();
	// $blockquote  = new UW_Blockquote();
	// $gallery     = new UW_Gallery();
	// $jumbotron   = new UW_Jumbotron();

	// call the enqueue scripts for shortcodes.
	add_action( 'wp_enqueue_scripts', 'socialwork_enqueue_shortcodes' );
}
add_action( 'wp_loaded', 'socialwork_shortcodes' );

/**
 * Enqueue and defer shortcode scripts.
 */
function socialwork_enqueue_shortcodes() {
	$template_directory = get_bloginfo( 'stylesheet_directory' );
	$theme_version = wp_get_theme(get_template( ) )->get( 'Version');

	wp_enqueue_script( 'socialwork-custom-link-script', $template_directory . '/js/shortcodes/custom-link.js', array( 'jquery', 'socialwork-popper' ), $theme_version, true );
}
