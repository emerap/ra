<?php

namespace Emerap\Ra\RaDatatype;

use Emerap\Ra\Base\DatatypeBase;

class NumberType extends DatatypeBase {

  /**
   * @inheritdoc
   */
  public function getLabel() {
    return 'Number';
  }

  /**
   * @inheritdoc
   */
  public function getDescription() {
    return 'Simple number';
  }

  /**
   * @inheritdoc
   */
  public function getType() {
    return 'number';
  }

  /**
   * @inheritdoc
   */
  public function check(&$value, $definition) {
    $value = (int) $value;
    return $value;
  }

}
