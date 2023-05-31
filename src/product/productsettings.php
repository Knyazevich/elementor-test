<?php

namespace TwentyTwentyChild\Product;

class ProductSettings {
  public const MENU_SLUG = 'product-settings';

  public function __construct() {
    add_action('admin_menu', [ $this, 'addMenuPage' ]);
    add_action('admin_enqueue_scripts', [ $this, 'addMenuPageAssets' ]);
  }

  public function addMenuPage(): void {
    add_menu_page(
      esc_html__('Products', 'twentytwentychild'),
      esc_html__('Products', 'twentytwentychild'),
      'edit_posts',
      self::MENU_SLUG,
      function () {
        echo '
            <div id="twenty-twenty-child-product-settings"></div>
        ';
      },
      'dashicons-cart',
      30
    );
  }

  public function addMenuPageAssets($hook): void {
    if (!str_contains($hook, self::MENU_SLUG)) {
      return;
    }

    $asset_file = include get_stylesheet_directory() . '/admin/product-settings/build/index.asset.php';

    foreach ($asset_file['dependencies'] as $style) {
      wp_enqueue_style($style);
    }

    wp_enqueue_script(
      'product-settings-js',
      get_stylesheet_directory_uri() . '/admin/product-settings/build/index.js',
      $asset_file['dependencies'],
      $asset_file['version'],
      true
    );

    wp_localize_script('product-settings-js', 'restVariables', [
      'endpoint' => esc_url_raw(rest_url()),
      'nonce' => wp_create_nonce('wp_rest'),
    ]);
  }
}
