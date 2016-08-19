<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Parameter {

  protected $name;
  protected $type;
  protected $default;
  protected $require = TRUE;
  protected $options = array();
  protected $help;

  /**
   * RaParameter constructor.
   *
   * @param string $name
   * @param bool $default
   * @param string $type
   */
  public function __construct($name, $default = NULL, $type = NULL) {

    // Заполняем имя, тип
    // и если указано значение по умолчанию то параметр делаем необязательным
    $this->setName($name);
    $type = (is_null($type)) ? RaConfig::getDefaultDataType() : $type;
    $this->setType($type);

    if (!is_null($default)) {
      $this->setRequire(FALSE);
      $this->setDefault($default);
    }
  }

  /**
   * Get RaDatatype object.
   *
   * @return \Emerap\Ra\Core\DatatypeInterface|bool
   */
  public function getTypeObject() {
    $type = RaConfig::instanceDataType();
    return $type->getByType($this->getType());
  }

  /**
   * GETTERS / SETTERS
   */

  /**
   * Get param type.
   *
   * @return string
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Set param type.
   *
   * @param string $type
   * @return \Emerap\Ra\Core\Parameter
   */
  public function setType($type) {
    $this->type = $type;
    return $this;
  }

  /**
   * Get parameter name.
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set param name.
   *
   * @param string $name
   * @return \Emerap\Ra\Core\Parameter
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * Get param require.
   *
   * @return bool
   */
  public function isRequire() {
    return $this->require;
  }

  /**
   * Set param require.
   *
   * @param bool $require
   * @return \Emerap\Ra\Core\Parameter
   */
  public function setRequire($require) {
    $this->require = $require;
    return $this;
  }

  /**
   * Get param default.
   *
   * @return bool|string|int|float|null
   */
  public function getDefault() {
    return $this->default;
  }

  /**
   * Set param default.
   *
   * @param bool|string|int|float|null $default
   * @return $this
   */
  public function setDefault($default) {
    $this->default = $default;
    return $this;
  }

  /**
   * Get param options.
   *
   * @return array
   */
  public function getOptions() {
    return $this->options;
  }

  /**
   * Set param options.
   *
   * @param array $options
   * @return $this;
   */
  public function setOptions($options) {
    $this->options = $options;
    return $this;
  }

  /**
   * Get param help.
   *
   * @return string
   */
  public function getHelp() {
    return $this->help;
  }

  /**
   * Set param help.
   *
   * @param string $help
   * @return $this
   */
  public function setHelp($help) {
    $this->help = $help;
    return $this;
  }

}
