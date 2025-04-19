# PHP-VANILLA-MVC-FRAMEWORK

## Overview

A lightweight, flexible MVC (Model-View-Controller) framework built with vanilla PHP. This framework provides a structured architecture for building web applications without the overhead of larger frameworks, allowing developers to understand exactly what's happening under the hood.

## Key Features

- **Pure PHP** implementation without dependencies on other frameworks
- **MVC Architecture** for clean separation of concerns
- **Routing System** with support for dynamic parameters and method spoofing
- **Template Engine** for rendering views with layouts
- **Database Abstraction Layer** with query building and ORM-like features
- **Middleware Support** for request/response manipulation
- **Auth System** with login, registration, and role-based access control
- **Session Management** and flash messages
- **Input Handling** with validation and sanitization
- **Environment Configuration** via .env files
- **Helper Functions** for common tasks

## Installation

### Prerequisites
- PHP 7.4 or higher
- Composer
- MySQL/MariaDB (or your preferred database)

### Step 1: Clone the Repository
```bash
composer create-project agust/mvc-structure my-project

cd my-project
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Configure Environment
Copy the example environment file and adjust settings for your environment:
```bash
cp .env.example .env
```

Edit the `.env` file with your database credentials and application settings:

```env
APP_NAME=PHP MVC Framework
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=UTC

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
DB_CHARSET=utf8mb4
```

### Step 4: Set Permissions (OPTIONAL)
Ensure storage directories are writable:
```bash
chmod -R 775 storage/
```

### Step 5: Create Database
Create your database and import schema:
```bash
mysql -u username -p database_name < database/schema.sql
```

### Step 6: Run Development Server
```bash
php -S localhost:8000 -t public/
```

Visit `http://localhost:8000` in your browser to see the application running.

## Project Structure

```
project/
├── app/                  # Application core files
│   ├── Controllers/      # Controller classes
│   ├── Core/             # Framework core classes and functionality
│   │   ├── Auth.php      # Authentication manager
│   │   ├── Controller.php# Base controller class
│   │   ├── Database.php  # Database connection and queries
│   │   ├── Helpers.php   # Helper functions
│   │   ├── Input.php     # Input handling and validation
│   │   ├── Middleware.php# Middleware base class
│   │   ├── Model.php     # Base model class
│   │   └── Router.php    # URL routing system
│   ├── Models/           # Model classes
│   ├── Views/            # View templates
│   │   ├── layouts/      # Layout templates
│   │   └── errors/       # Error pages
│   └── Middleware/       # Request/response middleware
├── config/               # Configuration files
│   ├── config.php        # Main configuration
│   └── database.php      # Database configuration
├── public/               # Publicly accessible files
│   ├── index.php         # Application entry point
│   └── assets/           # Assets (CSS, JS, images)
├── tests/                # Test files
├── vendor/               # Composer dependencies
├── web/                  # Web bootstrapping
│   ├── bootstrap.php     # Application bootstrapping
│   └── routes.php        # Route definitions
└── .env                  # Environment variables
```

## Core Components

### Routing System

Routes are defined in the `web/routes.php` file:

```php
// Basic routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);

// Routes with parameters
$router->get('/users/{id}', [UserController::class, 'show'], [AuthMiddleware::class]);

// HTTP methods
$router->post('/users', [UserController::class, 'store']);
$router->put('/users/{id}', [UserController::class, 'update']);
$router->delete('/users/{id}', [UserController::class, 'destroy']);

// Routes with middleware
$router->get('/users', [UserController::class, 'index'], [AuthMiddleware::class]);
```

### Controllers

Controllers extend the base `Controller` class and handle request logic:

```php
// app/Controllers/UserController.php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Input;
use App\Models\User;

class UserController extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $users = $this->userModel->all();
        return $this->view('users/index', [
            'title' => 'Users',
            'users' => $users
        ]);
    }

    public function store()
    {
        $data = Input::sanitize([
            'name' => Input::post('name'),
            'email' => Input::post('email'),
            'password' => password_hash(Input::post('password'), PASSWORD_DEFAULT)
        ]);

        $userId = $this->userModel->create($data);

        if ($userId) {
            $_SESSION['success'] = 'User created successfully!';
            $this->redirect('/users');
        }
    }
}
```

### Models

Models extend the base `Model` class and interact with the database:

```php
// app/Models/User.php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected static $table = 'users';
    
    public static function findByEmail(string $email)
    {
        return self::$db->query("SELECT * FROM " . static::$table . " WHERE email = ?")
            ->bind([1 => $email])
            ->execute()
            ->fetch();
    }
    
    public static function authenticate(string $email, string $password)
    {
        $user = self::findByEmail($email);
        if (!$user) {
            return false;
        }
        return password_verify($password, $user['password']) ? $user : false;
    }
}
```

