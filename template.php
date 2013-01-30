<?php

/**
 * Override or insert variables into the page template.
 */
function msp_preprocess_page(&$vars) {
  // Get the alias for the page being viewed
  $alias = drupal_get_path_alias($_GET['q']);
  if ($alias != $_GET['q']) {
    $template_filename = 'page';

    //Break it down for each piece of the alias path
    foreach (explode('/', $alias) as $path_part) {
      $template_filename = $template_filename . '--' . $path_part;
      $variables['theme_hook_suggestions'][] = $template_filename;
    }
  }
}

/**
 * Override the file icons to our custom styled ones.
 */
function msp_file_icon($variables) {
  $file = $variables['file'];
  $icon_directory = drupal_get_path('theme', 'msp') . '/images/icons';

  $mime = check_plain($file->filemime);
  $icon_url = file_icon_url($file, $icon_directory);
  return '<img alt="" class="file-icon" src="' . $icon_url . '" title="' . $mime . '" />';
}

/**
 * Override the file field links to open in a new window.
 */
function msp_file_link($variables) {
  $file = $variables['file'];
  $icon_directory = $variables['icon_directory'];

  $url = file_create_url($file->uri);
  $icon = theme('file_icon', array('file' => $file, 'icon_directory' => $icon_directory));

  // Set options as per anchor format described at
  // http://microformats.org/wiki/file-format-examples
  $options = array(
    'attributes' => array(
      'type' => $file->filemime . '; length=' . $file->filesize,
    ),
  );

  // Use the description as the link text if available.
  if (empty($file->description)) {
    $link_text = $file->filename;
  }
  else {
    $link_text = $file->description;
    $options['attributes']['title'] = check_plain($file->filename);
  }

  // Open files of particular mime types in new window.
  $new_window_mimetypes = array('application/pdf','text/plain');
  if (in_array($file->filemime, $new_window_mimetypes)) {
    $options['attributes']['target'] = '_blank';
  }

  return '<span class="file">' . $icon . ' ' . l($link_text, $url, $options) . '</span>';
}

/**
 * Override the Where to Buy exposed filters to show a dropdown menu.
 */
function msp_form_alter(&$form, &$form_state, $form_id) {
  if($form['#id'] == 'views-exposed-form-where-to-buy-page') {  
    $options = array(
      '' => '--',
      'Alabama' => 'Alabama',
      'Alaska' => 'Alaska',
      'American Samoa' => 'American Samoa',
      'Arizona' => 'Arizona',
      'Arkansas' => 'Arkansas',
      'California' => 'California',
      'Colorado' => 'Colorado',
      'Connecticut' => 'Connecticut',
      'Delaware' => 'Delaware',
      'District of Columbia' => 'District of Columbia',
      'Florida' => 'Florida',
      'Georgia' => 'Georgia',
      'Guam' => 'Guam',
      'Hawaii' => 'Hawaii',
      'Idaho' => 'Idaho',
      'Illinois' => 'Illinois',
      'Indiana' => 'Indiana',
      'Iowa' => 'Iowa',
      'Kansas' => 'Kansas',
      'Kentucky' => 'Kentucky',
      'Louisiana' => 'Louisiana',
      'Maine' => 'Maine',
      'Maryland' => 'Maryland',
      'Massachusetts' => 'Massachusetts',
      'Michigan' => 'Michigan',
      'Minnesota' => 'Minnesota',
      'Mississippi' => 'Mississippi',
      'Missouri' => 'Missouri',
      'Montana' => 'Montana',
      'Nebraska' => 'Nebraska',
      'Nevada' => 'Nevada',
      'New Hampshire' => 'New Hampshire',
      'New Jersey' => 'New Jersey',
      'New Mexico' => 'New Mexico',
      'New York' => 'New York',
      'North Carolina' => 'North Carolina',
      'North Dakota' => 'North Dakota',
      'Northern Marianas Islands' => 'Northern Marianas Islands',
      'Ohio' => 'Ohio',
      'Oklahoma' => 'Oklahoma',
      'Oregon' => 'Oregon',
      'Pennsylvania' => 'Pennsylvania',
      'Puerto Rico' => 'Puerto Rico',
      'Rhode Island' => 'Rhode Island',
      'South Carolina' => 'South Carolina',
      'South Dakota' => 'South Dakota',
      'Tennessee' => 'Tennessee',
      'Texas' => 'Texas',
      'Utah' => 'Utah',
      'Vermont' => 'Vermont',
      'Virginia' => 'Virginia',
      'Virgin Islands' => 'Virgin Islands',
      'Washington' => 'Washington',
      'West Virginia' => 'West Virginia',
      'Wisconsin' => 'Wisconsin',
      'Wyoming' => 'Wyoming',
    );
  
    $form['field_state_value']['#type'] = 'select';
    $form['field_state_value']['#options'] = $options;
    $form['field_state_value']['#default_value'] = array();
    $form['field_state_value']['#multiple'] = FALSE;
    $form['field_state_value']['#size'] = 1;
  }
}
