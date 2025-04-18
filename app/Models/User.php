<?php
// app/Models/User.php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
  protected static $table = 'users';

  public function __construct()
  {
    // Empty constructor - no need to set table here
  }

  public function getAllUserIds(): array
  {
    $results = self::$db->query("SELECT id FROM " . static::$table)
      ->execute()
      ->fetchAll();
    return $results ? $results : [];
  }

  /**
   * Find a user by email
   */
  public static function findByEmail(string $email)
  {
    return self::$db->query("SELECT * FROM " . static::$table . " WHERE email = ?")
      ->bind([1 => $email])
      ->execute()
      ->fetch();
  }

  /**
   * Authenticate a user
   */
  public static function authenticate(string $email, string $password)
  {
    $user = self::findByEmail($email);

    if (!$user) {
      return false;
    }

    return password_verify($password, $user['password']) ? $user : false;
  }

  public function getUserStats($userId)
  {
    return self::$db->query("SELECT * FROM userstats WHERE id = ?")
      ->bind([1 => $userId])
      ->execute()
      ->fetch();
  }




}
