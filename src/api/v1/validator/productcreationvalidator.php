<?php

namespace TwentyTwentyChild\Api\V1\Validator;

use TwentyTwentyChild\Api\V1\Validator\Interface\ValidatorInterface;

class ProductCreationValidator implements ValidatorInterface {
  public function validate(array $param): bool {
    // Each validation rule must return true if field's value is valid
    $rules = [
      'title' => fn($v) => isset($v) && is_string($v),
      'price' => fn($v) => isset($v) && is_numeric($v),
      'salePrice' => fn($v) => isset($v) ? is_numeric($v) : true,
      'youtubeURL' => fn($v) => (isset($v) && !empty($v)) ? (bool) preg_match('/^(https?:\/\/)?(www\.youtube\.com\/watch\?v=|youtu.be\/)(?P<id>[0-9a-z-_?=]+)(?P<list>[&?]list=[0-9a-z-_]*)*/i', $v) : true,
    ];

    foreach ($rules as $field_name => $rule) {
      $value = $param[$field_name] ?? null;
      $is_valid = $rule($value);

      if (!$is_valid) {
        error_log("ProductCreationValidator::validate() error while validating field `{$field_name}`");
        return false;
      }
    }

    return true;
  }
}

