<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Error {

  protected $code = 0;
  protected $vars = array();
  protected $lang_code = 'en';

  /**
   * RaError constructor.
   *
   * @param int $code
   * @param array $vars
   */
  public function __construct($code = 0, $vars = array()) {
    $this->setCode($code)->setVars($vars);
  }

  /**
   * Get error message.
   *
   * @return string
   */
  public function getMessage() {

    $errors = RaConfig::getErrorsList();

    if (isset($errors[$this->getCode()])) {
      return $this->preprocessMessage($errors[$this->getCode()]);
    }
    return $this->preprocessMessage('Unknown error');
  }

  /**
   * Get error code.
   *
   * @return int
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Set error code.
   *
   * @param int $code
   * @return $this
   */
  public function setCode($code) {
    $this->code = $code;
    return $this;
  }

  /**
   * GETTERS / SETTERS
   */

  /**
   * Preprocess error message.
   *
   * @param string $message
   * @return string
   */
  public function preprocessMessage($message) {
    return $message;
  }

  /**
   * Check error status.
   *
   * @return bool
   */
  public function isError() {
    return (bool) $this->getCode();
  }

  /**
   * Get error vars.
   *
   * @return array
   */
  public function getVars() {
    return $this->vars;
  }

  /**
   * Set error vars.
   *
   * @param array $vars
   * @return $this
   */
  public function setVars($vars) {
    $this->vars = $vars;
    return $this;
  }

  /**
   * Get error lang_code.
   *
   * @return string
   */
  public function getLangCode() {
    return $this->lang_code;
  }

  /**
   * Set error lang_code.
   *
   * @param string $lang_code
   * @return $this
   */
  public function setLangCode($lang_code) {
    $this->lang_code = $lang_code;
    return $this;
  }

}
