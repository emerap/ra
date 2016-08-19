<?php

namespace Emerap\Ra\Core;

interface DatabaseInterface {

  /**
   * Create new record on table.
   *
   * @param string $table
   * @param array $fields
   * @return array|bool
   */
  public function create($table, $fields = array());

  /**
   * Read record from table.
   *
   * @param string $table
   * @param array $fields
   * @return array|bool
   */
  public function read($table, $fields = array());

  /**
   * Update record from table.
   *
   * @param string $table
   * @param string $field
   * @param string $value
   * @param array $fields
   * @return string|bool
   */
  public function update($table, $field, $value, $fields = array());

  /**
   * Delete record from table.
   *
   * @param string $table
   * @param string $field
   * @param string $value
   * @return bool
   */
  public function delete($table, $field, $value);

}
