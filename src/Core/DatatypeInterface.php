<?php

namespace Emerap\Ra\Core;

interface DatatypeInterface {

  /**
   * Get RaDatatype field name
   * @return String
   */
  public function getLabel();

  /**
   * Get RaDatatype field description
   * @return String
   */
  public function getDescription();

  /**
   * Get RaDatatype field type
   * @return String
   */
  public function getType();

  /**
   * Check value
   * @param String|int|bool $value
   * @param \Emerap\Ra\Core\Definition $definition
   * @return bool
   */
  public function check(&$value, $definition);

}
