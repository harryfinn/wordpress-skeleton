<?php

require_once(get_template_directory() . '/includes/constants.php');
require_once(INCLUDES_DIR . '/class.wp-brunch.php');
require_once(INCLUDES_DIR . '/class.autoloaders.php');
require_once(INCLUDES_DIR . '/wordpress-helpers.php');

class WPTheme extends WPBrunch {
  public static function init() {
    parent::init();

    Autoloaders::init();

    add_action('wp_enqueue_scripts', [__CLASS__, 'styleScriptIncludes']);
    add_action('after_setup_theme', [__CLASS__, 'themeSupport']);
    add_action('after_setup_theme', [__CLASS__, 'customImageSizes']);
    add_action('after_setup_theme', [__CLASS__, 'registerNavMenus']);
    add_action('init', [__CLASS__, 'includeAdditionalFiles'], LOAD_ON_INIT);

    add_filter('script_loader_tag', [__CLASS__, 'deferParsingOfJS'], 10);

    // Uncomment action below once you have customised the logo and colours for
    // the admin login page
    // add_action('login_head', [__CLASS__, 'customLoginLogo']);
  }

  public static function styleScriptIncludes() {
    wp_register_script(
      'fontawesome-svg-js',
      '//use.fontawesome.com/releases/v5.0.2/js/all.js',
      [],
      '5.0.2',
      true
    );
    wp_enqueue_script(['jquery', 'underscore', 'fontawesome-svg-js']);
    wp_localize_script(
      'theme_js',
      'wpAjax',
      ['ajaxurl' => admin_url('admin-ajax.php')]
    );
  }

  public function deferParsingOfJS($tag) {
    $scripts_to_exclude = ['jquery', 'underscore'];

    foreach($scripts_to_exclude as $exclude_script) {
      if(strpos($tag, $exclude_script) !== false) return $tag;
    }

    return str_replace(' src', ' defer src', $tag);
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
}

WPTheme::init();
