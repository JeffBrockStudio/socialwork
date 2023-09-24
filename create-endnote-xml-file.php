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

// Get the name of the publication (journal, book, etc.)
$publication_name = get_field( 'resource_publication_name', $publication_id );

// Get the publication year
$publication_year = get_field('resource_year', $publication_id);

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

// Get the publication authors
$publication_authors = get_field('resource_authors', $publication_id);
$posts = $publication_authors;
$i = 1;
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

// Add the titles element
$titles = $record->addChild('titles');

// Add the title element
$title = $titles->addChild('title');
$style = $title->addChild('style', $publication_title);
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Add the secondary title element
$secondary_title = $titles->addChild('secondary-title');
$style = $secondary_title->addChild('style', $publication_name);
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Add the dates element
$dates = $record->addChild('dates');

// Add the year element
$year = $dates->addChild('year');
$style = $year->addChild('style', $publication_year);
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Add the pub-dates element
$pub_dates = $dates->addChild('pub-dates');

// Add the date element
$date = $pub_dates->addChild('date');
$style = $date->addChild('style', 'TEST');
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Add the volume element
$volume = $record->addChild('volume');
$style = $volume->addChild('style', 'VOLUME');
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Add the pages element
$pages = $record->addChild('pages');
$style = $pages->addChild('style', 'PAGES');
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Add the language element
$language = $record->addChild('language');
$style = $language->addChild('style', 'LANGUAGE');
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Add the issue element
$issue = $record->addChild('issue');
$style = $issue->addChild('style', 'ISSUE');
$style->addAttribute('face', 'normal'); 
$style->addAttribute('font', 'default');
$style->addAttribute('size', '100%');

// Output the XML content
echo $xml->asXML();

// Stop the script from running
die;
exit;
?>