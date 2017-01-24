<?php

require_once(get_template_directory() . '/includes/constants.php');
require_once(THEME_FOLDER . '/includes/class.wp-brunch.php');

class WPTheme extends WPBrunch {
  public static function init() {
    parent::init();

    spl_autoload_register([__CLASS__, 'autoload_classes']);
    spl_autoload_register([__CLASS__, 'autoload_lib_classes']);

    add_action('wp_enqueue_scripts', [__CLASS__, 'style_script_includes']);
    add_action('after_setup_theme', [__CLASS__, 'theme_support']);
    add_action('after_setup_theme', [__CLASS__, 'custom_image_sizes']);
    add_action('after_setup_theme', [__CLASS__, 'register_nav_menus']);
    add_action('init', [__CLASS__, 'include_additional_files'], LOAD_ON_INIT);
  }

  public static function style_script_includes() {
    wp_enqueue_script('jquery');
    wp_register_script(
      'modernizr',
      '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
      '',
      '2.8.3',
      true
    );
    wp_enqueue_script('modernizr');
    wp_register_style(
      'font-awesome-lib',
      '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
      '',
      '4.7.0'
    );
    wp_enqueue_style('font-awesome-lib');
    wp_localize_script(
      'theme_js',
      'wpAjax',
      ['ajaxurl' => admin_url('admin-ajax.php')]
    );
  }

  public static function theme_support() {
    add_theme_support('html5', ['search-form']);
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
  }

  public static function custom_image_sizes() {
    add_image_size('hero-banner-image', 1920, 1080, true);
  }

  public static function register_nav_menus() {
    register_nav_menus([
      'main_menu' => 'Main navigation menu',
      'footer_menu' => 'Footer navigation menu'
    ]);
  }

  public static function include_additional_files() {
    new CustomPostTypes();
    new CustomMetaboxes();
    require_once THEME_FOLDER . '/includes/content-helpers.php';

    if(is_admin()) {
      require_once THEME_FOLDER . '/includes/class.theme-admin.php';
    }
  }

  public static function autoload_classes($name) {
    $class_name = self::format_class_filename($name);
    $class_path = get_template_directory() . '/includes/class.'
      . $class_name . '.php';

    if(file_exists($class_path)) require_once $class_path;
  }

  public static function autoload_lib_classes($name) {
    $lib_class_name = THEME_FOLDER . '/includes/class.'
      . strtolower($name) . '.php';

    if(file_exists($lib_class_name)) require_once($lib_class_name);
  }

  private static function format_class_filename($filename) {
    return strtolower(
      implode(
        '-',
        preg_split('/(?=[A-Z])/', $filename, -1, PREG_SPLIT_NO_EMPTY)
      )
    );
  }
}

WPTheme::init();
