<?php

namespace Emerap\Ra\Core;

interface DefinitionInterface {

  /**
   * Method name.
   *
   * @return string
   */
  public function getMethodName();

  /**
   * Method params.
   *
   * @return string
   */
  public function getMethodParams();

  /**
   * Method callback.
   *
   * @param Parameter[] $params
   * @return mixed|Error
   */
  public function execute($params);

  /**
   * Method description.
   *
   * @return string
   */
  public function getDescription();

  /**
   * Method section.
   *
   * @return string
   */
  public function getSection();

  /**
   * Method security.
   *
   * @return bool
   */
  public function isPublic();

  /**
   * Method access callback.
   *
   * @return string
   */
  public function getAccessCallback();

  /**
   * Method access parameters.
   *
   * @return array
   */
  public function getAccessParams();

}