<?php

function jf_template_path() {
  return Wrapper::$main_template;
}

function jf_template_base() {
  return Wrapper::$base;
}

class Wrapper {
  /**
   * Stores the full path to the main template file
   */
  static $main_template;

  /**
   * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
   */
  static $base;

  static function jf_wrap( $template ) {
    self::$main_template = $template;

    self::$base = substr( basename( self::$main_template ), 0, -4 );

    if ( 'index' == self::$base )
      self::$base = false;

    $templates = array( 'wrapper.php' );

    if ( self::$base )
      array_unshift( $templates, sprintf( 'wrapper-%s.php', self::$base ) );

    return locate_template( $templates );
  }
}
add_filter( 'template_include', array( 'Wrapper', 'jf_wrap' ), 99 );

function relinquish_theme_home_page_url( $link, $post ) {
    $post = get_post($post);

    if ( 'page' == get_option( 'show_on_front' ) && $post->ID == get_option( 'page_on_front' ) && defined('RELINQUISH_FRONTEND') )
        $link = RELINQUISH_FRONTEND;

    return $link;
}
add_filter('page_link', 'relinquish_theme_home_page_url', 10, 2);