<?php
// app/Models/User.php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
  protected $table = 'users';

  /**
   * Find a user by email
   */
  public function findByEmail(string $email)
  {
    return self::$db->query("SELECT * FROM {$this->table} WHERE email = ?")
      ->bind([1 => $email])
      ->execute()
      ->fetch();
  }

  /**
   * Authenticate a user
   */
  public function authenticate(string $email, string $password)
  {
    $user = $this->findByEmail($email);

    if (!$user) {
      return false;
    }

    return password_verify($password, $user['password']) ? $user : false;
  }
}