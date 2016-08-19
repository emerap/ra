<?php

namespace Emerap\Ra\RaFormat;

use Emerap\Ra\Base\FormatBase;

class JsonFormat extends FormatBase {

  /**
   * Get format title
   * @return string
   */
  public function getLabel() {
    return 'JSON';
  }

  /**
   * Get format type
   * @return string
   */
  public function getType() {
    return 'json';
  }

  /**
   * Get format description
   * @return string
   */
  public function getDescription() {
    return 'JSON serialize object';
  }

  /**
   * Convert object to format
   * @param mixed $object
   * @return mixed
   */
  public function convert($object) {
    return json_encode($object, JSON_UNESCAPED_UNICODE);
  }

}