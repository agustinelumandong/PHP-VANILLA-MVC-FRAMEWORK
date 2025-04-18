<?php
namespace App\Core;

use App\Models\User;
use App\Core\Model;
use Exception;

abstract class Auth
{
  protected static $user = null;

  public static function check()
  {
    return isset($_SESSION['users']);
  }

  public static function user()
  {
    if (self::$user === null && self::check()) {
      $sessionUser = $_SESSION['users'];
      if (is_array($sessionUser) && isset($sessionUser['id'])) {
        self::$user = User::find($sessionUser['id']);
      } elseif (is_object($sessionUser) && isset($sessionUser->id)) {
        self::$user = User::find($sessionUser->id);
      }
    }
    return self::$user;
  }

  public static function getByUserId($user = null)
  {
    $user = $user ?? static::user();
    if (!$user)
      return null;

    return is_array($user)
      ? ($user['id'] ?? null)
      : ($user->id ?? null);
  }

  public static function isAdmin()
  {
    $user = self::user();
    if ($user) {
      return is_array($user)
        ? (isset($user['role']) && $user['role'] === 'admin')
        : (isset($user->role) && $user->role === 'admin');
    }
    return false;
  }

  public static function login($user)
  {
    if (!$user) {
      throw new Exception('User not found or invalid');
    }

    $_SESSION['users'] = $user;

    session_regenerate_id(true);
  }

  public static function logout()
  {
    session_destroy();
    session_regenerate_id(true);
  }
}
