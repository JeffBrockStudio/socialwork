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
        wp_get_theme()->get('Version') 
    );

    wp_enqueue_style( 'socialwork-style', get_stylesheet_directory_uri() . '/custom.css',
        array( $parenthandle ), 
        wp_get_theme()->get('Version')
    );

		// Pretty Dropdowns
		wp_enqueue_script( 'pretty-dropdowns', get_stylesheet_directory_uri() . '/src/js/jquery.prettydropdowns.js', 
				array( $parenthandle ),
				wp_get_theme()->get('Version')
		);

		// Custom JavaScript for Social Work
		wp_enqueue_script( 'custom-javascript', get_stylesheet_directory_uri() . '/src/js/custom-javascript.js', 
				array( $parenthandle ),
				wp_get_theme()->get('Version')
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
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'people', 'with_front' => FALSE)			
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
				'search_items'       => __( 'Search name or keyword' ),
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

	// Projects
	register_post_type( 'project',
		array(
			'labels' => array(
				'name'               => __( 'Projects' ),
				'singular_name'      => __( 'Project' ),
				'menu_name'          => __( 'Projects' ),
				'name_admin_bar'     => __( 'Project' ),
				'add_new'            => __( 'Add New' ),
				'add_new_item'       => __( 'Add New Project' ),
				'new_item'           => __( 'New Project' ),
				'edit_item'          => __( 'Edit Project' ),
				'view_item'          => __( 'View Project' ),
				'all_items'          => __( 'All Projects' ),
				'search_items'       => __( 'Search name or keyword' ),
				'parent_item_colon'  => __( 'Parent Projects:' ),
				'not_found'          => __( 'No projects found.' ),
				'not_found_in_trash' => __( 'No projects found in Trash.' )
			),
			'menu_icon' => 'dashicons-clipboard',			
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


/**
 * Show links to authors.
 */
function show_authors($resources) { ?>
	<p class="authors">
		<strong><?php 
			if (count($resources) == 1):
				_e( 'Authors', 'socialwork');
			else:
				_e( 'Author(s)', 'socialwork');
			endif; ?>:
		</strong>
		<?php
		$i = 1;
		foreach ($resources as $post):
			setup_postdata($post); ?>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			<?php
			if ($i < count($resources)):
				echo ' | ';
			endif;
			$i++;
		endforeach;
		wp_reset_postdata(); ?>
	</p>
	<?php
}


/**
 * Add custom CSS/JS for Advanced Custom Fields.
 */
function custom_acf_admin_head() {
	?>
	<style type="text/css">
		.acf-editor-wrap iframe {
		    max-height: 400px;
		}

		.short .acf-editor-wrap iframe {
		    max-height: 160px;
		    min-height: 0;
		}

		.short .acf-editor-wrap 	.mce-menubar {
			display: none;
		}
		
		.acf-tab-group {
			padding-left: 0;
		}		
				
		/* Add border between repeater items */		
		.acf-repeater.-block .ui-sortable tr.acf-row td {
 			border-bottom: 4px solid #F9F9F9;
 			border-top: 4px solid #F9F9F9;
		}

		.acf-repeater.-block .ui-sortable tr.acf-row:first-child td {
			border-top: none;
		}

		.acf-repeater.-block .ui-sortable tr.acf-row:nth-last-child(2) td {
			border-bottom: none;
		}
		
		.acf-repeater.-block .acf-row-handle .acf-icon {
			margin-top: -14px;
		}
		
		/* Hide unnecessary label in sidebar ACF */
		#side-sortables .acf-field-image .acf-label {
			display: none;
		}		
		
		/* Hide unnecessary taxonomies in sidebar ACF */
		#side-sortables #publication_typesdiv,
		#side-sortables #team_rolesdiv {
			display: none;			
		}
		
		/* Color palette field */
		.acf-palette-field-layout .acf-palette-label:before {
			border-color: #ffffff;
		}				
		
		/* Make SVG icons 100% width */
		.acf-image-uploader .image-wrap {
			max-width: 100% !important;
			width: 100%;
		}
		
		/* TinyMCE */
		.mce-edit-area {
			padding-left: 1rem !important;
			padding-right: 1rem !important;
		}		
		.mce-edit-area iframe {
			margin-top: 1rem;
		}				
				
	</style>

	<script type="text/javascript">
	(function($){

	  jQuery('#pageparentdiv label[for=menu_order]').parents('p').eq(0).remove();
	  jQuery('#pageparentdiv input#menu_order').remove();

	})(jQuery);
	</script>
		
	<?php
}
add_action('acf/input/admin_head', 'custom_acf_admin_head');


/**
 * Tell SearchWP to index the Title from a Relationship ACF field instead of the post ID
 * https://searchwp.com/documentation/knowledge-base/process-acf-fields-to-index-expected-data/
 */
