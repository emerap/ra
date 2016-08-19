<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Datatype {

  protected $types;

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

  /** GETTERS & SETTERS */

  /**
   * All DataTypes objects.
   *
   * @return array
   */
  public function getTypes() {
    return $this->types;
  }

  /**
   * Set DataTypes objects.
   *
   * @param array $types
   */
  public function setTypes($types) {
    $this->types = $types;
  }

}
