<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Definition.
 *
 * @package Emerap\Ra\Core
 */
class Definition {

  protected $name = NULL;
  protected $description = NULL;
  protected $methodCallback = NULL;
  protected $methodParams = array();
  protected $accessCallback;
  protected $accessArguments = array();
  protected $section = 'General';
  protected $security = FALSE;
  protected $error;

  /**
   * Static methods.
   */

  /**
   * Check definition exist.
   *
   * @param string $name
   *   Method name.
   *
   * @return \Emerap\Ra\Core\Error
   *   Error instance.
   */
  public static function isExist($name) {
    $error = RaConfig::instanceError();

    if (!self::getDefinitionByName($name)) {
      $error->setCode(103);
      $error->setPlaceholders(array('method' => $name));
    }
    return $error;
  }

  /**
   * Get definition by method name.
   *
   * @param string $name
   *   Method name.
   *
   * @return bool|\Emerap\Ra\Core\Definition
   *   State or instance.
   */
  public static function getDefinitionByName($name) {
    $definitions = RaConfig::getDefinitions();
    return (isset($definitions[$name])) ? $definitions[$name] : FALSE;
  }

  /**
   * Check is wrong definition.
   *
   * @return bool
   *   Error check state.
   */
  public function isError() {
    $check = $this->check();
    return (!$check !== $this->error) ? $this->error : !$check;
  }

  /**
   * Check is wrong definition helper.
   *
   * @return bool
   *   State is wrong definition.
   */
  private function check() {
    switch (TRUE) {

      // Require name.
      case is_null($this->getName()):
      case  empty($this->getName()):
        return FALSE;

      // Require description.
      case is_null($this->getDescription()):
      case  empty($this->getDescription()):
        return FALSE;

      // Require method callback.
      case is_null($this->getMethodCallback()):
      case  empty($this->getMethodCallback()):
        return FALSE;

      case !function_exists($this->getMethodCallback()):
        return FALSE;

      // Require method callback.
      case  empty($this->getAccessCallback()):
        return FALSE;
    }

    return TRUE;
  }

  /**
   * Setup global params.
   */
  public function setupGlobalParams() {

    $params = $this->methodParams;

    $formats = [];
    foreach (RaConfig::getFormats() as $format) {
      $formats[$format->getType()] = $format->getDescription();
    }

    $param_format = RaConfig::instanceParam('format', 'json')
      ->setOptions($formats)
      ->setHelp('Output format for representing result ');

    $params['format'] = $param_format;

    if ($this->isSecurity()) {
      $params['token'] = new Parameter('token', NULL, 'token');
    }

    $this->setMethodParams($params);
  }

  /**
   * GETTERS / SETTERS.
   */

  /**
   * Get Definition name.
   *
   * @return string
   *   Definition name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set definition name.
   *
   * @param string $name
   *   Definition name.
   *
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * Get definition description.
   *
   * @return string
   *   Definition description.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Set definition description.
   *
   * @param string $description
   *    Definition description.
   *
   * @return $this
   */
  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

  /**
   * Get definition method callback.
   *
   * @return string
   *   Definition method callback.
   */
  public function getMethodCallback() {
    return $this->methodCallback;
  }

  /**
   * Set definition method callback.
   *
   * @param string|object $class
   *   Definition method callback.
   * @param string $method
   *   Method name.
   *
   * @return $this
   */
  public function setMethodCallback($class, $method) {
    $this->methodCallback = array($class, $method);
    return $this;
  }

  /**
   * Get definition access callback.
   *
   * @return array|string
   *   Definition access callback.
   */
  public function getAccessCallback() {
    return $this->accessCallback;
  }

  /**
   * Set definition access callback.
   *
   * @param array|string $callback
   *   Definition access callback.
   *
   * @return $this
   */
  public function setAccessCallback($callback) {
    $this->accessCallback = $callback;
    return $this;
  }

  /**
   * Get definition method params.
   *
   * @return \Emerap\Ra\Core\Parameter[]
   *   Definition method params.
   */
  public function getMethodParams() {
    $this->setupGlobalParams();
    return $this->methodParams;
  }

  /**
   * Set definition method params.
   *
   * @param array $params
   *   Definition method params.
   *
   * @return $this
   */
  public function setMethodParams($params) {
    $this->methodParams = $params;
    return $this;
  }

  /**
   * Get definition security.
   *
   * @return bool
   *   Definition security.
   */
  public function isSecurity() {
    return $this->security;
  }

  /**
   * Set definition security.
   *
   * @param bool $security
   *   Definition security state.
   *
   * @return $this
   */
  public function setSecurity($security) {
    $this->security = $security;
    return $this;
  }

  /**
   * Get definition access params.
   *
   * @return array|string
   *   Definition access params.
   */
  public function getAccessParams() {
    return $this->accessArguments;
  }

  /**
   * Set definition access params.
   *
   * @param array $params
   *   Definition access params.
   *
   * @return $this
   */
  public function setAccessArguments($params) {
    $this->accessArguments = $params;
    return $this;
  }

  /**
   * Get definition section.
   *
   * @return string
   *   Definition section.
   */
  public function getSection() {
    return $this->section;
  }

  /**
   * Set definition section.
   *
   * @param string $section
   *   Definition section.
   *
   * @return $this
   */
  public function setSection($section) {
    $this->section = $section;
    return $this;
  }

}
