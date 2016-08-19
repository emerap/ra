<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Method {

  protected $name = NULL;
  protected $params = array();
  protected $error;

  /**
   * RcMethod constructor.
   *
   * @param string $name
   * @param array $params
   */
  public function __construct($name, $params = array()) {
    $this->setName($name);
    $this->setParams($params);
  }

  /**
   * Check is available method for call.
   *
   * @return \Emerap\Ra\Core\Error
   */
  public function isAvailable() {
    $error = RaConfig::instanceError();

    if (!$this->getDefinition()) {
      $error->setCode(103);
      $error->setVars(array('method' => $this->getName()));
      return $error;
    }

    $error = $this->checkParams();
    return $error;
  }

  /**
   * Get method definition.
   *
   * @return \Emerap\Ra\Core\Definition|bool
   */
  public function getDefinition() {
    $definitions = RaConfig::getDefinitions();
    if (isset($definitions[$this->getName()])) {
      return $definitions[$this->getName()];
    }
    return FALSE;
  }

  /**
   * Get method field "name"
   * @return String
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set method field "name"
   * @param String $name
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * GETTERS / SETTERS
   */

  /**
   * Check input params.
   *
   * @return \Emerap\Ra\Core\Error
   */
  public function checkParams() {

    $error = RaConfig::instanceError();
    $input_params = $this->getParams();
    $definition_params = $this->getDefinition()->getMethodParams();
    $passed_params = array();

    /* @var $definition_params \Emerap\Ra\Core\Parameter[] */
    foreach ($definition_params as $parameter) {
      $value = NULL;

      // Обязательный аргумент должен быть задан, если аргумента нет выдаем ошибку
      if ($parameter->isRequire()) {
        if (isset($input_params[$parameter->getName()])) {

          if (empty($input_params[$parameter->getName()])) {
            $error->setCode(105);
            $error->setVars(array('parameter' => $parameter->getName()));
            return $error;
          }

          $value = $input_params[$parameter->getName()];
        }
        else {
          $error->setCode(104);
          $error->setVars(array('parameter' => $parameter->getName()));
          return $error;
        }
      }

      // Необязательный аргумент
      if (!$parameter->isRequire()) {
        if (isset($input_params[$parameter->getName()])) {
          $value = $input_params[$parameter->getName()];
        }
        else {
          $value = $parameter->getDefault();
        }
      }

      // Приводим к нужному типу аргумент
      $type = $parameter->getTypeObject();

      $check_status = $type->check($value, $this->getDefinition());

      if ($check_status instanceof Error) {
        return $check_status;
      }

      if ($check_status === FALSE) {
        $error->setCode(300)
          ->setVars(array('parameter' => $parameter->getName()));
        return $error;
      }

      $passed_params[$parameter->getName()] = $value;
    }

    $this->setParams($passed_params);
    return $error;
  }

  /**
   * Get method params.
   *
   * @return array
   */
  public function getParams() {
    return $this->params;
  }

  /**
   * Set method params.
   *
   * @param array $params
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
   * Method call.
   *
   * @return mixed
   */
  public function call() {
    return call_user_func($this->getDefinition()->getMethodCallback(),
      $this->getParams());
  }

  /**
   * Get method field "error"
   * @return Error
   */
  public function getError() {
    return $this->error;
  }

  /**
   * Set method field "error"
   * @param Error $error
   * @return $this
   */
  public function setError($error) {
    $this->error = $error;
    return $this;
  }

}