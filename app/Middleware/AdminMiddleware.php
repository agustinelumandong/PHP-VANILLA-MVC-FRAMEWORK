<?php

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Middleware;
use App\Models\Profile;
use App\Models\User;
use Closure;

class AdminMiddleware extends Middleware
{
  public function handle($request, Closure $next)
  {
    // Check if user is logged in
    if (!isset($_SESSION['users'])) {
      $_SESSION['error'] = 'You must be logged in to access this page';
      header('Location: /login');
      exit;
    }

    // Check if user is admin

    // Get the user ID from the session array/object
    $userId = $_SESSION['users']['id'] ?? $_SESSION['users']->id ?? null;

    if ($userId === null) {
      // Should not happen if AuthMiddleware ran first, but good practice
      $_SESSION['error'] = 'User session data is invalid.';
      header('Location: /login');
      exit;
    }

    // Use Auth service for authentication checks
    $userId = Auth::user();

    // Check if user is admin
    $userIsAdmin = Auth::isAdmin();
    if (!$userIsAdmin) {
      $_SESSION['error'] = 'You do not have permission to access this page';
      header('Location: /');
      exit;
    }

    return $next($request);
  }
}
