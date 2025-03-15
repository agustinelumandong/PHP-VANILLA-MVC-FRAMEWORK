<?php
// app/Core/Input.php

namespace App\Core;

class Input
{
  /**
   * Get a value from GET request
   */
  public static function get(string $key = null, $default = null)
  {
    if ($key === null) {
      return $_GET;
    }

    return $_GET[$key] ?? $default;
  }

  /**
   * Get a value from POST request
   */
  public static function post(string $key = null, $default = null)
  {
    if ($key === null) {
      return $_POST;
    }

    return $_POST[$key] ?? $default;
  }

  /**
   * Get a value from either GET or POST
   */
  public static function any(string $key, $default = null)
  {
    return self::get($key, self::post($key, $default));
  }

  /**
   * Check if the request is AJAX
   */
  public static function isAjax(): bool
  {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
      strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
  }

  /**
   * Get request method
   */
  public static function method(): string
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  /**
   * Sanitize input
   */
  public static function sanitize($input)
  {
    if (is_array($input)) {
      return array_map([self::class, 'sanitize'], $input);
    }

    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
  }
}
?>