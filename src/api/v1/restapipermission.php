<?php

namespace TwentyTwentyChild\Api\V1;

use WP_Error;

class RestApiPermission {
  public static function authPermissionCheck(): WP_Error|bool {
    if (!current_user_can('edit_posts')) {
      return new WP_Error(
        'not_authorized',
        'You need to be authorized to access',
        [ 'status' => 401 ]
      );
    }

    return true;
  }

}
