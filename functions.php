<?php

require_once(get_template_directory() . '/includes/constants.php');
require_once(THEME_FOLDER . '/includes/class.wp-brunch.php');

class WPTheme extends WPBrunch {
  public static function init() {
    parent::init();

    spl_autoload_register([__CLASS__, 'autoloadClasses']);
    spl_autoload_register([__CLASS__, 'autoloadLibClasses']);

    add_action('wp_enqueue_scripts', [__CLASS__, 'styleScriptIncludes']);
    add_action('after_setup_theme', [__CLASS__, 'themeSupport']);
    add_action('after_setup_theme', [__CLASS__, 'customImageSizes']);
    add_action('after_setup_theme', [__CLASS__, 'registerNavMenus']);
    add_action('init', [__CLASS__, 'includeAdditionalFiles'], LOAD_ON_INIT);

    // Uncomment action below once you have customised the logo and colours for
    // the admin login page
    // add_action('login_head', [__CLASS__, 'customLoginLogo']);
  }

  public static function styleScriptIncludes() {
    wp_enqueue_script(['jquery', 'underscore']);
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

  public static function themeSupport() {
    add_theme_support('html5', ['search-form']);
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
  }

  public static function customImageSizes() {
    add_image_size('hero-banner-image', 1920, 1080, true);
  }

  public static function registerNavMenus() {
    register_nav_menus([
      'main_menu' => 'Main navigation menu',
      'footer_menu' => 'Footer navigation menu'
    ]);

    new MenuCssRewriter('main_menu', 'page-header__menu');
    new MenuCssRewriter('footer_menu', 'page-footer__menu');
  }

  public static function includeAdditionalFiles() {
    new CustomPostTypes();
    new CustomMetaboxes();
    new ContentHelpers();

    if(is_admin()) ThemeAdmin::get_instance();
  }

  public static function customLoginLogo() {
    $admin_logo = PUBLIC_FOLDER . '/images/admin-login-logo.jpg';
    ?>

    <style type="text/css">
      .login { background-color: #000; }
      .login h1 a {
        background-image: url('<?php echo $admin_logo; ?>');
        background-size: 100%;
        height: 140px;
        width: 140px;
      }
      .login #nav a, .login #backtoblog a { color: #fff; }
    </style>

    <?php
  }

  public static function autoloadClasses($name) {
    $class_name = self::formatClassFilename($name);
    $class_path = get_template_directory() . '/includes/class.'
      . $class_name . '.php';

    if(file_exists($class_path)) require_once $class_path;
  }

  public static function autoloadLibClasses($name) {
    $lib_class_name = THEME_FOLDER . '/includes/class.'
      . strtolower($name) . '.php';

    if(file_exists($lib_class_name)) require_once($lib_class_name);
  }

  private static function formatClassFilename($filename) {
    return strtolower(
      implode(
        '-',
        preg_split('/(?=[A-Z])/', $filename, -1, PREG_SPLIT_NO_EMPTY)
      )
    );
  }
}

WPTheme::init();
