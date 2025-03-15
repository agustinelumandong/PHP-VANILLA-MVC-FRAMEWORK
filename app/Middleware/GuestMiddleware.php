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
    if (isset($_SESSION['user_id'])) {
      // Redirect to home page
      header('Location: /');
      exit;
    }

    return $next($request);
  }
}