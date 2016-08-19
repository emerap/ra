<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Definition {

  protected $name = NULL;
  protected $description = NULL;
  protected $methodCallback = NULL;
  protected $methodParams = array();
  protected $accessCallback;
  protected $accessArguments = array();
  protected $section = 'General';
  protected $security = FALSE;
  protected $log = FALSE;
  protected $error;

  /** Static methods */

  /**
   * Check definition exist.
   *
   * @param string $name - method name
   * @return Error
   */
  public static function isExist($name) {
    $error = RaConfig::instanceError();

    if (!self::getDefinitionByName($name)) {
      $error->setCode(103);
      $error->setVars(array('method' => $name));
    }
    return $error;
  }

  public static function getDefinitionByName($name) {
    $definitions = RaConfig::getDefinitions();
    return (isset($definitions[$name])) ? $definitions[$name] : FALSE;
  }

  /**
   * Check is wrong definition.
   *
   * @return bool
   */
  public function isError() {
    $check = $this->check();
    return (!$check !== $this->error) ? $this->error : !$check;
  }

  /**
   * Check is wrong definition helper.
   *
   * @return bool
   */
  private function check() {
    switch (TRUE) {

      // require name
      case is_null($this->getName()):
      case  empty($this->getName()):
        return FALSE;
        break;

      // require description
      case is_null($this->getDescription()):
      case  empty($this->getDescription()):
        return FALSE;
        break;

      // require method callback
      case is_null($this->getMethodCallback()):
      case  empty($this->getMethodCallback()):
        return FALSE;
        break;

      case !function_exists($this->getMethodCallback()):
        return FALSE;
        break;

      // require method callback
      case  empty($this->getAccessCallback()):
        return FALSE;
        break;
    }

    return TRUE;
  }

  /**
   * Get definition name.
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * GETTERS / SETTERS
   */

  /**
   * Set definition name.
   *
   * @param string $name
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
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Set definition description.
   *
   * @param string $description
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
   */
  public function getMethodCallback() {
    return $this->methodCallback;
  }

  /**
   * Set definition method callback.
   *
   * @param string|object $class
   * @param string $method
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
   */
  public function getAccessCallback() {
    return $this->accessCallback;
  }

  /**
   * Set definition access callback.
   *
   * @param array|string $callback
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
   */
  public function getMethodParams() {
    $this->setupGlobalParams();
    return $this->methodParams;
  }

  /**
   * Set definition method params.
   *
   * @param array $params
   * @return $this
   */
  public function setMethodParams($params) {
    $this->methodParams = $params;
    return $this;
  }

  /**
   * Setup global params.
   */
  public function setupGlobalParams() {

    $params = $this->methodParams;

    $formats = [];
    /** @var  $format FormatInterface */
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
   * Get definition security.
   *
   * @return bool
   */
  public function isSecurity() {
    return $this->security;
  }

  /**
   * Set definition security.
   *
   * @param bool $security
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
   */
  public function getAccessParams() {
    return $this->accessArguments;
  }

  /**
   * Set definition access params.
   *
   * @param array $params
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
   */
  public function getSection() {
    return $this->section;
  }

  /**
   * Set definition section.
   *
   * @param string $section
   * @return $this
   */
  public function setSection($section) {
    $this->section = $section;
    return $this;
  }

  /**
   * Get definition log.
   *
   * @return bool
   */
  public function isLog() {
    return $this->log;
  }

  /**
   * Set definition log.
   *
   * @param bool $log
   * @return $this
   */
  public function setLog($log) {
    $this->log = $log;
    return $this;
  }

  /**
   * Get definition error.
   *
   * @return bool
   */
  public function getError() {
    return $this->error;
  }

  /**
   * Set definition error.
   *
   * @param bool $error
   * @return $this
   */
  public function setError($error) {
    $this->error = $error;
    return $this;
  }

}