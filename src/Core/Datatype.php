<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Datatype {

  /**
   * Get all defined data types.
   *
   * @return array|bool
   */
  public function getDataTypes() {
    $dataTypes = RaConfig::getDatatypes();
    return (is_array($dataTypes)) ? array_keys($dataTypes) : FALSE;
  }

  /**
   * Get DataType object by type.
   *
   * @param string $type
   * @return bool
   */
  public function getByType($type) {
    $dataTypes = RaConfig::getDatatypes();
    return (isset($dataTypes[$type])) ? $dataTypes[$type] : FALSE;
  }

}
