<?php

namespace TwentyTwentyChild\Api\V1;

use Throwable;
use TwentyTwentyChild\Api\V1\Validator\ProductCreationValidator;
use TwentyTwentyChild\Product\ProductRepository;
use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;

class ProductApi extends WP_REST_Controller {
  public function __construct() {
    add_action('rest_api_init', [ $this, 'registerRoutes' ]);
  }

  public function registerRoutes(): void {
    $resources = [
      'all_products' => [
        'endpoint' => 'product',
        'args' => [
          'methods' => 'GET',
          'callback' => [ $this, 'getAllProducts' ],
          'permission_callback' => [ RestApiPermission::class, 'authPermissionCheck' ],
        ]
      ],
      'product_by_id' => [
        'endpoint' => 'product/(?P<product_id>\d+)',
        'args' => [
          'methods' => 'GET',
          'callback' => [ $this, 'findProductById' ],
          'permission_callback' => [ RestApiPermission::class, 'authPermissionCheck' ],
        ]
      ],
      'update_product' => [
        'endpoint' => 'product/(?P<product_id>\d+)',
        'args' => [
          'methods' => 'PUT',
          'callback' => [ $this, 'updateProduct' ],
          'permission_callback' => [ RestApiPermission::class, 'authPermissionCheck' ],
        ]
      ],
      'create_product' => [
        'endpoint' => 'product',
        'args' => [
          'methods' => 'POST',
          'callback' => [ $this, 'createProduct' ],
          'permission_callback' => [ RestApiPermission::class, 'authPermissionCheck' ],
          'args' => [
            'data' => [
              'type' => 'object',
              'required' => true,
              'validate_callback' => [ $this, 'validateProductCreation' ],
            ]
          ],
        ]
      ],
      'delete_product' => [
        'endpoint' => 'product/(?P<product_id>\d+)',
        'args' => [
          'methods' => 'DELETE',
          'callback' => [ $this, 'deleteProduct' ],
          'permission_callback' => [ RestApiPermission::class, 'authPermissionCheck' ],
        ]
      ],
    ];

    foreach ($resources as $resource) {
      register_rest_route(RestAPI::FULL_NAMESPACE, $resource['endpoint'], $resource['args']);
    }
  }

  public function validateProductCreation($params): bool {
    $validator = new ProductCreationValidator();
    return $validator->validate($params);
  }

  public function getAllProducts(WP_REST_Request $request): WP_Error|WP_REST_Response {
    try {
      $limit = $request->get_param('limit') ?? 999;
      $offset = $request->get_param('offset') ?? 0;

      $products = ProductRepository::getProducts($limit, $offset, true);

      return new WP_REST_Response([
        'success' => true,
        'data' => $products,
      ], 200);
    } catch (Throwable $t) {
      error_log('Error in ProductApi::getAllProducts(): ' . $t->getMessage());
      return new WP_Error('internal_server_error', $t->getMessage(), [ 'status' => 500 ]);
    }
  }

  public function findProductById(WP_REST_Request $request): WP_Error|WP_REST_Response {
    try {
      $productId = $request->get_param('product_id');

      $result = ProductRepository::getProductById($productId, true);

      return new WP_REST_Response([
        'success' => true,
        'data' => $result,
      ], 200);
    } catch (Throwable $t) {
      error_log('Error in ProductApi::findProductById(): ' . $t->getMessage());
      return new WP_Error('internal_server_error', $t->getMessage(), [ 'status' => 500 ]);
    }
  }

  public function deleteProduct(WP_REST_Request $request): WP_Error|WP_REST_Response {
    try {
      $productId = $request->get_param('product_id');

      $result = ProductRepository::deleteProductById($productId);

      return new WP_REST_Response([
        'success' => $result,
        'data' => [],
      ], 200);
    } catch (Throwable $t) {
      error_log('Error in ProductApi::deleteProduct(): ' . $t->getMessage());
      return new WP_Error('internal_server_error', $t->getMessage(), [ 'status' => 500 ]);
    }
  }

  public function updateProduct(WP_REST_Request $request): WP_Error|WP_REST_Response {
    try {
      $productId = $request->get_param('product_id');
      $productData = json_decode($request->get_body(), flags: JSON_OBJECT_AS_ARRAY);

      $productId = ProductRepository::updateProductById($productId, $productData['data']);

      return new WP_REST_Response([
        'success' => true,
        'data' => $productId,
      ], 200);
    } catch (Throwable $t) {
      error_log('Error in ProductApi::updateProduct(): ' . $t->getMessage());
      return new WP_Error('internal_server_error', $t->getMessage(), [ 'status' => 500 ]);
    }
  }

  public function createProduct(WP_REST_Request $request): WP_Error|WP_REST_Response {
    try {
      $productData = json_decode($request->get_body(), flags: JSON_OBJECT_AS_ARRAY);

      $productId = ProductRepository::createProduct($productData['data']);

      return new WP_REST_Response([
        'success' => true,
        'data' => $productId,
      ], 200);
    } catch (Throwable $t) {
      error_log('Error in ProductApi::createProduct(): ' . $t->getMessage());
      return new WP_Error('internal_server_error', $t->getMessage(), [ 'status' => 500 ]);
    }
  }
}
