<?php

header('X-Frame-Options GOFORIT');

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
