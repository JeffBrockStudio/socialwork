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



remove_filter( 'the_content', 'wpautop' );


/**
 * Theme shortcodes.
*/
require get_stylesheet_directory() . '/inc/shortcodes/shortcodes.php';


/**
 * Register custom post types.
 */
function custom_create_post_types() {

	// Team Member
	register_post_type( 'team',
		array(
			'labels' => array(
				'name'               => __( 'Team Member' ),
				'singular_name'      => __( 'Team Member' ),
				'menu_name'          => __( 'Team Members' ),
				'name_admin_bar'     => __( 'Team Member' ),
				'add_new'            => __( 'Add New' ),
				'add_new_item'       => __( 'Add New Team Member' ),
				'new_item'           => __( 'New Team Member' ),
				'edit_item'          => __( 'Edit Team Member' ),
				'view_item'          => __( 'View Team Member' ),
				'all_items'          => __( 'All Team Members' ),
				'search_items'       => __( 'Search Team Members' ),
				'parent_item_colon'  => __( 'Parent Team Members:' ),
				'not_found'          => __( 'No team members found.' ),
				'not_found_in_trash' => __( 'No team members found in Trash.' )
			),
			'menu_icon' => 'dashicons-groups',			
			'public' => true,
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'has_archive' => true			
		)
	);	
	
	// Publications
	register_post_type( 'resource',
		array(
			'labels' => array(
				'name'               => __( 'Publications' ),
				'singular_name'      => __( 'Publication' ),
				'menu_name'          => __( 'Publications' ),
				'name_admin_bar'     => __( 'Publication' ),
				'add_new'            => __( 'Add New' ),
				'add_new_item'       => __( 'Add New Publication' ),
				'new_item'           => __( 'New Publication' ),
				'edit_item'          => __( 'Edit Publication' ),
				'view_item'          => __( 'View Publication' ),
				'all_items'          => __( 'All Publications' ),
				'search_items'       => __( 'Search Publications' ),
				'parent_item_colon'  => __( 'Parent Publications:' ),
				'not_found'          => __( 'No publications found.' ),
				'not_found_in_trash' => __( 'No publications found in Trash.' )
			),
			'menu_icon' => 'dashicons-analytics',			
			'public' => true,
			'hierarchical' => true,
			'supports' => array( 'title', 'editor' ),
			'has_archive' => true			
		)
	);	
}
add_action( 'init', 'custom_create_post_types' );


/**
 * Add excerpt to custom post types.
 */
function custom_add_excerpt_support_for_cpt() {
 add_post_type_support( 'project', 'excerpt' );
}
//add_action( 'init', 'custom_add_excerpt_support_for_cpt' );


/**
 * Add custom taxonomies
 */
function custom_add_custom_taxonomies() {
	
	// Team Roles
	register_taxonomy('team_roles', 'team', 
		array(
			'labels' => array(
				'name'                       => __( 'Team Roles' ),
				'singular_name'              => __( 'Team Role' ),
				'menu_name'                  => __( 'Team Roles' ),
				'all_items'                  => __( 'All Team Roles' ),
				'parent_item'                => __( 'Parent Team Role' ),
				'parent_item_colon'          => __( 'Parent Team Role' ),
				'new_item_name'              => __( 'New Team Role Name' ),
				'add_new_item'               => __( 'Add Team Role' ),
				'edit_item'                  => __( 'Edit Team Role' ),
				'update_item'                => __( 'Update Team Role' ),
				'view_item'                  => __( 'View Team Role' ),
				'separate_items_with_commas' => __( 'Separate team roles with commas' ),
				'add_or_remove_items'        => __( 'Add or remove team roles' ),
				'choose_from_most_used'      => __( 'Choose from the most used' ),
				'popular_items'              => __( 'Popular Team Roles' ),
				'search_items'               => __( 'Search Team Roles' ),
				'not_found'                  => __( 'Not Found' ),
				'no_terms'                   => __( 'No items' ),
				'items_list'                 => __( 'Team Roles list' ),
				'items_list_navigation'      => __( 'Team Roles list navigation' )
			),		
			'label' => __( 'Team Roles' ),
			'hierarchical' => true		
		)
	);	
	
	// Publication Types	
	register_taxonomy('publication_types', 'resource', 
		array(
			'labels' => array(
				'name'                       => __( 'Publication Types' ),
				'singular_name'              => __( 'Publication Type' ),
				'menu_name'                  => __( 'Types' ),
				'all_items'                  => __( 'All Publication Types' ),
				'parent_item'                => __( 'Parent Publication Type' ),
				'parent_item_colon'          => __( 'Parent Publication Type' ),
				'new_item_name'              => __( 'New Publication Type Name' ),
				'add_new_item'               => __( 'Add Publication Type' ),
				'edit_item'                  => __( 'Edit Publication Type' ),
				'update_item'                => __( 'Update Publication Type' ),
				'view_item'                  => __( 'View Publication Type' ),
				'separate_items_with_commas' => __( 'Separate publication types with commas' ),
				'add_or_remove_items'        => __( 'Add or remove publication types' ),
				'choose_from_most_used'      => __( 'Choose from the most used' ),
				'popular_items'              => __( 'Popular Publication Types' ),
				'search_items'               => __( 'Search Publication Types' ),
				'not_found'                  => __( 'Not Found' ),
				'no_terms'                   => __( 'No items' ),
				'items_list'                 => __( 'Publication Types list' ),
				'items_list_navigation'      => __( 'Publication Types list navigation' )
			),		
			'label' => __( 'Publication Types' ),
			'hierarchical' => true		
		)
	);

};
add_action( 'init', 'custom_add_custom_taxonomies', 0 );

/**
 * Team shortcode
 */
function custom_team($atts) {
	
	$atts = shortcode_atts(array(
      'team_roles' => 'faculty'
   ), $atts);	
   
  ob_start();
	require('team.php');
    
  // Save output and stop output buffering
  $output = ob_get_clean();
  
    // Return $post to its original state
   wp_reset_postdata();
  
    // Return buffered output to be output in shortcode location
   return $output;
  
}
add_shortcode('team', 'custom_team');


/**
 * Publications shortcode
 */
function custom_resources($atts) {
  
  ob_start();
  require('resources.php');
    
  // Save output and stop output buffering
  $output = ob_get_clean();
  
  // Return $post to its original state
  wp_reset_postdata();
  
  // Return buffered output to be output in shortcode location
  return $output;
  
}
add_shortcode('publications', 'custom_resources');


/**
 * Admin Columns Pro local storage
 */
add_filter( 'acp/storage/file/directory', function() {
	// Use a writable path, directory will be created for you
	return get_stylesheet_directory() . '/acp-settings';
} );


/**
 * Unregister tags for posts
 */
function alter_taxonomy_for_post() {
	unregister_taxonomy_for_object_type('post_tag', 'post');
}
add_action( 'init', 'alter_taxonomy_for_post' );


/**
 * Disable post formats
 */
function remove_post_formats() { 
	remove_theme_support('post-formats'); 
} 
add_action( 'after_setup_theme', 'remove_post_formats', 11 );


/**
 * Move Yoast SEO to bottom of edit screen.
 */
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

