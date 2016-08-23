<?php

namespace Emerap\Ra\Core;

/**
 * Interface DefinitionInterface.
 *
 * @package Emerap\Ra\Core
 */
interface DefinitionInterface {

  /**
   * Method name.
   *
   * @return string
   *   Method name.
   */
  public function getMethodName();

  /**
   * Method params.
   *
   * @return string
   *   Method params.
   */
  public function getMethodParams();

  /**
   * Method callback.
   *
   * @param Parameter[] $params
   *   Method params.
   *
   * @return mixed|Error
   *   Error or mixed data.
   */
  public function execute($params);

  /**
   * Method description.
   *
   * @return string
   *   Method description.
   */
  public function getDescription();

  /**
   * Method section.
   *
   * @return string
   *   Method section.
   */
  public function getSection();

  /**
   * Method security.
   *
   * @return bool
   *   Security state.
   */
  public function isPublic();

  /**
   * Method access callback.
   *
   * @return string
   *   Method access callback.
   */
  public function getAccessCallback();

  /**
   * Method access parameters.
   *
   * @return array
   *   Method access params.
   */
  public function getAccessParams();

}