add_filter( 'searchwp\source\post\attributes\meta', function( $meta_value, $args ) {
  $acf_field_name = 'resource_authors'; // The ACF Relationship field name.

  // If we're not indexing the Read Next field, return the existing meta value.
  // This logic also works for sub-fields of an ACF field as well.
  if ( $acf_field_name !== substr( $args['meta_key'], strlen( $args['meta_key'] ) - strlen( $acf_field_name ) ) ) {
    return $meta_value;
  }

  // We're going to store all of our Titles together as one string for SearchWP to index.
  $content_to_index = '';
  if ( is_array( $meta_value ) && ! empty( $meta_value ) ) {
    foreach ( $meta_value[0] as $acf_relationship_item ) {
      if ( is_numeric( $acf_relationship_item ) ) {
        // ACF stores only the post ID but we want the Title.
        $content_to_index .= ' ' . get_the_title( absint( $acf_relationship_item ) );
      
        // If you want to index anything else, you can append it to $content_to_index.
      }
    }
  }

  // Return the string of content we want to index instead of the data stored by ACF.
  return $content_to_index;
}, 20, 2 );

// Project Principal Investigators
add_filter( 'searchwp\source\post\attributes\meta', function( $meta_value, $args ) {
  $acf_field_name = 'project_principal_investigators';

  if ( $acf_field_name !== substr( $args['meta_key'], strlen( $args['meta_key'] ) - strlen( $acf_field_name ) ) ) {
    return $meta_value;
  }

  $content_to_index = '';
  if ( is_array( $meta_value ) && ! empty( $meta_value ) ) {
    foreach ( $meta_value[0] as $acf_relationship_item ) {
      if ( is_numeric( $acf_relationship_item ) ) {
        $content_to_index .= ' ' . get_the_title( absint( $acf_relationship_item ) );
      }
    }
  }

  return $content_to_index;
}, 20, 2 );

// Project Co-Investigators
add_filter( 'searchwp\source\post\attributes\meta', function( $meta_value, $args ) {
  $acf_field_name = 'project_co_investigators';

  if ( $acf_field_name !== substr( $args['meta_key'], strlen( $args['meta_key'] ) - strlen( $acf_field_name ) ) ) {
    return $meta_value;
  }

  $content_to_index = '';
  if ( is_array( $meta_value ) && ! empty( $meta_value ) ) {
    foreach ( $meta_value[0] as $acf_relationship_item ) {
      if ( is_numeric( $acf_relationship_item ) ) {
        $content_to_index .= ' ' . get_the_title( absint( $acf_relationship_item ) );
      }
    }
  }

  return $content_to_index;
}, 20, 2 );

// Project Other Investigators
add_filter( 'searchwp\source\post\attributes\meta', function( $meta_value, $args ) {
  $acf_field_name = 'project_other_investigators';

  if ( $acf_field_name !== substr( $args['meta_key'], strlen( $args['meta_key'] ) - strlen( $acf_field_name ) ) ) {
    return $meta_value;
  }

  $content_to_index = '';
  if ( is_array( $meta_value ) && ! empty( $meta_value ) ) {
    foreach ( $meta_value[0] as $acf_relationship_item ) {
      if ( is_numeric( $acf_relationship_item ) ) {
        $content_to_index .= ' ' . get_the_title( absint( $acf_relationship_item ) );
      }
    }
  }

  return $content_to_index;
}, 20, 2 );


// Generate Google Scholar link from publication title
function generate_google_scholar_link( $post_id ) {
	$post_title = get_the_title( $post_id );
	$encoded_title = urlencode( $post_title );
	$google_scholar_link = "https://scholar.google.com/scholar?q={$encoded_title}";

	return $google_scholar_link;
}

function generate_downloadable_file() {
	// Set the content type to the appropriate file type
	header('Content-Type: application/octet-stream');

	// Set the filename and force download
	header('Content-Disposition: attachment; filename="example.txt"');

	// Generate the file content
	$file_content = "This is an example file.";

	// Output the file content
	echo $file_content;
}

function generate_endnote_file() {
	// Set the content type to XML
	header('Content-Type: text/xml');

	// Set the filename and force download
	header('Content-Disposition: attachment; filename="endnote.xml"');

	// Create the XML content
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml></xml>');

	// Add the root element
	$records = $xml->addChild('records');

	// Add the record elements
	$record = $records->addChild('record');
	$record->addAttribute('xmlns', 'http://www.endnote.com/xmlexport');

	// Add the title element
	$title = $record->addChild('titles');
	$title->addChild('title', 'Example Title');

	// Add the author elements
	$authors = $record->addChild('authors');
	$author = $authors->addChild('author');
	// Output the XML content
	echo $xml->asXML();
}


/**
 * Register additional menus.
 */
function socialwork_register_menus() {
	register_nav_menus(
		array(
			'about-menu'          => __( 'About Sidebar Menu' ),
			'admissions-menu'     => __( 'Admissions Sidebar Menu' ),
			'academics-menu'      => __( 'Academics Sidebar Menu' ),
			'student-life-menu'   => __( 'Student Life Sidebar Menu' ),
			'faculty-menu'        => __( 'Faculty Sidebar Menu' ),
			'research-menu'       => __( 'Research Sidebar Menu' ),
			'alumni-friends-menu' => __( 'Alumni & Friends Sidebar Menu' ),
			'news-events-menu'    => __( 'News & Events Sidebar Menu' ),
			'give-now-menu'       => __( 'Give Now Sidebar Menu' )
		)
	);
}
add_action( 'init', 'socialwork_register_menus' );

