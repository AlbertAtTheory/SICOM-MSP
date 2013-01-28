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
