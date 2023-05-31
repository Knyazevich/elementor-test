<?php

namespace TwentyTwentyChild\Api\V1\Validator\Interface;

interface ValidatorInterface {
  public function validate(array $param): bool;
}
