<?php

namespace Emerap\Ra\Core;

/**
 * Interface RaInterface.
 *
 * @package Emerap\Ra\Core
 */
interface RaInterface {

  /**
   * Get current engine.
   *
   * @return string
   *   Engine.
   */
  public static function getEngine();

  /**
   * Get User ID.
   *
   * @param int $user_id
   *   User id.
   *
   * @return int
   *   User id.
   */
  public static function getUserId($user_id = NULL);

  /**
   * Get RaBase class name.
   *
   * @return string
   *   RaBase class name.
   */
  public static function getRaBaseClass();

  /**
   * Get Ra class name.
   *
   * @return string
   *   Ra class name.
   */
  public static function getRaClass();

  /**
   * Get RaDataBase class name.
   *
   * @return string
   *   RaDataBase class name.
   */
  public static function getRaDatabaseClass();

  /**
   * Get RaDatatype class name.
   *
   * @return string
   *   RaDatatype class name.
   */
  public static function getRaDatatypeClass();

  /**
   * Get RaDefinition class name.
   *
   * @return string
   *   RaDefinition class name.
   */
  public static function getRaDefinitionClass();

  /**
   * Get RaError class name.
   *
   * @return string
   *   RaError class name.
   */
  public static function getRaErrorClass();

  /**
   * Get RaMethod class name.
   *
   * @return string
   *   RaMethod class name.
   */
  public static function getRaMethodClass();

  /**
   * Get RaParameter class name.
   *
   * @return string
   *   RaParameter class name.
   */
  public static function getRaParameterClass();

  /**
   * Get RaResult class name.
   *
   * @return string
   *   RaResult class name.
   */
  public static function getRaResultClass();

  /**
   * Get RaServerClient class name.
   *
   * @return string
   *   RaServerClient class name.
   */
  public static function getRaServerClientClass();

  /**
   * Get RaToken class name.
   *
   * @return string
   *   RaToken class name.
   */
  public static function getRaTokenClass();

}
