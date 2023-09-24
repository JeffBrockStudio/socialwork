<?php

return array (
  'version' => '6.2.2',
  'title' => '',
  'type' => 'resource',
  'id' => '64b3ae95cfae4',
  'updated' => 1695549850,
  'columns' => 
  array (
    'title' => 
    array (
      'type' => 'title',
      'label' => 'Title',
      'width' => '415',
      'width_unit' => 'px',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'name' => 'title',
    ),
    '64b3ae4beac084' => 
    array (
      'type' => 'column-taxonomy',
      'label' => 'Pub Type',
      'width' => '130',
      'width_unit' => 'px',
      'taxonomy' => 'publication_types',
      'term_link_to' => 'filter',
      'number_of_items' => '10',
      'separator' => 'comma',
      'edit' => 'on',
      'enable_term_creation' => 'off',
      'export' => 'on',
      'sort' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3ae4beac084',
    ),
    '650aa9797ced90' => 
    array (
      'type' => 'field_64f21f0402bab',
      'label' => 'Author List',
      'width' => '180',
      'width_unit' => 'px',
      'character_limit' => '30',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '650aa9797ced90',
    ),
    '64b3ae81bbe76c' => 
    array (
      'type' => 'field_64b38d5593f1a',
      'label' => 'Year',
      'width' => '80',
      'width_unit' => 'px',
      'number_format' => '',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3ae81bbe76c',
    ),
    '64b3aea3133334' => 
    array (
      'type' => 'field_64b38c727f6d1',
      'label' => 'Pub Name',
      'width' => '200',
      'width_unit' => 'px',
      'character_limit' => '',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3aea3133334',
    ),
    '64b3aec09e3540' => 
    array (
      'type' => 'field_64b38d7593f1b',
      'label' => 'Pub Info',
      'width' => '130',
      'width_unit' => 'px',
      'character_limit' => '',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3aec09e3540',
    ),
    '65100991e10624' => 
    array (
      'type' => 'column-content',
      'label' => 'Content',
      'width' => '',
      'width_unit' => '%',
      'string_limit' => 'word_limit',
      'excerpt_length' => '20',
      'before' => '',
      'after' => '',
      'edit' => 'on',
      'editable_type' => 'textarea',
      'export' => 'on',
      'sort' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '65100991e10624',
    ),
    '64b3b16fc624dc' => 
    array (
      'type' => 'field_64b38da2ed21b',
      'label' => 'Identifiers',
      'width' => '200',
      'width_unit' => 'px',
      'character_limit' => '',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3b16fc624dc',
    ),
    '64b3b17fcf9db4' => 
    array (
      'type' => 'field_64b38fd5dbcba',
      'label' => 'Locator DOI',
      'width' => '275',
      'width_unit' => 'px',
      'character_limit' => '',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3b17fcf9db4',
    ),
    '64b3b19034fdf4' => 
    array (
      'type' => 'field_64b38dbced21c',
      'label' => 'Locator URL',
      'width' => '300',
      'width_unit' => 'px',
      'link_label' => '',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3b19034fdf4',
    ),
    '64b3aed9ca3d70' => 
    array (
      'type' => 'column-modified',
      'label' => 'Last Modified',
      'width' => '',
      'width_unit' => '%',
      'date_format' => 'F j, Y g:i a',
      'export' => 'on',
      'sort' => 'on',
      'edit' => 'on',
      'bulk_edit' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'filter_format' => '',
      'name' => '64b3aed9ca3d70',
    ),
    '64b3aee8599998' => 
    array (
      'type' => 'column-last_modified_author',
      'label' => 'By',
      'width' => '',
      'width_unit' => '%',
      'display_author_as' => 'display_name',
      'user_link_to' => 'edit_user',
      'export' => 'on',
      'sort' => 'on',
      'search' => 'on',
      'filter' => 'off',
      'filter_label' => '',
      'name' => '64b3aee8599998',
    ),
  ),
  'settings' => 
  array (
    'roles' => 
    array (
    ),
    'users' => 
    array (
    ),
    'sorting' => '0',
    'sorting_order' => 'asc',
    'hide_inline_edit' => 'off',
    'hide_bulk_edit' => 'off',
    'hide_bulk_delete' => 'off',
    'hide_smart_filters' => 'off',
    'hide_segments' => 'off',
    'hide_export' => 'off',
    'hide_conditional_formatting' => 'off',
    'hide_new_inline' => 'on',
    'resize_columns' => 'off',
    'column_order' => 'off',
    'hide_filters' => 'off',
    'hide_filter_post_date' => 'off',
    'hide_submenu' => 'off',
    'hide_search' => 'off',
    'hide_bulk_actions' => 'off',
    'hide_row_actions' => 'off',
    'horizontal_scrolling' => 'on',
    'primary_column' => '',
    'filter_segment' => '',
  ),
);