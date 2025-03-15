<?php
return [
  'debug' => App\Core\Helpers::env('APP_DEBUG', false),
  'app_name' => App\Core\Helpers::env('APP_NAME', 'MVC Framework'),
  'app_url' => App\Core\Helpers::env('APP_URL', 'http://localhost'),
  'timezone' => App\Core\Helpers::env('APP_TIMEZONE', 'UTC'),
];
?>