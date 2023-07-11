<?php
/**
 * UW School of Social Work WordPress Theme.
 */

 // enqueue child childsheet, require the uw_wp_theme bootstrap style sheet
 
add_action( 'wp_enqueue_scripts', 'uw_child_enqueue_styles', 11 );

function uw_child_enqueue_styles() {
	$parenthandle = 'uw_wp_theme-bootstrap';
	
	wp_enqueue_style( 'uw_wp_theme-child-style', get_stylesheet_uri(),
        array( $parenthandle ), 
        wp_get_theme()->get('Version') // this only works if you have Version in the style header
    );

    wp_enqueue_style( 'socialwork-style', get_stylesheet_directory_uri() . '/custom.css',
        array( $parenthandle ), 
        wp_get_theme()->get('Version') // this only works if you have Version in the style header
    );
}

/**
 * Remove empty paragraphs created by wpautop()
 * @author Ryan Hamilton
 * @link https://gist.github.com/Fantikerz/5557617
 */
function remove_empty_p( $content ) {
	$content = force_balance_tags( $content );
	$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
	$content = preg_replace( '~\s?<p>(\s| )+</p>\s?~', '', $content );
	return $content;
}
add_filter('the_content', 'remove_empty_p', 20, 1);


/**
 * Theme shortcodes.
*/
require get_stylesheet_directory() . '/inc/shortcodes/shortcodes.php';
