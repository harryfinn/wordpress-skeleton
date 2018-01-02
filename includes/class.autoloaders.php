<?php

class Autoloaders {
  public static function init() {
    spl_autoload_register([__CLASS__, 'autoloadClasses']);
    spl_autoload_register([__CLASS__, 'autoloadLibClasses']);
  }

  public static function autoloadClasses($name) {
    $class_name = self::formatClassFilename($name);
    $class_path = get_template_directory() . '/includes/class.'
      . $class_name . '.php';

    if(file_exists($class_path)) require_once $class_path;
  }

  public static function autoloadLibClasses($name) {
    $lib_class_name = INCLUDES_DIR . '/class.'
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
