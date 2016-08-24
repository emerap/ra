<?php

namespace Emerap\Ra\RaDatatype;

use Emerap\Ra\Base\DatatypeBase;
use Emerap\Ra\Core\Definition;

/**
 * Class BooleanType.
 *
 * @package Emerap\Ra\RaDatatype
 */
class BooleanType extends DatatypeBase {

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return 'Boolean';
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return 'Boolean type';
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return 'boolean';
  }

  /**
   * {@inheritdoc}
   */
  public function check(&$value, Definition $definition) {
    $value = (strtolower($value) === 'false') ? FALSE : (bool) $value;
    return TRUE;
  }

}
