<?php
// web/bootstrap.php
namespace App;

use App\Core\Database;
use App\Core\Helpers;
use App\Core\Router;
use App\Core\Model;
use Exception;

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

