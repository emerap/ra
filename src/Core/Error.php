<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Error.
 *
 * @package Emerap\Ra\Core
 */
class Error {

  protected $code = 0;
  protected $placeholders = array();
  protected $langCode = 'en';

  /**
   * Error constructor.
   *
   * @param int $code
   *   Error code.
   * @param array $placeholders
   *   Error placeholders.
   */
  public function __construct($code = 0, $placeholders = array()) {
    $this->setCode($code)->setPlaceholders($placeholders);
  }

  /**
   * Get error message.
   *
   * @return string
   *   Error message.
   */
  public function getMessage() {
    $errors = RaConfig::getErrorsList();
    if (isset($errors[$this->getCode()])) {
      return $this->preprocessMessage($errors[$this->getCode()]);
    }
    return $this->preprocessMessage('Unknown error');
  }

  /**
   * Preprocess error message.
   *
   * @param string $message
   *   Message with placeholders.
   *
   * @return string
   *   Preprocessing message.
   */
  public function preprocessMessage($message) {
    return $message;
  }

  /**
   * GETTERS / SETTERS.
   */

  /**
   * Get error code.
   *
   * @return int
   *   Error code.
   */
  public function getCode() {
    return $this->code;
  }

  /**
   * Set error code.
   *
   * @param int $code
   *   Error code.
   *
   * @return $this
   */
  public function setCode($code) {
    $this->code = $code;
    return $this;
  }

  /**
   * Check error status.
   *
   * @return bool
   *   Error code state.
   */
  public function isError() {
    return (bool) $this->getCode();
  }

  /**
   * Get error placeholders.
   *
   * @return array
   *   Error placeholders.
   */
  public function getPlaceholders() {
    return $this->placeholders;
  }

  /**
   * Set error placeholders.
   *
   * @param array $placeholders
   *   Error placeholders.
   *
   * @return $this
   */
  public function setPlaceholders($placeholders) {
    $this->placeholders = $placeholders;
    return $this;
  }

  /**
   * Get error lang_code.
   *
   * @return string
   *   Language code (domain)
   */
  public function getLangCode() {
    return $this->langCode;
  }

  /**
   * Set error lang_code.
   *
   * @param string $langCode
   *   Language code.
   *
   * @return $this
   */
  public function setLangCode($langCode) {
    $this->langCode = $langCode;
    return $this;
  }

}
