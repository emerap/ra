<?php

namespace Emerap\Ra\RaFormat;

use Emerap\Ra\Base\FormatBase;

/**
 * Class JsonFormat.
 *
 * @package Emerap\Ra\RaFormat
 */
class JsonFormat extends FormatBase {

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return 'JSON';
  }

  /**
   * {@inheritdoc}
   */
  public function getType() {
    return 'json';
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return 'JSON serialize object';
  }

  /**
   * {@inheritdoc}
   */
  public function convert($object) {
    return json_encode($object, JSON_UNESCAPED_UNICODE);
  }

}
