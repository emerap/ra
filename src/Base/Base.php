<?php

namespace Emerap\Ra\Base;

use Emerap\Ra\Core\DatatypeInterface;
use Emerap\Ra\Core\DefinitionInterface;
use Emerap\Ra\Core\FormatInterface;
use Emerap\Ra\Core\RaInterface;
use Emerap\Ra\RaConfig;

/**
 * Class Base.
 *
 * @package Emerap\Ra\Base
 */
abstract class Base implements RaInterface {

  /**
   * Get all available parameter types.
   *
   * @return \Emerap\Ra\Core\DatatypeInterface[]
   *   All available parameter types.
   */
  public static function getDatatypes() {
    return self::getCoreDatatypes();
  }

  /**
   * Get core datatypes.
   *
   * @return \Emerap\Ra\Core\DatatypeInterface[]
   *   Core datatypes.
   */
  public static function getCoreDatatypes() {
    $datatypes_array = array(
      '\Emerap\Ra\RaDatatype\BooleanType',
      '\Emerap\Ra\RaDatatype\NumberType',
      '\Emerap\Ra\RaDatatype\StringType',
      '\Emerap\Ra\RaDatatype\TokenType',
    );
    $datatypes = array();
    foreach ($datatypes_array as $namespace) {
      $instance = self::getDatatypeFromClass($namespace);
      $datatypes[$instance->getType()] = $instance;
    }
    return $datatypes;
  }

  /**
   * Get datatype instance from namespace.
   *
   * @param \Emerap\Ra\Core\DatatypeInterface|string $namespace
   *   Instance or namespace or class name string.
   *
   * @return \Emerap\Ra\Core\DatatypeInterface
   *   Instance DatatypeInterface.
   */
  public static function getDatatypeFromClass($namespace) {
    if ($namespace instanceof DatatypeInterface) {
      $instance = $namespace;
    }
    else {
      $instance = new $namespace();
    }
    return $instance;
  }

  /**
   * Get all available method definitions.
   *
   * @return \Emerap\Ra\Core\Definition[]
   *   All available method definitions.
   */
  public static function getDefinitions() {
    return self::getCoreDefinitions();
  }

  /**
   * Get core definitions.
   *
   * @return \Emerap\Ra\Core\Definition[]
   *   Core definitions.
   */
  public static function getCoreDefinitions() {
    $definitions_array = array(
      '\Emerap\Ra\RaDefinition\RaDatatypesDefinition',
      '\Emerap\Ra\RaDefinition\RaFormatsDefinition',
      '\Emerap\Ra\RaDefinition\RaMethodsDefinition',
      '\Emerap\Ra\RaDefinition\RaPairDefinition',
      '\Emerap\Ra\RaDefinition\RaTokenDefinition',
      '\Emerap\Ra\RaDefinition\RaVersionDefinition',
    );
    $definitions = array();
    foreach ($definitions_array as $namespace) {
      $instance = self::getDefinitionFromClass($namespace);
      $definitions[$instance->getName()] = $instance;
    }
    return $definitions;
  }

  /**
   * Get definition instance from namespace.
   *
   * @param \Emerap\Ra\Core\DefinitionInterface|string $namespace
   *   Instance or namespace or class name string.
   *
   * @return \Emerap\Ra\Core\Definition
   *   Instance Definition.
   */
  public static function getDefinitionFromClass($namespace) {
    if ($namespace instanceof DefinitionInterface) {
      $instance = $namespace;
    }
    else {
      $instance = new $namespace();
    }

    $definition = RaConfig::instanceDefinition();
    return $definition->setName($instance->getMethodName())
      ->setMethodCallback($instance, 'execute')
      ->setMethodParams($instance->getMethodParams())
      ->setSecurity(!$instance->isPublic())
      ->setSection($instance->getSection())
      ->setAccessCallback($instance->getAccessCallback())
      ->setAccessArguments($instance->getAccessParams())
      ->setDescription($instance->getDescription());
  }