### Views

Views are PHP files that render HTML with data passed from controllers:

```php
<!-- app/Views/users/index.php -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h1><?= $title ?></h1>
  <a href="/users/create" class="btn btn-primary">Create New User</a>
</div>

<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= $user['id'] ?></td>
          <td><?= $user['name'] ?></td>
          <td><?= $user['email'] ?></td>
          <td>
            <a href="/users/<?= $user['id'] ?>" class="btn btn-sm btn-info">View</a>
            <a href="/users/<?= $user['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
            <!-- Delete form -->
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
```

### Middleware

Middleware classes are used to filter HTTP requests:

```php
// app/Middleware/AuthMiddleware.php
namespace App\Middleware;

use App\Core\Middleware;
use Closure;

class AuthMiddleware extends Middleware
{
    public function handle($request, Closure $next)
    {
        if (!isset($_SESSION['users'])) {
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            header('Location: /login');
            exit;
        }
        return $next($request);
    }
}
```

## Configuration

### Main Configuration File

```php
// config/config.php
return [
    'debug' => Helpers::env('APP_DEBUG', false),
    'app_name' => Helpers::env('APP_NAME', 'MVC Framework'),
    'app_url' => Helpers::env('APP_URL', 'http://localhost'),
    'timezone' => Helpers::env('APP_TIMEZONE', 'UTC'),
];
```

### Database Configuration

```php
// config/database.php
return [
    'driver' => Helpers::env('DB_CONNECTION', 'mysql'),
    'host' => Helpers::env('DB_HOST', 'localhost'),
    'database' => Helpers::env('DB_DATABASE', 'mvc'),
    'username' => Helpers::env('DB_USERNAME', 'root'),
    'password' => Helpers::env('DB_PASSWORD', ''),
    'charset' => Helpers::env('DB_CHARSET', 'utf8mb4'),
];
```

## Helper Functions

The framework provides helper functions through the `Helpers` class:

```php
// Environment variables
$debug = \App\Core\Helpers::env('APP_DEBUG', false);

// Asset URLs
<link rel="stylesheet" href="<?= \App\Core\Helpers::asset('css/style.css') ?>">

// Formatting dates
<?= \App\Core\Helpers::formatDate($timestamp) ?>
```

## Authentication

```php
// Check if a user is logged in
if (App\Core\Auth::check()) {
    // User is logged in
}

// Get the current user
$user = App\Core\Auth::user();

// Check if user is admin
if (App\Core\Auth::isAdmin()) {
    // User is admin
}

// Login a user
App\Core\Auth::login($user);

// Logout
App\Core\Auth::logout();
```

## Database Queries

```php
// Direct query
$users = $db->query("SELECT * FROM users WHERE active = ?")
    ->bind([1 => true])
    ->execute()
    ->fetchAll();

// Using the Model
$users = User::all();
$user = User::find(1);
$userId = $userModel->create([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);
$updated = $userModel->update(1, ['name' => 'Jane Doe']);
$deleted = $userModel->delete(1);
```

## Input Handling

```php
// Get from $_POST
$name = Input::post('name');

// Get from $_GET
$id = Input::get('id');

// Get from either $_GET or $_POST
$search = Input::any('search');

// Sanitize input
$data = Input::sanitize([
    'name' => Input::post('name'),
    'email' => Input::post('email')
]);
```

## Testing

The framework includes PHPUnit for testing. Run tests with:

```bash
./vendor/bin/phpunit
```

Example test:

```php
// tests/Controllers/UserControllerTest.php
namespace Tests\Controllers;

use App\Controllers\UserController;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    private $userController;
    private $userModelMock;

    protected function setUp(): void
    {
        // Create a mock for the User model
        $this->userModelMock = $this->createMock(User::class);

        // Create a UserController instance
        $this->userController = new UserController();
        
        // Use reflection to inject our mock
        $reflection = new \ReflectionClass(UserController::class);
        $property = $reflection->getProperty('userModel');
        $property->setAccessible(true);
        $property->setValue($this->userController, $this->userModelMock);
    }

    public function testControllerInstanceCreation()
    {
        $this->assertInstanceOf(UserController::class, $this->userController);
    }

    // More tests...
}
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This framework is open-sourced software licensed under the MIT license.

## Author

Sean Agustine L. Esparagoza  
Github: [agustinelumandong](https://github.com/agustinelumandong)
