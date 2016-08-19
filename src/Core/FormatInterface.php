<?php

namespace Emerap\Ra\Core;

interface FormatInterface {

  /**
   * Get format title
   * @return string
   */
  public function getLabel();

  /**
   * Get format type
   * @return string
   */
  public function getType();

  /**
   * Get format description
   * @return string
   */
  public function getDescription();

  /**
   * Get format mime-type
   * @return string
   */
  public function getMimeType();

  /**
   * Convert object to format
   * @param mixed $object
   * @return mixed
   */
  public function convert($object);

  /**
   * Check requirements
   * @return bool
   */
  public function requirements();

}