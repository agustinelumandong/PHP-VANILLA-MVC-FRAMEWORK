<?php

// app/Core/Helpers.php

namespace App\Core;

class Helpers
{
  /**
   * Load environment variables from .env file
   */
  public static function loadEnv(string $path)
  {
    if (!file_exists($path)) {
      return false;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
      // Skip comments
      if (strpos(trim($line), '#') === 0) {
        continue;
      }

      list($name, $value) = explode('=', $line, 2);
      $name = trim($name);
      $value = trim($value);

      // Remove quotes if present
      if (preg_match('/^([\'"])(.*)\1$/', $value, $matches)) {
        $value = $matches[2];
      }

      putenv("{$name}={$value}");
      $_ENV[$name] = $value;
      $_SERVER[$name] = $value;
    }

    return true;
  }

  /**
   * Get environment variable
   */
  public static function env(string $key, $default = null)
  {
    $value = getenv($key);

    if ($value === false) {
      return $default;
    }

    switch (strtolower($value)) {
      case 'true':
      case '(true)':
        return true;
      case 'false':
      case '(false)':
        return false;
      case 'null':
      case '(null)':
        return null;
    }

    return $value;
  }

  /**
   * Format URL
   */
  public static function url(string $path = '')
  {
    $baseUrl = rtrim(self::env('APP_URL', ''), '/');
    $path = ltrim($path, '/');

    return $baseUrl . '/' . $path;
  }

  /**
   * Get asset URL
   */
  public static function asset(string $path): string
  {
    $path = ltrim($path, '/');
    return self::url("assets/{$path}");  // Remove the duplicate "public/"
  }

  // D:\proprojects\mvc\public

  /**
   * Format date
   */
  public static function formatDate(string $date, string $format = 'Y-m-d H:i:s')
  {
    return date($format, strtotime($date));
  }
}
?>