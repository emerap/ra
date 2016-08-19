<?php

namespace Emerap\Ra\RaDatatype;

use Emerap\Ra\Base\DatatypeBase;
use Emerap\Ra\RaConfig;

class TokenType extends DatatypeBase {

  /**
   * @inheritdoc
   */
  public function getLabel() {
    return 'Token';
  }

  /**
   * @inheritdoc
   */
  public function getDescription() {
    return 'Token type';
  }

  /**
   * @inheritdoc
   */
  public function getType() {
    return 'token';
  }

  /**
   * @inheritdoc
   */
  public function check(&$value, $definition) {
    if ($definition->isSecurity()) {
      $token = RaConfig::instanceToken()->isToken($value);
      if ($token instanceof \Emerap\Ra\Core\Error) {
        return $token;
      }
      if ( ($token instanceof \Emerap\Ra\Core\Token) && !$token->isExpired() ) {
        return RaConfig::instanceError(201);
      }
    }
    return true;
  }

}
