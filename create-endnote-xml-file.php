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
$publication_type_id = $publication_type->term_id;

// Get the mapped Endnote reference type, from ACF category field
$endnote_reference_type = get_field('endnote_reference_type', 'publication_types_' . $publication_type_id);

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

// Set the content type to XML
header('Content-Type: text/xml');

// Set the filename and force download
//header('Content-Disposition: attachment; filename="endnote.xml"');

// Create the XML content
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><xml></xml>');

// Add the root element
$records = $xml->addChild('records');

// Add the record element
$record = $records->addChild('record');

// Add the source-app element
$source_app = $record->addChild('source-app', 'UW School of Social Work Website');
$source_app->addAttribute('name', 'UWSSW-Website');
$source_app->addAttribute('version', '1.0');

// Add the ref-type element
$ref_type = $record->addChild('ref-type', $endnote_reference_type);

// Add the contributors element
$contributors = $record->addChild('contributors');

// Add the authors element
$authors = $contributors->addChild('authors');

if ($publication_author_list):

  // Convert author_list to an array
  $authors_array = explode(';', $publication_author_list);
  foreach ($authors_array as $author_name):

    // Add the author element
    $author = $authors->addChild('author');
    $style = $author->addChild('style', trim($author_name));
    $style->addAttribute('face', 'normal'); 
    $style->addAttribute('font', 'default');
    $style->addAttribute('size', '100%');

  endforeach;

elseif ($publication_authors):

  // Loop through the authors and add them to the XML
  $posts = $publication_authors;
  foreach ($posts as $post):
    setup_postdata($post); 

    // Add the author element
    $author = $authors->addChild('author');
    $style = $author->addChild('style', get_the_title());
    $style->addAttribute('face', 'normal'); 
    $style->addAttribute('font', 'default');
    $style->addAttribute('size', '100%');

  endforeach;
  wp_reset_postdata();

endif;

// Add the titles element
$titles = $record->addChild('titles');

// Add the title element
$title = $titles->addChild('title');
$style = $title->addChild('style', $publication_title);
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

if ($publication_name):
  // Add the secondary title element
  $secondary_title = $titles->addChild('secondary-title');
  $style = $secondary_title->addChild('style', $publication_name);
  $style->addAttribute('face', 'normal'); 
  $style->addAttribute('font', 'default');
  $style->addAttribute('size', '100%');
endif;

// Add the dates element
$dates = $record->addChild('dates');

// Add the year element
$year = $dates->addChild('year');
$style = $year->addChild('style', $publication_year);
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

if ($publication_date_published):
  // Add the pub-dates element
  $pub_dates = $dates->addChild('pub-dates');

  // Clean up legacy formatting
  $publication_date_published = str_replace('Date Published: ', '', $publication_date_published); 
  $publication_date_published = str_replace(' ;', '', $publication_date_published); 

  // Add the date element
  $date = $pub_dates->addChild('date');
  $style = $date->addChild('style', $publication_date_published);
  $style->addAttribute('face', 'normal'); 
  $style->addAttribute('font', 'default');
  $style->addAttribute('size', '100%');
endif;

if ($publication_volume):

  // Clean up legacy formatting
  $publication_volume = str_replace('Volume: ', '', $publication_volume); 
  $publication_volume = str_replace(' ;', '', $publication_volume); 

  // Add the volume element
  $volume = $record->addChild('volume');
  $style = $volume->addChild('style', $publication_volume);
  $style->addAttribute('face', 'normal'); 
  $style->addAttribute('font', 'default');
  $style->addAttribute('size', '100%');
endif;   

if ($publication_pagination):
 
  // Clean up legacy formatting
  $publication_pagination = str_replace('Pagination: ', '', $publication_pagination); 
  $publication_pagination = str_replace(' ;', '', $publication_pagination); 

  // Add the pages element
  $pages = $record->addChild('pages');
  $style = $pages->addChild('style', $publication_pagination);
  $style->addAttribute('face', 'normal'); 
  $style->addAttribute('font', 'default');
  $style->addAttribute('size', '100%');
endif;

// Add the language element
$language = $record->addChild('language');
$style = $language->addChild('style', 'eng');
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

if ($publication_issue):

  // Clean up legacy formatting
  $publication_issue = str_replace('Issue: ', '', $publication_issue); 
  $publication_issue = str_replace(' ;', '', $publication_issue); 

  // Add the issue element
  $issue = $record->addChild('issue');
  $style = $issue->addChild('style', $publication_issue);
  $style->addAttribute('face', 'normal'); 
  $style->addAttribute('font', 'default');
  $style->addAttribute('size', '100%');
endif;


// Output the XML content
echo $xml->asXML();

// Stop the script from running
die;
exit;
?>