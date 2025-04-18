<?php

// app/Middleware/AuthMiddleware.php

namespace App\Middleware;

use App\Core\Middleware;
use Closure;

class AuthMiddleware extends Middleware
{
  /**
   * Handle the request
   */
  public function handle($request, Closure $next)
  {
    if (!isset($_SESSION['users'])) {
      // Store the intended URL in the session
      $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];

      // Redirect to login page
      header('Location: /login');
      exit;
    }

    return $next($request);
  }
}