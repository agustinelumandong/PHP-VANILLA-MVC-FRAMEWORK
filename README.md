# PHP-VANILLA-MVC-FRAMEWORK

## Overview

A lightweight, flexible MVC (Model-View-Controller) framework built with vanilla PHP. This framework provides a structured architecture for building web applications without the overhead of larger frameworks, allowing developers to understand exactly what's happening under the hood.

Key features:
- **Pure PHP** implementation without dependencies on other frameworks
- **MVC Architecture** for clean separation of concerns
- **Routing System** for handling URL requests
- **Template Engine** for rendering views
- **Database Abstraction** for simplified data access
- **Middleware Support** for request/response manipulation
- **Session Management** and authentication helpers
- **RESTful API** support out of the box

## Installation

### Prerequisites
- PHP 7.4 or higher
- Composer
- MySQL/MariaDB (or your preferred database)

### Step 1: Clone the Repository
```bash
composer create-project agust/mvc-structure NameOfProject

cd PHP-VANILLA-MVC-FRAMEWORK
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

Edit the `.env` file with your database credentials and application settings.

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
│   ├── Models/           # Model classes
│   ├── Views/            # View templates
│   ├── Middleware/       # Request/response middleware
│   └── Helpers/          # Helper functions and utilities
├── config/               # Configuration files
├── database/             # Database migrations and seeds
├── public/               # Publicly accessible files
│   ├── index.php         # Application entry point
│   ├── css/              # CSS files
│   ├── js/               # JavaScript files
│   └── images/           # Image files
├── routes/               # Route definitions
│   └── web.php           # Web routes
├── storage/              # Storage for logs, cache, etc.
│   ├── logs/             # Application logs
│   └── cache/            # Cached files
├── tests/                # Test files
├── vendor/               # Composer dependencies
├── .env                  # Environment variables
└── composer.json         # Composer configuration
```

## Basic Usage
## Defining Routes
Routes are defined in routes/web.php:
```php
// Define a simple GET route
$router->get('/hello', 'HomeController@hello');

// Define a POST route
$router->post('/users', 'UserController@store');

// Define a route with parameters
$router->get('/users/{id}', 'UserController@show');

// Route groups for organization
$router->group('/admin', function($router) {
    $router->get('/dashboard', 'AdminController@dashboard');
    $router->get('/users', 'AdminController@users');
});
```
## Creating a Controller
Controllers go in the app/Controllers directory:
```php
// app/Controllers/UserController.php

namespace App\Controllers;

use App\Models\User;

class UserController
{
    public function index()
    {
        $users = User::all();
        return view('users/index', ['users' => $users]);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        return view('users/show', ['user' => $user]);
    }
    
    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        
        User::create($data);
        
        return redirect('/users');
    }
}
```

## Creating a Model
Models go in the app/Models directory:

```php
// app/Models/User.php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_BCRYPT);
    }
}

```

## Creating a View
Views go in the app/Views directory:

```html
<!-- app/Views/users/index.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div class="container">
        <h1>Users</h1>
        
        <ul>
            <?php foreach($users as $user): ?>
                <li>
                    <a href="/users/<?= $user->id ?>">
                        <?= $user->name ?> (<?= $user->email ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <script src="/js/app.js"></script>
</body>
</html>

```

## Configuration
Configuration files are stored in the config/ directory, with different files for different aspects of the application.

## Application Configuration

```php
// config/app.php

return [
    'name' => env('APP_NAME', 'PHP MVC Framework'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => env('APP_TIMEZONE', 'UTC'),
    'locale' => env('APP_LOCALE', 'en'),
];
```

## Database Configuration

```php

// config/database.php

return [
    'default' => env('DB_CONNECTION', 'mysql'),
    
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
        
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', 'database/database.sqlite'),
        ],
    ],
];

```
## Environment Variables
Environment variables are defined in the .env file in the root directory:

```env

APP_NAME=PHP MVC Framework
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myapp
DB_USERNAME=root
DB_PASSWORD=secret

```

Access environment variables in your application with the env() helper:

```php
$debug = env('APP_DEBUG', false);
```
## Contributing
Contributions are welcome! Please feel free to submit a Pull Request.

## License
This framework is open-sourced software licensed under the MIT license.

## Author
Sean Agustine L. Esparagoza  
Github: agustinelumandong
