<?php

namespace Emerap\Ra\RaDefinition;

use Emerap\Ra\Base\DefinitionBase;
use Emerap\Ra\RaConfig;

class RaMethodsDefinition extends DefinitionBase {

  /**
   * @inheritdoc
   */
  public function getMethodName() {
    return 'ra.methods';
  }

  /**
   * @inheritdoc
   */
  public function execute($params) {
    $methods = array();
    foreach (RaConfig::getDefinitions() as $definition) {
      $methods[] = $definition->getName();
    }
    return $methods;
  }

  /**
   * @inheritdoc
   */
  public function getDescription() {
    return 'All available methods';
  }

  /**
   * @inheritdoc
   */
  public function getSection() {
    return 'Core';
  }

}
