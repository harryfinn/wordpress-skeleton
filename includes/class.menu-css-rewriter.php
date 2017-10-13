<?php

class MenuCssRewriter {
  private $menu_name,
          $base_css_class;

  public function __construct($menu_name, $base_css_class) {
    $this->menu_name = $menu_name;
    $this->base_css_class = $base_css_class;

    add_action(
      'nav_menu_css_class',
      [$this, 'filter_menu_item_css_classes'],
      LOAD_AFTER_WP,
      4
    );

    add_action(
      'nav_menu_link_attributes',
      [$this, 'filter_menu_link_css_classes'],
      LOAD_AFTER_WP,
      4
    );

    add_action(
      'nav_menu_item_id',
      [$this, 'remove_menu_item_id'],
      LOAD_AFTER_WP,
      4
    );
  }

  public function filter_menu_item_css_classes($classes, $item, $args, $depth) {
    if($args->theme_location !== $this->menu_name) return $classes;

    if(in_array('menu-item', $classes)) {
      $classes = $this->generate_menu_item_css_classes($classes);
    }

    return $classes;
  }

  public function filter_menu_link_css_classes($atts, $item, $args, $depth) {
    if($args->theme_location === $this->menu_name) {
      $amended_base_css_class = "{$this->base_css_class}-link";

      $atts['class'] = $atts['href'] === '#' ?
        "$amended_base_css_class $amended_base_css_class--no-hover " .
        'js-menu-link-no-hover' :
        $amended_base_css_class;
    }

    return $atts;
  }

  public function remove_menu_item_id($item_id, $item, $args, $depth) {
    return null;
  }

  private function generate_menu_item_css_classes($wp_classes) {
    $amended_base_css_class = "{$this->base_css_class}-item";
    $amended_css_classes = [$amended_base_css_class];

    if(in_array('current-menu-item', $wp_classes)) {
      $amended_css_classes[] = "$amended_base_css_class--active";
    }

    if(in_array('menu-item-has-children', $wp_classes)) {
      $amended_css_classes[] = "$amended_base_css_class--has-children " .
        'js-menu-item-has-children';
    }

    return $amended_css_classes;
  }
}
