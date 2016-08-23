<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Method.
 *
 * @package Emerap\Ra\Core
 */
class Method {

  protected $name = NULL;
  protected $params = array();
  protected $error;

  /**
   * RcMethod constructor.
   *
   * @param string $name
   *   Method name.
   * @param array $params
   *   Method params.
   */
  public function __construct($name, $params = array()) {
    $this->setName($name);
    $this->setParams($params);
  }

  /**
   * Check is available method for call.
   *
   * @return \Emerap\Ra\Core\Error
   *   Error instance.
   */
  public function isAvailable() {
    $error = RaConfig::instanceError();

    if (!$this->getDefinition()) {
      $error->setCode(103);
      $error->setPlaceholders(array('method' => $this->getName()));
      return $error;
    }

    $error = $this->checkParams();
    return $error;
  }

  /**
   * Get method definition.
   *
   * @return \Emerap\Ra\Core\Definition|bool
   *   Method definition instance or false.
   */
  public function getDefinition() {
    $definitions = RaConfig::getDefinitions();
    if (isset($definitions[$this->getName()])) {
      return $definitions[$this->getName()];
    }
    return FALSE;
  }

  /**
   * Check input params.
   *
   * @return \Emerap\Ra\Core\Error
   *   Error instance.
   */
  public function checkParams() {
    $error = RaConfig::instanceError();
    $input_params = $this->getParams();
    $definition_params = $this->getDefinition()->getMethodParams();
    $passed_params = array();

    foreach ($definition_params as $parameter) {
      $value = NULL;
      // Required param don't be empty. If param is empty return error.
      if ($parameter->isRequire()) {
        if (isset($input_params[$parameter->getName()])) {

          if (empty($input_params[$parameter->getName()])) {
            $error->setCode(105);
            $error->setPlaceholders(array('parameter' => $parameter->getName()));
            return $error;
          }

          $value = $input_params[$parameter->getName()];
        }
        else {
          $error->setCode(104);
          $error->setPlaceholders(array('parameter' => $parameter->getName()));
          return $error;
        }
      }

      // Optional value for param.
      if (!$parameter->isRequire()) {
        if (isset($input_params[$parameter->getName()])) {
          $value = $input_params[$parameter->getName()];
        }
        else {
          $value = $parameter->getDefault();
        }
      }

      // Get param datatype instance.
      $type = $parameter->getTypeObject();
      // Datatype check method.
      $check_status = $type->check($value, $this->getDefinition());

      if ($check_status instanceof Error) {
        return $check_status;
      }

      if ($check_status === FALSE) {
        $error->setCode(300)
          ->setPlaceholders(array('parameter' => $parameter->getName()));
        return $error;
      }

      $passed_params[$parameter->getName()] = $value;
    }

    $this->setParams($passed_params);
    return $error;
  }

  /**
   * Method call.
   *
   * @return mixed
   *   Callback result.
   */
  public function call() {
    return call_user_func($this->getDefinition()->getMethodCallback(),
      $this->getParams());
  }

  /**
   * GETTERS / SETTERS.
   */

  /**
   * Get method name.
   *
   * @return string
   *   Method name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set method name.
   *
   * @param string $name
   *   Method name.
   *
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * Get method params.
   *
   * @return array
   *   Method params.
   */
  public function getParams() {
    return $this->params;
  }

  /**
   * Set method params.
   *
   * @param array $params
   *   Method params.
   *
   * @return $this
   */
  public function setParams($params) {
    $preprocess_args = array();
    foreach ($params as $name => $value) {
      $preprocess_args[strtolower($name)] = $value;
    }

    $this->params = $preprocess_args;
    return $this;
  }

  /**
   * Get method error.
   *
   * @return Error
   *   Method error.
   */
  public function getError() {
    return $this->error;
  }

  /**
   * Set method error.
   *
   * @param \Emerap\Ra\Core\Error $error
   *   Method error.
   *
   * @return $this
   */
  public function setError(Error $error) {
    $this->error = $error;
    return $this;
  }

}
