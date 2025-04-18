<?php
// web/bootstrap.php

use App\Core\Database;
use App\Core\Helpers;
use App\Core\Router;
use App\Core\Model;
// use Exception;

require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables
Helpers::loadEnv(__DIR__ . '/../.env');

// Load configuration
$config = require_once __DIR__ . '/../config/config.php';
$database = require_once __DIR__ . '/../config/database.php';

// Set up error handling
ini_set('display_errors', $config['debug'] ? 1 : 0);
error_reporting($config['debug'] ? E_ALL : 0);

// Start session
session_start();

// Session timeout configuration
$session_timeout = 1800; // 30 minutes in seconds

// Check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
  // Session expired
  session_unset();     // Remove all session variables
  session_destroy();   // Destroy the session

  // Redirect to login page if needed
  if (!empty($_SERVER['REQUEST_URI']) && !preg_match('/\/(login|register|public)/', $_SERVER['REQUEST_URI'])) {
    header('Location: /login');
    exit;
  }
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
  if (!empty($_SERVER['REQUEST_URI']) && preg_match('/^\/(login|register)(\?.*)?$/', $_SERVER['REQUEST_URI'])) {
    // Redirect to home page or dashboard
    header('Location: /dashboard');
    exit;
  }
}


// Create database connection
$db = new Database($database);

// Set database connection for models
Model::setDatabase($db);

// Create Router instance
$router = new Router();

// Load routes
require_once __DIR__ . '/routes.php';

// Get the request URI and method
$uri = $_SERVER['REQUEST_URI'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Dispatch the request
try {
  $router->dispatch($uri, $method);
} catch (Exception $e) {
  if ($config['debug']) {
    echo '<h1>Error</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
  } else {
    http_response_code(404);
    require_once __DIR__ . '/../app/Views/errors/404.php';
  }
}
