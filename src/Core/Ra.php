<?php

namespace Emerap\Ra\Core;

use Emerap\Ra\RaConfig;

/**
 * Class Ra.
 *
 * @package Emerap\Ra\Core
 */
class Ra {

  const CORE_VERSION = '1.0.0';

  /**
   * Call method.
   *
   * @param \Emerap\Ra\Core\Method $method
   *   Method instance.
   *
   * @return \Emerap\Ra\Core\Result
   *   Result.
   */
  public function call(Method $method) {
    $error = $this->prepare($method);
    $request = FALSE;

    // Call method if error code is zero.
    if ($error->getCode() === 0) {
      $request = $method->call();
    }
    // If passed error object from method callback.
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
   *   Method instance.
   *
   * @return \Emerap\Ra\Core\Error
   *   Operation Error instance.
   */
  private function prepare(Method &$method) {
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
   *   Request data.
   * @param \Emerap\Ra\Core\Method $method
   *   Method instance.
   * @param \Emerap\Ra\Core\Error $error
   *   Error instance.
   *
   * @return \Emerap\Ra\Core\Result
   *   Result instance.
   */
  private function result($request, Method $method, Error $error) {
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
   *   Field.
   *
   * @return array
   *   Core version information.
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
