<?php

namespace TwentyTwentyChild\Product;

class ProductPostType {
  public const PRODUCT_POST_TYPE_SLUG = 'product';
  public const PRODUCT_CATEGORY_TAXONOMY_SLUG = 'product_category';

  public function __construct() {
    add_action('init', [ $this, 'initPostType' ]);
    add_action('init', [ $this, 'initTaxonomies' ]);
  }

  public function initPostType(): void {
    register_post_type(self::PRODUCT_POST_TYPE_SLUG, [
      'label' => esc_html__('Products', 'twentytwentychild'),
      'labels' => [
        'name' => esc_html__('Products', 'twentytwentychild'),
        'singular_name' => esc_html__('Product', 'twentytwentychild'),
        'menu_name' => esc_html__('Products', 'twentytwentychild'),
        'all_items' => esc_html__('All Products', 'twentytwentychild'),
        'view_item' => esc_html__('View Product', 'twentytwentychild'),
        'add_new_item' => esc_html__('Add New Product', 'twentytwentychild'),
        'add_new' => esc_html__('Add Product', 'twentytwentychild'),
        'edit_item' => esc_html__('Edit Product', 'twentytwentychild'),
        'update_item' => esc_html__('Update Product', 'twentytwentychild'),
        'search_items' => esc_html__('Search Product', 'twentytwentychild'),
        'not_found' => esc_html__('Not Found', 'twentytwentychild'),
        'not_found_in_trash' => esc_html__('Not found in Trash', 'twentytwentychild'),
      ],
      'supports' => [ 'title', 'author', 'thumbnail', 'editor', 'excerpt', 'page-attributes', 'custom-fields' ],
      'public' => true,
      'hierarchical' => false,
      'show_ui' => true,
      'has_archive' => true,
      'publicly_queryable' => true,
      'capability_type' => 'page',
    ]);
  }

  public static function initTaxonomies(): void {
    register_taxonomy(
      self::PRODUCT_CATEGORY_TAXONOMY_SLUG,
      self::PRODUCT_POST_TYPE_SLUG, [
      'hierarchical' => true,
      'labels' => [
        'name' => esc_html__('Categories', 'twentytwentychild'),
        'singular_name' => esc_html__('Category', 'twentytwentychild'),
        'search_items' => esc_html__('Search Categories', 'twentytwentychild'),
        'popular_items' => esc_html__('Popular Categories', 'twentytwentychild'),
        'all_items' => esc_html__('All Categories', 'twentytwentychild'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => esc_html__('Edit Category', 'twentytwentychild'),
        'update_item' => esc_html__('Update Category', 'twentytwentychild'),
        'add_new_item' => esc_html__('Add New Category', 'twentytwentychild'),
        'new_item_name' => esc_html__('New Category Name', 'twentytwentychild'),
        'separate_items_with_commas' => esc_html__('Separate Categories with commas', 'twentytwentychild'),
        'add_or_remove_items' => esc_html__('Add or remove Categories', 'twentytwentychild'),
        'choose_from_most_used' => esc_html__('Choose from the most used Categories', 'twentytwentychild'),
        'menu_name' => esc_html__('Categories', 'twentytwentychild'),
      ],
      'show_ui' => true,
    ]);
  }
}
