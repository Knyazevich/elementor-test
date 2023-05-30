<?php

namespace TwentyTwentyChild;

use TwentyTwentyChild\Product\ProductPostType;
use TwentyTwentyChild\User\UserHelpers;

class TwentyTwentyChild {
  public function __construct() {
    $this->loadDependencies();

    add_action('wp_enqueue_scripts', [ $this, 'enqueueParentStyles' ]);
    add_action('after_setup_theme', [$this, 'setupTheme']);
    add_action('after_setup_theme', [ $this, 'hideWPDashboardForTestUser' ]);
  }

  private function loadDependencies(): void {
    spl_autoload_register(function ($className) {
      if(strpos($className, "TwentyTwentyChild") !== false) {
        $className = str_replace("TwentyTwentyChild", "", $className);
        $className = ltrim(str_replace("\\", "/", $className), "/");
        $className = strtolower(str_replace("_", "-", $className));

        include $className . '.php';
      }
    });

    new ProductPostType();
  }

  /**
   * Enqueue scripts and styles.
   */
  public function enqueueParentStyles(): void {
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

  public function setupTheme(): void {
    load_theme_textdomain('twentytwentychild', get_stylesheet_directory_uri() . '/languages');
  }

  function hideWPDashboardForTestUser(): void {
    if (UserHelpers::isCurrentUserTestUser()) {
      show_admin_bar(false);
    }
  }
}
