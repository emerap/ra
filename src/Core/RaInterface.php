<?php

namespace Emerap\Ra\Core;

interface RaInterface {

  /**
   * Get current engine.
   *
   * @return string
   */
  public static function getEngine();

  /**
   * Get User ID.
   *
   * @param int $user_id
   * @return int
   */
  public static function getUserID($user_id = NULL);

  /**
   * Get RaBase class name.
   *
   * @return string
   */
  public static function getRaBaseClass();

  /**
   * Get Ra class name.
   *
   * @return string
   */
  public static function getRaClass();

  /**
   * Get RaDataBase class name.
   *
   * @return string
   */
  public static function getRaDatabaseClass();

  /**
   * Get RaDatatype class name.
   *
   * @return string
   */
  public static function getRaDatatypeClass();

  /**
   * Get RaDefinition class name.
   *
   * @return string
   */
  public static function getRaDefinitionClass();

  /**
   * Get RaError class name.
   *
   * @return string
   */
  public static function getRaErrorClass();

  /**
   * Get RaMethod class name.
   *
   * @return string
   */
  public static function getRaMethodClass();

  /**
   * Get RaArgument class name.
   *
   * @return string
   */
  public static function getRaParameterClass();

  /**
   * Get RaResult class name.
   *
   * @return string
   */
  public static function getRaResultClass();

  /**
   * Get RaServerClient class name.
   *
   * @return string
   */
  public static function getRaServerClientClass();

  /**
   * Get RaToken class name.
   *
   * @return string
   */
  public static function getRaTokenClass();

}
