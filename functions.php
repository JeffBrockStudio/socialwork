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
 * Allow or remove wpautop based on criteria
 */
function conditional_wpautop($content) {
    // true  = wpautop is  ON  unless any exceptions are met
    // false = wpautop is  OFF unless any exceptions are met
    $wpautop_on_by_default = false;

    // List exceptions here (each exception should either return true or false)
    $exceptions = array(
        is_page_template('page-example-template.php'),
        is_page('example-page'),
    );

    // Checks to see if any exceptions are met // Returns true or false
    $exception_is_met = in_array(true, $exceptions);

    // Returns the content
    if ($wpautop_on_by_default==$exception_is_met) {
        remove_filter('the_content','wpautop');
        return $content;
    } else {
        return $content;
    }
}
//add_filter('the_content', 'conditional_wpautop', 9);

// remove_filter( 'the_content', 'wpautop' );
// add_filter( 'the_content', 'wpautop' , 99 );
// add_filter( 'the_content', 'shortcode_unautop', 100 );