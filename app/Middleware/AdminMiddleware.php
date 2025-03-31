<?php

namespace App\Middleware;

use App\Core\Middleware;
use App\Models\Profile;
use Closure;

class AdminMiddleware extends Middleware
{
  public function handle($request, Closure $next)
  {
    // Check if user is logged in
    if (!isset($_SESSION['user'])) {
      $_SESSION['error'] = 'You must be logged in to access this page';
      header('Location: /login');
      exit;
    }

    // Check if user is admin
    // This would require getting the user from database
    $user = (new Profile())->find($_SESSION['user']);
    if (!$user || $user->role !== 'admin') {
      $_SESSION['error'] = 'You do not have permission to access this page';
      header('Location: /');
      exit;
    }

    return $next($request);
  }
}
