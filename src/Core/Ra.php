<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

class Ra {

  const CORE_VERSION = '1.0.0';

  /**
   * Call method.
   *
   * @param \Emerap\Ra\Core\Method $method
   * @return \Emerap\Ra\Core\Result
   */
  public function call($method) {
    $error = $this->prepare($method);
    $request = FALSE;

    // Call method if error code zero Если нет ошибок то выполняем метод
    if ($error->getCode() === 0) {
      $request = $method->call();
    }
    // If passed error object from method callback
    if ($request instanceof Error) {
      $error = $request;
    }

    $result = $this->result($request, $method, $error);
    return $result;
  }

  /**
   * Prepare before call method callback.
   *
   * @param \Emerap\Ra\Core\Method $method
   * @return \Emerap\Ra\Core\Error
   */
  private function prepare(&$method) {
    $error = $method->isAvailable();
    $user_input = $method->getParams();

    if (isset($user_input['lang'])) {
      $error->setLangCode($user_input['lang']);
    }

    return $error;
  }

  /**
   * Build result.
   *
   * @param mixed $request
   * @param \Emerap\Ra\Core\Method $method
   * @param \Emerap\Ra\Core\Error $error
   * @return \Emerap\Ra\Core\Result
   */
  private function result($request, $method, $error) {
    $req = RaConfig::instanceResult()
      ->setRaw($request)
      ->setMethod($method)
      ->setError($error);
    return $req;
  }

  /**
   * Get core version.
   *
   * @param string $field
   * @return array
   */
  public function version($field = 'all') {
    $fields = [
      'engine' => RaConfig::getEngine(),
      'version' => self::CORE_VERSION,
    ];

    if (($field !== 'all') && (isset($fields[$field]))) {
      return $fields[$field];
    }
    return $fields;
  }

}
