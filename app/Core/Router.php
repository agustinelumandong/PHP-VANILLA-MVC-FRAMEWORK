<?php
// app/Core/Router.php

namespace App\Core;

use Exception;

class Router
{
  protected $routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => []
  ];

  protected $params = [];

  /**
   * Register a GET route
   */
  public function get(string $uri, array $controller, array $middleware = [])
  {
    $this->routes['GET'][$uri] = [
      'controller' => $controller,
      'middleware' => $middleware
    ];
    return $this;
  }

  /**
   * Register a POST route
   */
  public function post(string $uri, array $controller, array $middleware = [])
  {
    $this->routes['POST'][$uri] = [
      'controller' => $controller,
      'middleware' => $middleware
    ];
    return $this;
  }

  /**
   * Register a PUT route
   */
  public function put(string $uri, array $controller, array $middleware = [])
  {
    $this->routes['PUT'][$uri] = [
      'controller' => $controller,
      'middleware' => $middleware
    ];
    return $this;
  }

  /**
   * Register a DELETE route
   */
  public function delete(string $uri, array $controller, array $middleware = [])
  {
    $this->routes['DELETE'][$uri] = [
      'controller' => $controller,
      'middleware' => $middleware
    ];
    return $this;
  }

  /**
   * Dispatch the route based on URI and method
   */
  public function dispatch(string $uri, string $method)
  {
    $uri = $this->removeQueryString($uri);

    // Method spoofing - check for _method field in POST requests
    if ($method === 'POST' && isset($_POST['_method'])) {
      $method = strtoupper($_POST['_method']);
    }

    // First check for exact route match
    if (array_key_exists($uri, $this->routes[$method])) {
      $route = $this->routes[$method][$uri];

      // Apply middleware if any exists
      if (!empty($route['middleware'])) {
        $request = $_REQUEST;
        foreach ($route['middleware'] as $middleware) {
          $request = \App\Core\Middleware::run($middleware, $request);
        }
      }
      return $this->callAction(
        $route['controller'][0],
        $route['controller'][1]
      );

      // Handle middleware
      // if (isset($this->routes[$method][$uri]['middleware'])) {
      //   $middleware = $this->routes[$method][$uri]['middleware'];
      //   $request = $_REQUEST;

      //   $request = Middleware::run($middleware, $request);
      // }

      // return $this->callAction(
      //   $this->routes[$method][$uri][0],
      //   $this->routes[$method][$uri][1]
      // );
    }

    // Check for routes with parameters
    foreach ($this->routes[$method] as $route => $config) {
      if ($this->matchRoute($route, $uri)) {
        // Apply middleware if any exists
        if (!empty($config['middleware'])) {
          $request = $_REQUEST;
          foreach ($config['middleware'] as $middleware) {
            $request = \App\Core\Middleware::run($middleware, $request);
          }
        }
        return $this->callAction(
          $config['controller'][0],
          $config['controller'][1]
        );
      }
    }

    throw new Exception("No route defined for {$uri} with method {$method}");
  }

  /**
   * Match a route pattern with parameters to a URI
   */
  protected function matchRoute(string $route, string $uri)
  {
    // If no parameters in route, return false
    if (strpos($route, '{') === false) {
      return false;
    }

    // Convert route parameters to regex pattern
    $pattern = preg_replace('/{([a-zA-Z0-9_]+)}/', '([^/]+)', $route);
    $pattern = '#^' . $pattern . '$#';

    if (preg_match($pattern, $uri, $matches)) {
      // Extract parameter values
      preg_match_all('/{([a-zA-Z0-9_]+)}/', $route, $paramNames);
      $paramNames = $paramNames[1];

      // Remove the first match (the full match)
      array_shift($matches);

      // Combine parameter names with values
      foreach ($paramNames as $index => $name) {
        if (isset($matches[$index])) {
          $_GET[$name] = $matches[$index];
          $_POST[$name] = $matches[$index];
        }
      }

      return true;
    }

    return false;
  }

  /**
   * Remove query string from URI
   */
  protected function removeQueryString(string $uri)
  {
    return parse_url($uri, PHP_URL_PATH) ?? $uri;
  }

  /**
   * Call the controller action
   */
  protected function callAction(string $controller, string $action)
  {
    $controller = new $controller();

    if (!method_exists($controller, $action)) {
      throw new Exception("{$action} does not exist on {$controller}");
    }

    // Get parameters from the URL and pass them to the controller method
    $params = [];

    // If we have parameter values in $_GET, use them
    foreach ($_GET as $key => $value) {
      if ($key !== 'url') { // Skip the 'url' parameter if it exists
        $params[] = $value;
      }
    }

    return call_user_func_array([$controller, $action], $params);
  }

  /**
   * Apply middleware to a route
   */
  public function middleware(string $middleware)
  {
    $routes = end($this->routes);
    $uri = key($routes);
    $method = key($this->routes);

    $this->routes[$method][$uri]['middleware'] = $middleware;

    return $this;
  }


}
