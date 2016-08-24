<?php

namespace Emerap\Ra\RaDatatype;

use Emerap\Ra\Base\DatatypeBase;
use Emerap\Ra\Core\Definition;
use Emerap\Ra\Core\Error;
use Emerap\Ra\Core\Token;
use Emerap\Ra\RaConfig;

/**
 * Class TokenType.
 *
 * @package Emerap\Ra\RaDatatype
 */
class TokenType extends DatatypeBase {

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return 'Token';
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return 'Token type';
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return 'token';
  }

  /**
   * {@inheritdoc}
   */
  public function check(&$value, Definition $definition) {
    if ($definition->isSecurity()) {
      $token = RaConfig::instanceToken()->isToken($value);
      if ($token instanceof Error) {
        return $token;
      }
      if (($token instanceof Token) && !$token->isExpired()) {
        return RaConfig::instanceError(201);
      }
    }
    return TRUE;
  }

}
