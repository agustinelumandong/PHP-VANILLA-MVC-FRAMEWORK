<?php

namespace Web;

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Middleware\AuthMiddleware;

use Exception;

try {



  // Define routes
  $router->get('/', [HomeController::class, 'index']);
  $router->get('/about', [HomeController::class, 'about']);
  
  // Auth routes
  $router->get('/login', [AuthController::class, 'index']);
  $router->post('/login', [AuthController::class, 'login']);
  $router->get('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class]);
  $router->get('/register', [AuthController::class, 'register']);
  $router->post('/register', [AuthController::class, 'store']);
  
  
  // User routes
  $router->get('/contact', [HomeController::class, 'contact'], [AuthMiddleware::class]);
  $router->get('/users', [UserController::class, 'index'], [AuthMiddleware::class]);
  $router->get('/users/create', [UserController::class, 'create'], [AuthMiddleware::class]);
  $router->post('/users', [UserController::class, 'store'], [AuthMiddleware::class]);
  $router->get('/users/{id}', [UserController::class, 'show'], [AuthMiddleware::class]);
  $router->get('/users/{id}/edit', [UserController::class, 'edit'], [AuthMiddleware::class]);
  $router->put('/users/{id}', [UserController::class, 'update'], [AuthMiddleware::class]);
  $router->delete('/users/{id}', [UserController::class, 'destroy'], [AuthMiddleware::class]);


} catch (Exception $e) {
  echo '<h1>Error</h1>';
  echo '<p>' . $e->getMessage() . '</p>';
  echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
