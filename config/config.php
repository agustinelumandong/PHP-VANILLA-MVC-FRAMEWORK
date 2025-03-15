<?php

namespace Config;

use App\Core\Helpers;

return [
  'debug' => Helpers::env('APP_DEBUG', false),
  'app_name' => Helpers::env('APP_NAME', 'MVC Framework'),
  'app_url' => Helpers::env('APP_URL', 'http://localhost'),
  'timezone' => Helpers::env('APP_TIMEZONE', 'UTC'),
];
?>