<?php

class ContentHelpers {
  public function __construct() {
    add_filter('wp_nav_menu_args', [$this, 'omo_default_wp_nav_menu_args']);
    add_filter('the_content', [$this, 'omo_cleanup_shortcode_fix']);
    add_filter('the_content', [$this, 'omo_img_unautop', LOAD_AFTER_THEME]);
    add_filter('post_thumbnail_html', [$this, 'omo_remove_thumbnail_dimensions']);
    add_filter('image_send_to_editor', [$this, 'omo_remove_thumbnail_dimensions']);
  }

  public function omo_default_wp_nav_menu_args($args) {
    if(has_nav_menu($args['theme_location']) === false) {
      $args['fallback_cb'] = $this->omo_default_menu_fallback($args);
    }

    return $args;
  }

  public function omo_cleanup_shortcode_fix($content) {
    $array = ['<p>[' => '[', ']</p>' => ']', ']<br />' => ']', ']<br>' => ']'];
    $content = strtr($content, $array);

    return $content;
  }

  public function omo_img_unautop($content) {
    return preg_replace(
      '/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s',
      '<div class="post-image">$1</div>',
      $content
    );
  }

  public function omo_remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);

    return $html;
  }

  private function omo_default_menu_fallback($args) {
    $nav_el = $args['container'];
    $nav_class = $args['container_class'];
    $menu_class = $args['menu_class'];

    echo (!empty($nav_el) ? '<' . $nav_el . (!empty($nav_class) ? ' class="' .
      $nav_class . '">' : '>') : '')
      . '<ul class="' . (!empty($menu_class) ? $menu_class : '') . '">'
        . '<li class="menu-item">'
          . '<a href="' . admin_url('nav-menus.php?action=edit&menu=0') . '">Add Menu</a>'
        . '</li>'
      . '</ul>'
    . (!empty($nav_el) ? '</' . $nav_el . '>' : '');
  }
}
