<?php
// app/Core/Middleware.php

namespace App\Core;

use App\Models\User;
use App\Core\Model;

abstract class Auth
{
  protected static $user = null;

  public static function check()
  {
    return isset($_SESSION['user']);
  }

  public static function user()
  {
    if (!self::$user && self::check()) {
      // Assuming you have a User model to fetch user details
      self::$user = User::find($_SESSION['user']);
    }
    return self::$user;
  }

  public static function login($user)
  {
    // Assuming $user is an instance of the User model or an associative array with user data
    if (is_array($user)) {
      $_SESSION['user'] = $user['id'];

    } else {
      // If $user is an object, you can access its properties directly
      $_SESSION['user'] = $user->id;
    }
    if (!$user) {
      throw new \Exception('User not found');
    }

    // Regenerate session ID to prevent session fixation attacks
    session_regenerate_id(true);
  }

  public static function logout()
  {
    session_destroy(); // Destroy the session
    session_regenerate_id(true); // Regenerate session ID to prevent session fixation attacks
  }
}