  /**
   * Get all available formats.
   *
   * @return \Emerap\Ra\Core\FormatInterface[]
   *   All available formats.
   */
  public static function getFormats() {
    return self::getCoreFormats();
  }

  /**
   * Get core formats.
   *
   * @return \Emerap\Ra\Core\FormatInterface[]
   *   Core formats.
   */
  public static function getCoreFormats() {
    $formats_array = array(
      '\Emerap\Ra\RaFormat\JsonFormat',
    );
    $formats = array();
    foreach ($formats_array as $namespace) {
      $instance = self::getFormatFromClass($namespace);
      $formats[$instance->getType()] = $instance;
    }
    return $formats;
  }

  /**
   * Get format instance from namespace.
   *
   * @param \Emerap\Ra\Core\FormatInterface|string $namespace
   *   Instance or namespace or class name string.
   *
   * @return \Emerap\Ra\Core\FormatInterface
   *   Instance FormatInterface.
   */
  public static function getFormatFromClass($namespace) {
    if ($namespace instanceof FormatInterface) {
      $instance = $namespace;
    }
    else {
      $instance = new $namespace();
    }
    return $instance;
  }

  /**
   * Get default data type.
   *
   * @return string
   *   Default datatype.
   */
  public static function getDefaultDatatype() {
    return 'string';
  }

  /**
   * Get default format type.
   *
   * @return string
   *   Default format type.
   */
  public static function getDefaultFormatType() {
    return 'json';
  }

  /**
   * Get class instances.
   */

  /**
   * Get Ra instance.
   *
   * @return \Emerap\Ra\Core\Ra
   *   Instance Ra.
   */
  public static function instanceRa() {
    $class = RaConfig::getRaClass();
    return new $class();
  }

  /**
   * Get Database instance.
   *
   * @return \Emerap\Ra\Base\Database
   *   Instance Database.
   */
  public static function instanceDatabase() {
    $class = RaConfig::getRaDatabaseClass();
    return new $class();
  }

  /**
   * Get Datatype instance.
   *
   * @return \Emerap\Ra\Core\Datatype
   *   Instance Datatype.
   */
  public static function instanceDataType() {
    $class = RaConfig::getRaDatatypeClass();
    return new $class();
  }

  /**
   * Get RaDefinition instance.
   *
   * @return \Emerap\Ra\Core\Definition
   *   Instance Definition.
   */
  public static function instanceDefinition() {
    $class = RaConfig::getRaDefinitionClass();
    return new $class();
  }

  /**
   * Get Error instance.
   *
   * @param int $code
   *   Error code.
   * @param array $vars
   *   Error variables.
   *
   * @return \Emerap\Ra\Core\Error
   *   Instance Error.
   */
  public static function instanceError($code = 0, $vars = array()) {
    $class = RaConfig::getRaErrorClass();
    return new $class($code, $vars);
  }

  /**
   * Get Method instance.
   *
   * @param string $name
   *   Method name.
   * @param array $params
   *   Method params.
   *
   * @return \Emerap\Ra\Core\Method
   *   Instance Method.
   */
  public static function instanceMethod($name, $params = array()) {
    $class = RaConfig::getRaMethodClass();
    return new $class($name, $params);
  }

  /**
   * Get Parameter instance.
   *
   * @param string $name
   *   Parameter key.
   * @param int|string|bool $default
   *   Parameter default value.
   * @param string $type
   *   Parameter datatype.
   *
   * @return \Emerap\Ra\Core\Parameter
   *   Instance Parameter
   */
  public static function instanceParam($name, $default = NULL, $type = NULL) {
    $class = RaConfig::getRaParameterClass();
    return new $class($name, $default, $type);
  }

