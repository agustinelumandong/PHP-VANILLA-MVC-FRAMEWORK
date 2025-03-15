<?php
// app/Core/Middleware.php

namespace App\Core;

abstract class Middleware
{
  /**
   * Handle the request
   */
  abstract public function handle($request, \Closure $next);

  /**
   * Run the middleware
   */
  public static function run($middleware, $request)
  {
    $instance = new $middleware();

    return $instance->handle($request, function ($request) {
      return $request;
    });
  }
}