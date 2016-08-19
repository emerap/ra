<?php

namespace Emerap\Ra\RaDefinition;

use Emerap\Ra\Base\DefinitionBase;
use Emerap\Ra\RaConfig;

class RaTokenDefinition extends DefinitionBase {

  /**
   * @inheritdoc
   */
  public function getMethodName() {
    return 'ra.token';
  }

  /**
   * @inheritdoc
   */
  public function getMethodParams() {
    return array(
      RaConfig::instanceParam('client_id'),
    );
  }

  /**
   * @inheritdoc
   */
  public function execute($params) {
    $req = RaConfig::instanceToken()->updateToken($params['client_id']);
    return ($req) ? $req : RaConfig::instanceError(500);
  }

  /**
   * @inheritdoc
   */
  public function getDescription() {
    return 'Get token';
  }

  /**
   * @inheritdoc
   */
  public function getSection() {
    return 'Core';
  }

}

