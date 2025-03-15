<?php
// app/Core/Model.php

namespace App\Core;

abstract class Model
{
  protected static $db;     // Database connection
  protected $table;        // Table name

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
  public function find(int $id)
  {
    return self::$db->query("SELECT * FROM {$this->table} WHERE id = ?")
      ->bind([1 => $id])
      ->execute()
      ->fetch();
  }

  /**
   * Get all records
   */
  public function all()
  {
    return self::$db->query("SELECT * FROM {$this->table}")
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

    $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

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

    $sql = "UPDATE {$this->table} SET {$fields} WHERE id = :id";

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
    return self::$db->query("DELETE FROM {$this->table} WHERE id = ?")
      ->bind([1 => $id])
      ->execute()
      ->rowCount();
  }
}