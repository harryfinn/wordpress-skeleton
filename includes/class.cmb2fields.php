<?php

class CMB2Fields {
  public $img_width,
         $img_height,
         $post_id,
         $render_args;

  private $_initialised_post_id;

  public function __construct($post_id) {
    $this->post_id = $post_id;
    $this->_initialised_post_id = $post_id;
  }

  public function set_image_size($width, $height) {
    $this->img_width = $width;
    $this->img_height = $height;
  }

  public function field($field_name, array $field_args = []) {
    $field_value = CMB2Field::fetch($this->post_id, $field_name, $field_args);

    if(strpos($field_name, 'image') !== false && empty($field_value)) {
      return $this->image_field_placeholder(
        $field_name,
        $field_args
      );
    }

    return $field_value;
  }

  public function get_featured_image($size = 'full', $placeholder = false) {
    if(has_post_thumbnail($this->post_id)) {
      $featured_image = wp_get_attachment_image_src(
        get_post_thumbnail_id($this->post_id),
        $size
      );

      return $featured_image[0];
    }

    if($placeholder) return $this->generate_placeholder_from($size);

    return false;
  }

  public function render($template_name, array $render_args = [], $echo = true) {
    $this->render_args = $render_args;
    $template_filename = $this->template_filename($template_name);

    extract($render_args);
    ob_start();

    if($this->template_exists($template_filename)) {
      include(locate_template($template_filename));

      $this->restore_previous_post_id();
    } else {
      echo "No template found for: $template_filename ($template_name)";
    }

    if(!$echo) return ob_get_clean();

    echo ob_get_clean();
  }

  public function template_exists($template) {
    return !empty(locate_template($template)) ?
            true :
            false;
  }

  public function format_content($content) {
    return apply_filters('the_content', $content);
  }

  public function set_new_post_id(int $new_post_id) {
    $this->post_id = $new_post_id;
  }

  protected function get_placeholder($width, $height) {
    return 'http://placehold.it/' . $width . 'x' . $height;
  }

  protected function get_post_object($post_id = null) {
    $_post_id = !empty($post_id) ? $post_id : $this->post_id;

    return get_post($_post_id);
  }

  protected function generate_placeholder_from($size) {
    global $_wp_additional_image_sizes;

    $placeholder_size = $size == 'full' ? 'post-thumbnail' : $size;
    $width = $_wp_additional_image_sizes[$placeholder_size]['width'];
    $height = $_wp_additional_image_sizes[$placeholder_size]['height'];

    return $this->get_placeholder($width, $height);
  }

  protected function restore_previous_post_id() {
    $this->post_id = $this->_initialised_post_id;
  }

  protected function template_filename($template_name) {
    return strpos($template_name, '-tpl.php') === false ?
      $template_name . '-tpl.php' :
      $template_name;
  }

  protected function image_field_placeholder($field_args) {
    if($field_args['placeholder'] === true) {
      if(!empty($field_args['image'])) {
        return $this->get_placeholder(
          $field_args['image']['w'],
          $field_args['image']['h']
        );
      }

      return $this->get_placeholder($this->img_width, $this->img_height);
    }

    return false;
  }
}

class CMB2Field {
  public static $cmb_prefix = CMB2_PREFIX,
                $field,
                $field_args = [
                  'is_single'   => true,
                  'is_tax_term' => false,
                  'placeholder' => false
                ],
                $post_id;

  public static function fetch(int $post_id, $field, array $field_args = []) {
    self::$field      = $field;
    self::$field_args = array_merge(self::$field_args, $field_args);
    self::$post_id    = $post_id;

    if(self::$field_args['is_tax_term']) {
      return self::fetch_tax_term_meta();
    }

    return self::fetch_post_meta();
  }

  private static function fetch_post_meta() {
    $value = get_post_meta(
      self::$post_id,
      self::$cmb_prefix . self::$field,
      self::$field_args['is_single']
    );

    return self::empty_field_check($value);
  }

  private static function fetch_tax_term_meta() {
    $value = get_term_meta(
      self::$post_id,
      self::$field,
      self::$field_args['is_single']
    );

    return self::empty_field_check($value);
  }

  private static function empty_field_check($value) {
    return !empty($value) ? $value : false;
  }
}
