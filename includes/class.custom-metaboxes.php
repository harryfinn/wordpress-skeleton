<?php

class CustomMetaboxes {
  public function __construct() {
    if(file_exists(__DIR__ . '/CMB2/init.php')) {
      require_once __DIR__ . '/CMB2/init.php';
    }

    add_action('cmb2_init', [$this, 'cmb2_load_metaboxes']);
  }

  public function cmb2_load_metaboxes() {
    $prefix = CMB2_PREFIX;
    $cmb2_field_files_dir = __DIR__ . '/custom-metaboxes';

    if(file_exists($cmb2_field_files_dir)) {
      $cmb2_field_files = new DirectoryIterator($cmb2_field_files_dir);

      foreach($cmb2_field_files as $file) {
        if($file->isFile()) require_once($file->getPathname());
      }
    }
  }
}
