<?php

// app/Middleware/GuestMiddleware.php

namespace App\Middleware;

use App\Core\Middleware;
use Closure;

class GuestMiddleware extends Middleware
{
  /**
   * Handle the request
   */
  public function handle($request, Closure $next)
  {
    // Check if user is logged in (using the same key as AuthMiddleware)
    if (isset($_SESSION['users'])) {
      // Redirect to home page if logged in
      header('Location: /');
      exit;
    }

    return $next($request);
  }
}
