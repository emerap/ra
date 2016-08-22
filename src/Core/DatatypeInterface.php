<?php

namespace Emerap\Ra\Core;

/**
 * Interface DatatypeInterface.
 *
 * @package Emerap\Ra\Core
 */
interface DatatypeInterface {

  /**
   * Get Datatype name.
   *
   * @return string
   *   Datatype name.
   */
  public function getLabel();

  /**
   * Get Datatype description.
   *
   * @return string
   *   Datatype description.
   */
  public function getDescription();

  /**
   * Get Datatype type.
   *
   * @return string
   *   Datatype type.
   */
  public function getType();

  /**
   * Check value.
   *
   * @param string|int|bool $value
   *   Parameter value.
   * @param \Emerap\Ra\Core\Definition $definition
   *   Definition instance.
   *
   * @return bool
   *   Check state.
   */
  public function check(&$value, Definition $definition);

}
