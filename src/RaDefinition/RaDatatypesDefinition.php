<?php

namespace Emerap\Ra\RaDefinition;

use Emerap\Ra\Base\DefinitionBase;
use Emerap\Ra\RaConfig;

/**
 * Class RaDatatypesDefinition.
 *
 * @package Emerap\Ra\RaDefinition
 */
class RaDatatypesDefinition extends DefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getMethodName() {
    return 'ra.datatypes';
  }

  /**
   * {@inheritdoc}
   */
  public function execute($params) {
    $data_types = array();
    foreach (RaConfig::getDatatypes() as $id => $val) {
      $data_types[$id] = $val->getLabel();
    }
    return $data_types;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return 'All available data types';
  }

  /**
   * {@inheritdoc}
   */
  public function getSection() {
    return 'Core';
  }

}
