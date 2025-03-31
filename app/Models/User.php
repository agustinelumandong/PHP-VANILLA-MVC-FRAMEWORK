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

  /**
   * Retrieve user email using inner join
   */
  public function getUserEmail()
  {
    $sql = "SELECT " . static::$table . ".email, profiles.first_name, profiles.last_name
      FROM " . static::$table . "
      INNER JOIN profiles
      ON " . static::$table . ".id = profiles.user_id";

    return self::$db->query($sql)->execute()->fetchAll();
  }

  /**
   * Retrieve user email using left join
   */
  public function getUserEmailLeftJoin()
  {
    return self::$db->query(
      "SELECT " . static::$table . ".email, profiles.first_name, profiles.last_name
      FROM " . static::$table . "
      LEFT JOIN profiles
      ON " . static::$table . ".id = profiles.user_id"
    )
      ->execute()
      ->fetchAll();
  }

}
