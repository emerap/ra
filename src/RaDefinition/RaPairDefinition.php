<?php

namespace Emerap\Ra\RaDefinition;

use Emerap\Ra\Base\DefinitionBase;
use Emerap\Ra\RaConfig;

/**
 * Class RaPairDefinition.
 *
 * @package Emerap\Ra\RaDefinition
 */
class RaPairDefinition extends DefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getMethodName() {
    return 'ra.pair';
  }

  /**
   * {@inheritdoc}
   */
  public function getMethodParams() {
    return array(
      RaConfig::instanceParam('tag')->setHelp('Client tag'),
      RaConfig::instanceParam('platform')->setHelp('Client platform'),
      RaConfig::instanceParam('pin', NULL, 'number')
        ->setHelp('Pin for pairing'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function execute($params) {
    return RaConfig::instanceServerClient()
      ->pair($params['tag'], $params['pin'], $params['platform']);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return 'Pairing with a new client';
  }

  /**
   * {@inheritdoc}
   */
  public function getSection() {
    return 'Core';
  }

}
