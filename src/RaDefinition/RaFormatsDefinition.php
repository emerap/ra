<?php

namespace Emerap\Ra\RaDefinition;

use Emerap\Ra\Base\DefinitionBase;
use Emerap\Ra\RaConfig;

class RaFormatsDefinition extends DefinitionBase {

  /**
   * @inheritdoc
   */
  public function getMethodName() {
    return 'ra.formats';
  }

  /**
   * @inheritdoc
   */
  public function execute($params) {
    $formats = array();
    foreach (RaConfig::getFormats() as $id => $val) {
      $formats[$id] = $val->getLabel();
    }
    return $formats;
  }

  /**
   * @inheritdoc
   */
  public function getDescription() {
    return 'All available formats';
  }

  /**
   * @inheritdoc
   */
  public function getSection() {
    return 'Core';
  }

}
