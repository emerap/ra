<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Parameter.
 *
 * @package Emerap\Ra\Core
 */
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
   *   Param name.
   * @param bool $default
   *   Default value, if value is NULL when required param.
   * @param string $type
   *   Param type (datatype id)
   */
  public function __construct($name, $default = NULL, $type = NULL) {
    $this->setName($name);
    $type = (is_null($type)) ? RaConfig::getDefaultDatatype() : $type;
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
   *   Datatype instance or false.
   */
  public function getTypeObject() {
    $type = RaConfig::instanceDataType();
    return $type->getByType($this->getType());
  }

  /**
   * GETTERS / SETTERS.
   */

  /**
   * Get parameter type.
   *
   * @return string
   *   Parameter type.
   */
  public function getType() {
    return $this->type;
  }

  /**
   * Set parameter type.
   *
   * @param string $type
   *   Parameter type.
   *
   * @return $this
   */
  public function setType($type) {
    $this->type = $type;
    return $this;
  }

  /**
   * Get parameter name.
   *
   * @return string
   *   Parameter name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set parameter name.
   *
   * @param string $name
   *   Parameter name.
   *
   * @return $this
   */
  public function setName($name) {
    $this->name = $name;
    return $this;
  }

  /**
   * Is parameter require.
   *
   * @return bool
   *   Require state.
   */
  public function isRequire() {
    return $this->require;
  }

  /**
   * Set parameter require.
   *
   * @param bool $require
   *   Require state.
   *
   * @return $this
   */
  public function setRequire($require) {
    $this->require = $require;
    return $this;
  }

  /**
   * Get param default.
   *
   * @return bool|string|int|float|null
   *   Default value.
   */
  public function getDefault() {
    return $this->default;
  }

  /**
   * Set parameter default.
   *
   * @param bool|string|int|float|null $default
   *   Default value.
   *
   * @return $this
   */
  public function setDefault($default) {
    $this->default = $default;
    return $this;
  }

  /**
   * Get parameter options.
   *
   * @return array
   *   Parameter options.
   */
  public function getOptions() {
    return $this->options;
  }

  /**
   * Set parameter options.
   *
   * @param array $options
   *   Parameter options.
   *
   * @return $this
   */
  public function setOptions($options) {
    $this->options = $options;
    return $this;
  }

  /**
   * Get parameter help.
   *
   * @return string
   *   Parameter help.
   */
  public function getHelp() {
    return $this->help;
  }

  /**
   * Set parameter help.
   *
   * @param string $help
   *   Parameter help.
   *
   * @return $this
   */
  public function setHelp($help) {
    $this->help = $help;
    return $this;
  }

}
