<?php

namespace Emerap\Ra\RaDefinition;

use Emerap\Ra\Base\DefinitionBase;
use Emerap\Ra\RaConfig;

/**
 * Class RaVersionDefinition.
 *
 * @package Emerap\Ra\RaDefinition
 */
class RaVersionDefinition extends DefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function getMethodName() {
    return 'ra.version';
  }

  /**
   * {@inheritdoc}
   */
  public function getMethodParams() {
    return array(
      RaConfig::instanceParam('field', 'all')
        ->setHelp('Version field')
        ->setOptions(array(
          'all' => 'All fields',
          'engine' => 'Only engine field',
          'version' => 'Only version field',
        )),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function execute($params) {
    return RaConfig::instanceRa()->version($params['field']);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return 'Get core version information';
  }

  /**
   * {@inheritdoc}
   */
  public function getSection() {
    return 'Core';
  }

}
