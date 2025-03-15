<?php

namespace Web;

use App\Controllers\HomeController;
use App\Controllers\UserController;
use Exception;

try {



  // Define routes
  $router->get('/', [HomeController::class, 'index']);
  $router->get('/about', [HomeController::class, 'about']);
  $router->get('/contact', [HomeController::class, 'contact']);

  // User routes
  $router->get('/users', [UserController::class, 'index']);
  $router->get('/users/create', [UserController::class, 'create']);
  $router->post('/users', [UserController::class, 'store']);
  $router->get('/users/{id}', [UserController::class, 'show']);
  $router->get('/users/{id}/edit', [UserController::class, 'edit']);
  $router->put('/users/{id}', [UserController::class, 'update']);
  $router->delete('/users/{id}', [UserController::class, 'destroy']);



} catch (Exception $e) {
  echo '<h1>Error</h1>';
  echo '<p>' . $e->getMessage() . '</p>';
  echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
