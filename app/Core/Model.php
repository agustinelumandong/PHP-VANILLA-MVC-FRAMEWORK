<?php
// app/Core/Model.php

namespace App\Core;

abstract class Model
{
  protected static $db;     // Database connection
  protected static $table;        // Table name

  /**
   * Set the database connection
   */
  public static function setDatabase(Database $database)
  {
    self::$db = $database;
  }

  /**
   * Find a record by ID
   */
  public static function find(int $id)
  {
    return self::$db->query("SELECT * FROM " . static::$table . " WHERE id = ?")
      ->bind([1 => $id])
      ->execute()
      ->fetch();
  }

  /**
   * Get all records
   */
  public function all()
  {
    return self::$db->query("SELECT * FROM " . static::$table)
      ->execute()
      ->fetchAll();
  }

  /**
   * Create a new record
   */
  public function create(array $data)
  {
    $columns = implode(', ', array_keys($data));
    $placeholders = ':' . implode(', :', array_keys($data));

    $sql = "INSERT INTO " . static::$table . " ({$columns}) VALUES ({$placeholders})";

    self::$db->query($sql)
      ->bind($data)
      ->execute();

    return self::$db->lastInsertId();
  }

  /**
   * Update a record
   */
  public function update(int $id, array $data)
  {
    $fields = '';
    foreach (array_keys($data) as $key) {
      $fields .= "{$key} = :{$key}, ";
    }
    $fields = rtrim($fields, ', ');

    $sql = "UPDATE " . static::$table . " SET {$fields} WHERE id = :id";

    $data['id'] = $id;

    return self::$db->query($sql)
      ->bind($data)
      ->execute()
      ->rowCount();
  }

  /**
   * Delete a record
   */
  public function delete(int $id)
  {
    return self::$db->query("DELETE FROM " . static::$table . " WHERE id = ?")
      ->bind([1 => $id])
      ->execute()
      ->rowCount();
  }

  /**
   * Find a record by column
   */
  public function findBy(string $column, $value)
  {
    return self::$db->query("SELECT * FROM " . static::$table . " WHERE {$column} = ?")
      ->bind([1 => $value])
      ->execute()
      ->fetch();
  }

  /**
   * Find all records by column
   */
  public function findAllBy(string $column, $value)
  {
    return self::$db->query("SELECT * FROM " . static::$table . " WHERE {$column} = ?")
      ->bind([1 => $value])
      ->execute()
      ->fetchAll();
  }

  /**
   * Get the total number of records
   */
  public function count()
  {
    $result = self::$db->query("SELECT COUNT(*) FROM " . static::$table)
      ->execute()
      ->fetch();
    return is_array($result) ? reset($result) : 0;
  }

  /**
   * Get the last inserted ID
   */
  public function lastInsertId()
  {
    return self::$db->lastInsertId();
  }

  /**
   * Get the database connection
   */
  public function getDatabase()
  {
    return self::$db;
  }

  /**
   * Get the table name
   */
  public function getTable()
  {
    return $this->table;
  }

  /**
   * Get the primary key
   */
  public function getPrimaryKey()
  {
    return 'id';
  }

  /**
   * Get the timestamp columns
   */
  public function getTimestamps()
  {
    return ['created_at', 'updated_at'];
  }

  /**
   * Get the soft delete column
   */
  public function getSoftDelete()
  {
    return 'deleted_at';
  }

  /**
   * Get the date format
   */
  public function getDateFormat()
  {
    return 'Y-m-d H:i:s';
  }

  /**
   * Validate if the record exists
   */

  public function doesRecordAlreadyExist(string $data): bool
  {
    return self::$db->query("SELECT * FROM " . static::$table . " WHERE email = ?")
      ->bind([1 => $data])
      ->execute()
      ->fetch() ? true : false;
  }

  /**
   * Is the email valid
   */
  public function isEmailValid(string $data): bool
  {
    return filter_var($data, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Is the password valid
   */
  public function isPasswordValid(string $password): bool
  {
    return strlen($password) >= 8;
  }

}
