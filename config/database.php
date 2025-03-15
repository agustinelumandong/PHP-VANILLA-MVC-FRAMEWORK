<?php
return [
  'host' => App\Core\Helpers::env('DB_HOST', 'localhost'),
  'database' => App\Core\Helpers::env('DB_DATABASE', 'mvc'),
  'username' => App\Core\Helpers::env('DB_USERNAME', 'root'),
  'password' => App\Core\Helpers::env('DB_PASSWORD', ''),
  'charset' => App\Core\Helpers::env('DB_CHARSET', 'utf8mb4'),
];
?>