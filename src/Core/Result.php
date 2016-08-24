<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Result.
 *
 * @package Emerap\Ra\Core
 */
class Result {

  protected $method;
  protected $raw;
  protected $error;
  protected $format = NULL;

  /**
   * Get formatted request.
   *
   * @return string
   *   Serialize request data.
   */
  public function format() {
    $format = $this->getFormat();
    return $format->convert($this->getRequest());
  }

  /**
   * Get RaFormat object.
   *
   * @return \Emerap\Ra\Core\FormatInterface
   *   Format instance.
   */
  public function getFormat() {
    if (is_null($this->format)) {
      $formats = RaConfig::getFormats();
      $params = $this->getMethod()->getParams();
      $type = (isset($params['format']) && isset($formats[$params['format']])) ?
        $params['format'] : RaConfig::getDefaultFormatType();
      $this->setFormat($formats[$type]);
    }
    return $this->format;
  }

  /**
   * Get request object.
   *
   * @return array
   *   Request object.
   */
  public function getRequest() {

    $request = array();

    if ($this->getError()->isError()) {
      $request['error'] = $this->getError()->getCode();
      $request['message'] = $this->getError()->getMessage();
    }
    else {
      $request['request'] = $this->getRaw();
      $request['type'] = $this->type();
      $request['count'] = $this->count();
    }

    return $request;
  }

  /**
   * Helper request type.
   *
   * @return string
   *   Request type.
   */
  private function type() {
    return gettype($this->getRaw());
  }

  /**
   * Helper request count.
   *
   * @return int
   *   Request data count.
   */
  private function count() {
    return count($this->getRaw());
  }

  /**
   * GETTERS / SETTERS.
   */

  /**
   * Get Method instance.
   *
   * @return \Emerap\Ra\Core\Method
   *   Method instance.
   */
  public function getMethod() {
    return $this->method;
  }

  /**
   * Set Method instance.
   *
   * @param \Emerap\Ra\Core\Method $method
   *   Method instance.
   *
   * @return $this
   */
  public function setMethod(Method $method) {
    $this->method = $method;
    return $this;
  }

  /**
   * Set Format instance.
   *
   * @param \Emerap\Ra\Core\FormatInterface $format
   *   Format instance.
   *
   * @return $this
   */
  private function setFormat(FormatInterface $format) {
    $this->format = $format;
    return $this;
  }

  /**
   * Get Error instance.
   *
   * @return \Emerap\Ra\Core\Error
   *   Error instance.
   */
  public function getError() {
    return $this->error;
  }

  /**
   * Set Error instance.
   *
   * @param Error $error
   *   Error instance.
   *
   * @return $this
   */
  public function setError(Error $error) {
    $this->error = $error;
    return $this;
  }

  /**
   * Get raw request after run method.
   *
   * @return mixed
   *   Raw data request.
   */
  public function getRaw() {
    return $this->raw;
  }

  /**
   * Set raw data.
   *
   * @param mixed $raw
   *   Request raw data.
   *
   * @return $this
   */
  public function setRaw($raw) {
    $this->raw = $raw;
    return $this;
  }

}
