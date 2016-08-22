<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Datatype.
 *
 * @package Emerap\Ra\Core
 */
class Datatype {

  /**
   * Get DataType object by type.
   *
   * @param string $type
   *   Datatype type.
   *
   * @return bool|\Emerap\Ra\Core\DatatypeInterface
   *   State or instance.
   */
  public function getByType($type) {
    $dataTypes = RaConfig::getDatatypes();
    return (isset($dataTypes[$type])) ? $dataTypes[$type] : FALSE;
  }

}
