<?php

class SiteOptions {
  public $site_options,
         $option_key = WPTHEME_OPTIONS_KEY,
         $option_prefix = WPTHEME_OPTIONS_PREFIX . '_';

  public function __construct() {
    $this->site_options = get_option($this->option_key);
  }

  public function field($array_key) {
    return $this->empty_field_check(
      $this->get_option_by_key($array_key)
    );
  }

  private function get_option_by_key($array_key) {
    if(!is_array($this->site_options)) return false;

    if(array_key_exists($array_key, $this->site_options)) {
      return $this->site_options[$array_key];
    }

    return false;
  }

  private function empty_field_check($field) {
    return !empty($field) ? $field : false;
  }
}
