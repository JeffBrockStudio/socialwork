<?php
// Include core WordPress files
require_once('../../../wp-load.php');

// Get publication ID from the URL
$publication_id = $_GET['publication_id'];

// Get the publication post
$publication = get_post($publication_id);

// Get the publication type term from taxonomy
$publication_type = get_the_terms($publication_id, 'publication_types');
$publication_type = $publication_type[0];

// Get the publication title
$publication_title = $publication->post_title;

// Get the name of the publication
$publication_name = get_field( 'resource_publication_name', $publication_id );

// Get the publication year
$publication_year = get_field('resource_year', $publication_id);

// Get the publication author list (being used temporarily)
$publication_author_list = get_field('resource_author_list', $publication_id);

// Get the publication authors
$publication_authors = get_field('resource_authors', $publication_id);

// Get the publication volume
$publication_volume = get_field('resource_volume', $publication_id);

// Get the publication issue
$publication_issue = get_field('resource_issue', $publication_id);

// Get the publication pagination
$publication_pagination = get_field('resource_pagination', $publication_id);

// Get the publication date published
$publication_date_published = get_field('resource_date_published', $publication_id);

// Get the publication locator URL
$publication_locator_url = get_field('resource_locator_url', $publication_id);

// Get the publication locator DOI
$publication_locator_doi = get_field('resource_locator_doi', $publication_id);

// Set the content type to text
header('Content-Type: text/*');

// Set the filename and force download
header('Content-Disposition: attachment; filename="endnote.enw"');

// Add the ref-type element
echo '%0 ' . $publication_type->name . '
'; 

if ($publication_name):
  // Add the secondary title element
  echo '%J ' . $publication_name . '
'; 
endif;

if ($publication_year):
  // Add the year element
  echo '%D ' . $publication_year . '
';
endif;

// Add the title element
echo '%T ' . $publication_title . '
';

if ($publication_author_list):

  // Convert author_list to an array
  $authors_array = explode(';', $publication_author_list);
  foreach ($authors_array as $author_name):

    // Add the author element
    echo '%A ' . trim($author_name) . '
';

  endforeach;

elseif ($publication_authors):

  // Loop through the authors and add them to the XML
  $posts = $publication_authors;
  foreach ($posts as $post):
    setup_postdata($post); 

    // Add the author element
    echo '%A ' . trim(get_the_title()) . '
  ';

  endforeach;
  wp_reset_postdata();

endif;

// Get the_content
$publication_content = $publication->post_content;

if ($publication_content != ''):

  // Remove line breaks
  $publication_content = str_replace(array("\r", "\n"), '', $publication_content);

  // Add the abstract element
  echo '%X ' . $publication_content . '
';
endif;

if ($publication_name):
  // Add the secondary title element
  echo '%B ' . $publication_name . '
'; 
endif;

if ($publication_volume):

  // Clean up legacy formatting
  $publication_volume = str_replace('Volume: ', '', $publication_volume); 
  $publication_volume = str_replace(' ;', '', $publication_volume); 

  // Add the volume element
  echo '%V ' . $publication_volume . '
';
endif;   

if ($publication_pagination):
 
  // Clean up legacy formatting
  $publication_pagination = str_replace('Pagination: ', '', $publication_pagination); 
  $publication_pagination = str_replace(' ;', '', $publication_pagination); 

  // Add the pages element
  echo '%P ' . $publication_pagination . '
';
endif;

if ($publication_date_published):

  // Clean up legacy formatting
  $publication_date_published = str_replace('Date Published: ', '', $publication_date_published); 
  $publication_date_published = str_replace(' ;', '', $publication_date_published); 

  // Add the date element
  echo '%8 ' . $publication_date_published . '
';
endif;

// Add the language element
echo '%G eng
';

if ($publication_locator_url):

  // Add the Locator URL element
  echo '%U ' . $publication_locator_url . '
';
endif;

if ($publication_issue):

  // Clean up legacy formatting
  $publication_issue = str_replace('Issue: ', '', $publication_issue); 
  $publication_issue = str_replace(' ;', '', $publication_issue); 

  // Add the issue element
  echo '%N ' . $publication_issue . '
';
endif;

if ($publication_locator_doi):

  // Add the DOI element
  echo '%R ' . $publication_locator_doi . '
';
endif;

// Stop the script from running
exit;
?>