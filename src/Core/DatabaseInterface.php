<?php

namespace Emerap\Ra\Core;

/**
 * Interface DatabaseInterface.
 *
 * @package Emerap\Ra\Core
 */
interface DatabaseInterface {

  /**
   * Create new record on table.
   *
   * @param string $table
   *   Table name.
   * @param array $fields
   *   Fields data.
   *
   * @return array|bool
   *   State or fetched data.
   */
  public function create($table, $fields = array());

  /**
   * Read record from table.
   *
   * @param string $table
   *   Table name.
   * @param array $fields
   *   Fields data.
   *
   * @return array|bool
   *   State or fetched data.
   */
  public function read($table, $fields = array());

  /**
   * Update record from table.
   *
   * @param string $table
   *   Table name.
   * @param string $field
   *   Field name.
   * @param string|int $value
   *   Field value.
   * @param array $fields
   *   Fields data.
   *
   * @return array|bool State or fetched data.
   *   State or fetched data.
   */
  public function update($table, $field, $value, $fields = array());

  /**
   * Delete record from table.
   *
   * @param string $table
   *   Table name.
   * @param string $field
   *   Field name.
   * @param string|int $value
   *   Field value.
   *
   * @return array|bool State or fetched data.
   *   State or fetched data.
   */
  public function delete($table, $field, $value);

}
