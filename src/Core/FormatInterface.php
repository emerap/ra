<?php

namespace Emerap\Ra\Core;

/**
 * Interface FormatInterface.
 *
 * @package Emerap\Ra\Core
 */
interface FormatInterface {

  /**
   * Get format title.
   *
   * @return string
   *   Format title.
   */
  public function getLabel();

  /**
   * Get format type.
   *
   * @return string
   *   Format type.
   */
  public function getType();

  /**
   * Get format description.
   *
   * @return string
   *   Format description.
   */
  public function getDescription();

  /**
   * Get format mime-type.
   *
   * @return string
   *   Format mime-type.
   */
  public function getMimeType();

  /**
   * Convert object to format.
   *
   * @param mixed $object
   *   Object for serialize.
   *
   * @return mixed
   *   Serialize string.
   */
  public function convert($object);

  /**
   * Check requirements.
   *
   * @return bool
   *   Requirements for serialize
   */
  public function requirements();

}
