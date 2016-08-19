<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Result {

  protected $method;
  protected $raw;
  protected $error;
  protected $format = NULL;

  /**
   * Get formatted request.
   *
   * @return string
   */
  public function format() {
    $format = $this->getFormat();
    return $format->convert($this->getRequest());
  }

  /**
   * Get RaFormat object.
   *
   * @return FormatInterface
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
   * Get RaMethod object.
   *
   * @return Method
   */
  public function getMethod() {
    return $this->method;
  }

  /**
   * Set RaMethod object.
   *
   * @param Method $method
   * @return $this
   */
  public function setMethod(Method $method) {
    $this->method = $method;
    return $this;
  }

  /**
   * GETTERS / SETTERS
   */

  /**
   * Set RaFormat object.
   *
   * @param \Emerap\Ra\Core\FormatInterface $format
   * @return $this
   */
  private function setFormat(FormatInterface $format) {
    $this->format = $format;
    return $this;
  }

  /**
   * Get request object.
   *
   * @return array
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
   * Get RaError object.
   *
   * @return Error
   */
  public function getError() {
    return $this->error;
  }

  /**
   * Set RaError object.
   *
   * @param Error $error
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
   */
  public function getRaw() {
    return $this->raw;
  }

  /**
   * Set raw data.
   *
   * @param mixed $raw
   * @return $this
   */
  public function setRaw($raw) {
    $this->raw = $raw;
    return $this;
  }

  /**
   * Helper request type.
   *
   * @return string
   */
  private function type() {
    return gettype($this->getRaw());
  }

  /**
   * Helper request count.
   *
   * @return int
   */
  private function count() {
    return count($this->getRaw());
  }

}
