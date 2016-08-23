<?php

namespace Emerap\Ra\RaDatatype;

use Emerap\Ra\Base\DatatypeBase;
use Emerap\Ra\Core\Definition;

class StringType extends DatatypeBase {

  /**
   * @inheritdoc
   */
  public function getLabel() {
    return 'String';
  }

  /**
   * @inheritdoc
   */
  public function getDescription() {
    return 'Simple string';
  }

  /**
   * @inheritdoc
   */
  public function getType() {
    return 'string';
  }

  /**
   * @inheritdoc
   */
  public function check(&$value, Definition $definition) {
    return is_string($value);
  }

}
