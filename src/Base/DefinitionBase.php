<?php

namespace Emerap\Ra\Base;

use Emerap\Ra\Core\DefinitionInterface;

abstract class DefinitionBase implements DefinitionInterface {

  /**
   * @inheritdoc
   */
  public function getMethodParams() {
    return array();
  }

  /**
   * @inheritdoc
   */
  public function getSection() {
    return 'Custom';
  }

  /**
   * @inheritdoc
   */
  public function isPublic() {
    return TRUE;
  }

  /**
   * @inheritdoc
   */
  public function getAccessCallback() {
    return array();
  }

  /**
   * @inheritdoc
   */
  public function getAccessParams() {
    return '';
  }

}