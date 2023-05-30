<?php

namespace TwentyTwentyChild\User;

class UserHelpers {
  public const TEST_USER_EMAIL = 'wptest@elementor.com';

  public static function isCurrentUserTestUser(): bool {
    $currentUser = wp_get_current_user();

    return $currentUser->user_email === self::TEST_USER_EMAIL;
  }
}
