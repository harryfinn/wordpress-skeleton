<?php
$template_dir = get_template_directory();

// Defines the path for Brunch's public compilation folder
define('PUBLIC_FOLDER', get_stylesheet_directory_uri() . '/public');

// Defines the path for the includes folder
define('INCLUDES_DIR', $template_dir . '/includes');

// Defines load priorities for use with actions and filters
define('LOAD_ON_INIT', 1);
define('LOAD_AFTER_WP', 10);
define('LOAD_AFTER_THEME', 100);

// Sets the cmb2 prefixes
define('CMB2_PREFIX', '_theme_cmb2_');
define('WPTHEME_OPTIONS_KEY', '_theme_options');
define('WPTHEME_OPTIONS_PREFIX', WPTHEME_OPTIONS_KEY . '_metabox');
define('LOCALE', 'theme');

// Sets whether Brunch should rewrite asset urls when requested over LAN
define('BRUNCH_LOCAL_ASSETS', false);
