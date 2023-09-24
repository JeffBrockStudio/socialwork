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

// Get the publication authors
$publication_authors = get_field('resource_authors', $publication_id);

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

// Add the record elements
$record = $records->addChild('record');
$record->addAttribute('xmlns', 'http://www.endnote.com/xmlexport');

// Add the source-app element
$source_app = $record->addChild('source-app', 'UW School of Social Work Website');
$source_app->addAttribute('name', 'UWSSW-Website');
$source_app->addAttribute('version', '1.0');

// Add the ref-type element
$ref_type = $record->addChild('ref-type', $endnote_reference_type);

// Add the title element
$title = $record->addChild('titles');
$title->addChild('title', $publication_title);

// Add the author elements
$authors = $record->addChild('authors');
$author = $authors->addChild('author');
$author->addChild('first', 'John');
$author->addChild('last', 'Doe');

// Add the year element
$record->addChild('dates', $publication_year);

// Output the XML content
echo $xml->asXML();

// Stop the script from running
die;
exit;
?>