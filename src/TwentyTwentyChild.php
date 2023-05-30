<?php

namespace TwentyTwentyChild;

class TwentyTwentyChild {
  public function __construct() {
    add_action('wp_enqueue_scripts', [ $this, 'enqueueParentStyles' ]);
  }

  /**
   * Enqueue scripts and styles.
   */
  function enqueueParentStyles(): void {
    $theme = wp_get_theme();

    wp_enqueue_style(
      'twentytwenty-style',
      get_template_directory_uri() . '/style.css',
      [],
      $theme->parent()->get('Version')
    );

    wp_enqueue_style('twentytwenty-child-style',
      get_stylesheet_directory_uri() . '/style.css',
      [ 'twentytwenty-style' ],
      $theme->get('Version')
    );
  }
}
