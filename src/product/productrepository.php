<?php

namespace TwentyTwentyChild\Product;

use TwentyTwentyChild\Product\Exceptions\ProductCreationException;
use TwentyTwentyChild\Product\Exceptions\ProductUpdatingException;
use WP_Error;

class ProductRepository {
  public static function getProductById(int $productId, bool $serialize = false): array|Product {
    global $wpdb;

    $row = $wpdb->get_row($wpdb->prepare("
        SELECT `ID` AS `id`,
               `post_content` AS `description`,
               `post_title` AS `title`,
               `thumbnail`.`meta_value` AS `thumbnail`,
               `isOnSale`.`meta_value` AS `isOnSale`,
               `price`.`meta_value` AS `price`,
               `salePrice`.`meta_value` AS `salePrice`,
               `youtubeURL`.`meta_value` AS `youtubeURL`,
               `term_taxonomy`.`term_id` AS `productCategory` FROM `wp_posts`
        LEFT JOIN `wp_postmeta` AS `thumbnail` ON (`wp_posts`.`ID` = `thumbnail`.`post_id` AND `thumbnail`.`meta_key` = '_thumbnail_id')
        LEFT JOIN `wp_postmeta` AS `isOnSale` ON (`wp_posts`.`ID` = `isOnSale`.`post_id` AND `isOnSale`.`meta_key` = 'isOnSale')
        LEFT JOIN `wp_postmeta` AS `youtubeURL` ON (`wp_posts`.`ID` = `youtubeURL`.`post_id` AND `youtubeURL`.`meta_key` = 'youtubeURL')
        LEFT JOIN `wp_postmeta` AS `price` ON (`wp_posts`.`ID` = `price`.`post_id` AND `price`.`meta_key` = 'price')
        LEFT JOIN `wp_postmeta` AS `salePrice` ON (`wp_posts`.`ID` = `salePrice`.`post_id` AND `salePrice`.`meta_key` = 'salePrice')
        LEFT JOIN `wp_term_relationships` AS `term_relationships` ON (`wp_posts`.`ID` = `term_relationships`.`object_id`)
        LEFT JOIN `wp_term_taxonomy` AS `term_taxonomy` ON (`term_taxonomy`.`term_id` = `term_relationships`.`term_taxonomy_id` AND `term_taxonomy`.`taxonomy` = 'product_category')
        WHERE `post_type` = 'product' AND `post_status` = 'publish' AND `ID` = %d
        ORDER BY `wp_posts`.`post_date` ASC
        LIMIT 1;
", $productId));

    $product = new Product();

    if (isset($row->thumbnail)) {
      $product->setMainImageId($row->thumbnail)
        ->setMainImageURL(wp_get_attachment_url($row->thumbnail));
    }

    if (isset($row->productCategory)) {
      $product->setProductCategory($row->productCategory);
    }

    $product->setId($row->id)
      ->setTitle($row->title)
      ->setDescription($row->description)
      ->setIsOnSale($row->isOnSale ?? false)
      ->setPrice($row->price ?? 0)
      ->setSalePrice($row->salePrice ?? 0)
      ->setYoutubeURL($row->youtubeURL);

    return $serialize ? $product->toJSON() : $product;
  }

  public static function getProducts(int $limit = 999, int $offset = 0, bool $serialize = false): array {
    global $wpdb;
    $result = [];

    $products = $wpdb->get_results($wpdb->prepare("
        SELECT `ID` AS `id`,
               `post_content` AS `description`,
               `post_title` AS `title`,
               `thumbnail`.`meta_value` AS `thumbnail`,
               `isOnSale`.`meta_value` AS `isOnSale`,
               `price`.`meta_value` AS `price`,
               `salePrice`.`meta_value` AS `salePrice`,
               `youtubeURL`.`meta_value` AS `youtubeURL` FROM `{$wpdb->prefix}posts`
        LEFT JOIN `{$wpdb->prefix}postmeta` AS `thumbnail` ON (`{$wpdb->prefix}posts`.`ID` = `thumbnail`.`post_id` AND `thumbnail`.`meta_key` = '_thumbnail_id')
        LEFT JOIN `{$wpdb->prefix}postmeta` AS `isOnSale` ON (`{$wpdb->prefix}posts`.`ID` = `isOnSale`.`post_id` AND `isOnSale`.`meta_key` = 'isOnSale')
        LEFT JOIN `{$wpdb->prefix}postmeta` AS `youtubeURL` ON (`{$wpdb->prefix}posts`.`ID` = `youtubeURL`.`post_id` AND `youtubeURL`.`meta_key` = 'youtubeURL')
        LEFT JOIN `{$wpdb->prefix}postmeta` AS `price` ON (`{$wpdb->prefix}posts`.`ID` = `price`.`post_id` AND `price`.`meta_key` = 'price')
        LEFT JOIN `{$wpdb->prefix}postmeta` AS `salePrice` ON (`{$wpdb->prefix}posts`.`ID` = `salePrice`.`post_id` AND `salePrice`.`meta_key` = 'salePrice')
        WHERE `post_type` = 'product' AND `post_status` = 'publish'
        ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC
        LIMIT %d
        OFFSET %d", $limit, $offset));

    foreach ($products as $row) {
      $product = new Product();

      if (isset($row->thumbnail)) {
        $product->setMainImageId($row->thumbnail)
          ->setMainImageURL(wp_get_attachment_url($row->thumbnail));
      }

      $product->setId($row->id)
        ->setTitle($row->title)
        ->setDescription($row->description)
        ->setIsOnSale($row->isOnSale ?? false)
        ->setPrice($row->price ?? 0)
        ->setSalePrice($row->salePrice ?? 0)
        ->setYoutubeURL($row->youtubeURL);

      $result[] = $serialize ? $product->toJSON() : $product;
    }

    return $result;
  }

  /**
   * @throws ProductCreationException
   */
  public static function createProduct(array $postData): int {
    $productId = wp_insert_post([
      'post_title' => $postData['title'],
      'post_content' => $postData['description'] ?? '',
      'post_status' => 'publish',
      'post_author' => get_current_user_id(),
      'post_type' => ProductPostType::PRODUCT_POST_TYPE_SLUG,
    ]);

    if ($productId === 0 || is_wp_error($productId)) {
      throw new ProductCreationException($productId->get_error_message());
    }

    unset($postData['title']);
    unset($postData['description']);

    if ($postData['productCategory']) {
      $result = wp_set_post_terms($productId, $postData['productCategory'], ProductPostType::PRODUCT_CATEGORY_TAXONOMY_SLUG);

      if (is_wp_error($result)) {
        throw new ProductCreationException($productId->get_error_message());
      }

      unset($postData['productCategory']);
    }

    if ($postData['thumbnailId']) {
      set_post_thumbnail($productId, (int) $postData['thumbnailId']);

      unset($postData['thumbnailId']);
    }

    foreach ($postData as $key => $value) {
      update_post_meta($productId, $key, $value);
    }

    return $productId;
  }

  public static function updateProductById(int $productId, array $postData): WP_Error|int {
    $productId = wp_update_post([
      'ID' => $productId,
      'post_title' => $postData['title'],
      'post_content' => $postData['description'] ?? '',
      'post_status' => 'publish',
      'post_author' => get_current_user_id(),
      'post_type' => ProductPostType::PRODUCT_POST_TYPE_SLUG,
    ]);

    if ($productId === 0 || is_wp_error($productId)) {
      throw new ProductUpdatingException($productId->get_error_message());
    }

    unset($postData['title']);
    unset($postData['description']);

    if ($postData['productCategory']) {
      $result = wp_set_post_terms($productId, $postData['productCategory'] !== '0' ? $postData['productCategory'] : '', ProductPostType::PRODUCT_CATEGORY_TAXONOMY_SLUG);

      if (is_wp_error($result)) {
        throw new ProductUpdatingException($productId->get_error_message());
      }

      unset($postData['productCategory']);
    }

    if ($postData['thumbnailId']) {
      set_post_thumbnail($productId, (int) $postData['thumbnailId']);

      unset($postData['thumbnailId']);
    }

    foreach ($postData as $key => $value) {
      update_post_meta($productId, $key, $value);
    }

    return $productId;
  }

  public static function deleteProductById(int $productId): bool {
    return (bool) wp_delete_post($productId, true);
  }
}
