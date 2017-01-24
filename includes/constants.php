<?php
$template_dir = get_template_directory();

define('THEME_FOLDER', $template_dir);
define('PUBLIC_FOLDER', get_stylesheet_directory_uri() . '/public');
define('LOAD_ON_INIT', 1);
define('LOAD_AFTER_WP', 10);
define('LOAD_AFTER_THEME', 100);
define('BRUNCH_LOCAL_ASSETS', false);
define('WPTHEME_OPTIONS_KEY', '_theme_options');
define('CMB2_PREFIX', '_theme_cmb2_');
define('WPTHEME_OPTIONS_PREFIX', WPTHEME_OPTIONS_KEY . '_metabox');
