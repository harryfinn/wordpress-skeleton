<?php

class WPBrunch {
  public static function init() {
    add_action('wp_enqueue_scripts', [__CLASS__, 'wp_brunch_includes']);
    add_filter(
      'get_post_metadata',
      [__CLASS__, 'rewrite_assets_for_local_request'],
      LOAD_AFTER_WP,
      4
    );
  }

  public static function wp_brunch_includes() {
    self::enqueue_file(
      'vendor_js',
      PUBLIC_FOLDER . '/js/vendor.js',
      'script',
      ['in_footer' => true]
    );
    self::enqueue_file(
      'theme_js',
      PUBLIC_FOLDER . '/js/app.js',
      'script',
      ['in_footer' => true]
    );
    self::enqueue_file(
      'vendor_style',
      PUBLIC_FOLDER . '/css/vendor.css',
      'style'
    );
    self::enqueue_file('theme_style', PUBLIC_FOLDER . '/css/app.css', 'style');
  }

  public static function rewrite_assets_for_local_request($meta_data, $post_id, $meta_key, $single) {
    if(!defined('BRUNCH_LOCAL_ASSETS') || BRUNCH_LOCAL_ASSETS !== true) {
      return $meta_data;
    }

    $remote_addr = !empty($_SERVER['REMOTE_ADDR']) ?
      $_SERVER['REMOTE_ADDR'] :
      false;

    if(self::is_local_request()) return $meta_data;

    if(strpos($meta_key, 'image') === false) return $meta_data;

    $current_filter = current_filter();
    remove_filter($current_filter, [__CLASS__, __FUNCTION__]);

    $current_asset_value = get_post_meta($post_id, $meta_key, $single);

    add_filter($current_filter, [__CLASS__, __FUNCTION__], LOAD_AFTER_WP, 4);

    return self::update_asset_for_local_request($current_asset_value);
  }

  protected static function enqueue_file($handle, $file_path, $type = 'script', array $enqueue_args = []) {
    if(file_exists(self::real_file_path($file_path))) {
      $_self = __CLASS__;
      $register_args = call_user_func(
        "$_self::merge_args_for_$type",
        $enqueue_args
      );

      call_user_func(
        "$_self::load_file_as_$type",
        $handle,
        $file_path,
        $register_args
      );
    }
  }

  private static function real_file_path($file_path) {
    if(strpos($file_path, PUBLIC_FOLDER) !== false) {
      $real_file_path = str_replace(
        PUBLIC_FOLDER,
        get_stylesheet_directory() . '/public',
        $file_path
      );

      return $real_file_path;
    }

    return $file_path;
  }

  private static function merge_args_for_script($args) {
    $default_args = [
      'deps' => [],
      'version' => false,
      'in_footer' => false
    ];

    return array_merge($default_args, $args);
  }

  private static function merge_args_for_style($args) {
    $default_args = [
      'deps' => [],
      'version' => false,
      'media' => 'all'
    ];

    return array_merge($default_args, $args);
  }

  private static function load_file_as_script($handle, $file_path, $args) {
    wp_register_script(
      $handle,
      $file_path,
      $args['deps'],
      $args['version'],
      $args['in_footer']
    );
    wp_enqueue_script($handle);
  }

  private static function load_file_as_style($handle, $file_path, $args) {
    wp_register_style(
      $handle,
      $file_path,
      $args['deps'],
      $args['version'],
      $args['media']
    );
    wp_enqueue_style($handle);
  }

  private static function is_local_request() {
    $remote_addr = !empty($_SERVER['REMOTE_ADDR']) ?
      $_SERVER['REMOTE_ADDR'] :
      false;

    return $remote_addr === '127.0.0.1';
  }

  private static function update_asset_for_local_request($current_value) {
    $site_url_host = parse_url(site_url(), PHP_URL_HOST);
    $asset_url_host = parse_url($current_value, PHP_URL_HOST);

    return str_replace($asset_url_host, $site_url_host, $current_value);
  }
}
