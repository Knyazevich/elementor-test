<?php

namespace TwentyTwentyChild\Api\V1;

class RestAPI {
  public const FULL_NAMESPACE = 'twenty-twenty-child/v1/';

  public function __construct() {
    new ProductApi();
  }
}