  /**
   * Get Result instance.
   *
   * @return \Emerap\Ra\Core\Result
   *   Instance Result.
   */
  public static function instanceResult() {
    $class = RaConfig::getRaResultClass();
    return new $class();
  }

  /**
   * Get ServerClient instance.
   *
   * @return \Emerap\Ra\Core\ServerClient
   *   Instance ServerClient.
   */
  public static function instanceServerClient() {
    $class = RaConfig::getRaServerClientClass();
    return new $class();
  }

  /**
   * Get Token instance.
   *
   * @return \Emerap\Ra\Core\Token
   *   Instance Token.
   */
  public static function instanceToken() {
    $class = RaConfig::getRaTokenClass();
    return new $class();
  }

  /**
   * Helpers.
   */

  /**
   * Generate unique string.
   *
   * @param string $salt
   *   Salt for generation.
   * @param int $length
   *   Length string.
   *
   * @return string
   *   Generated unique string.
   */
  public static function uniqueString($salt, $length = 12) {
    $gen_string = md5(uniqid(TRUE) . $salt . time());
    $rand = (strlen($gen_string) > $length) ?
      rand(0, (strlen($gen_string) - $length)) : 0;
    $sub = substr($gen_string, $rand, $length);
    $result = '';

    for ($i = 0; $i < strlen($sub); $i++) {
      $word = $sub[$i];
      if (!is_numeric($sub[$i]) && rand(0, 1)) {
        $word = strtoupper($word);
      }
      $result .= $word;
    }
    return $result;
  }

  /**
   * Get expire time delay.
   *
   * @param string $delay
   *   Expire delay (example +15 second).
   *
   * @return int
   *   Expire time delay.
   */
  public static function getExpireTime($delay = '+15 minutes') {
    return strtotime($delay);
  }

  /**
   * Get errors list.
   *
   * @return array
   *   Errors list.
   */
  public static function getErrorsList() {
    return array(
      0 => 'No errors',
      100 => 'Field "%field" is NULL or EMPTY in method definition "%method"',
      101 => 'Method "%method" contain invalid parameter "%parameter"',
      102 => 'Method access denied',
      103 => 'Method "%method" not defined',
      104 => 'Missing parameter. Parameter "%parameter" is require',
      105 => 'Require argument "%parameter" must be not empty',

      200 => 'Token is invalid',
      201 => 'Token is expired',

      300 => 'Wrong parameter "%parameter" value',

      400 => 'Invite time is expired',
      401 => 'Invalid pin for pairing',
      402 => 'Invalid invite id',

      500 => 'Invalid client id',
    );
  }

  /**
   * Get database table names.
   */

  /**
   * Get database table name for client.
   *
   * @return string
   *   Database table name for client.
   */
  public static function getTableClient() {
    return 'ra_client';
  }

  /**
   * Get database table name for invite.
   *
   * @return string
   *   Database table name for invite.
   */
  public static function getTableInvite() {
    return 'ra_invite';
  }

  /**
   * Default classes.
   */

  /**
   * {@inheritdoc}
   */
  public static function getRaBaseClass() {
    return '\Emerap\Ra\Base\Base';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaClass() {
    return '\Emerap\Ra\Core\Ra';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaDatabaseClass() {
    return '\Emerap\Ra\Base\Database';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaDatatypeClass() {
    return '\Emerap\Ra\Core\Datatype';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaDefinitionClass() {
    return '\Emerap\Ra\Core\Definition';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaErrorClass() {
    return '\Emerap\Ra\Core\Error';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaMethodClass() {
    return '\Emerap\Ra\Core\Method';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaParameterClass() {
    return '\Emerap\Ra\Core\Parameter';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaResultClass() {
    return '\Emerap\Ra\Core\Result';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaServerClientClass() {
    return '\Emerap\Ra\Core\ServerClient';
  }

  /**
   * {@inheritdoc}
   */
  public static function getRaTokenClass() {
    return '\Emerap\Ra\Core\Token';
  }

}
