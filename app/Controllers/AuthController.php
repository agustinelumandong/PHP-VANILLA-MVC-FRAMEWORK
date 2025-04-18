<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Input;
use App\Models\User;
// use App\Models\Profile;
use Exception;

class AuthController extends Controller
{

  protected $userModel;

  public function __construct()
  {
    $this->userModel = new User();
  }

  /**
   * Display the login page
   */
  public function index()
  {
    if (Auth::check()) {
      $this->redirect('/');
    }

    return $this->view('auth/login', [
      'title' => 'Login'
    ]);
  }

  /**
   * Authenticate the user
   */
  public function login()
  {
    // Validate the form
    $data = Input::sanitize([
      'email' => Input::post('email'),
      'password' => Input::post('password')
    ]);

    // Check if the user exists
    $user = User::authenticate($data['email'], $data['password']);

    if (!$user) {
      $_SESSION['error'] = 'Invalid email or password!';
      $this->redirect('/login');
    }

    if ($user && isset($user['password']) && password_verify($data['password'], $user['password'])) {
      // Create session
      Auth::login($user);
      $_SESSION['success'] = 'Welcome back, ' . $user['name'] . '!';
      $this->redirect('/');
    } else {
      $_SESSION['error'] = 'Invalid email or password!';
      $this->redirect('/login');
    }
  }

  /**
   * Display the registration page
   */
  public function register()
  {
    return $this->view('auth/register', [
      'title' => 'Register'
    ]);
  }

  /**
   * Store the new user
   */
  public function store()
  {
    // Validate the form
    if (!Input::post('name') || !Input::post('email') || !Input::post('password') || !Input::post('password_confirmation')) {
      $_SESSION['error'] = 'All fields are required!';
      $this->redirect('/register');
    }
    // Check if the email already exists
    if (Input::post('email') && $this->userModel->findByEmail(Input::post('email'))) {
      $_SESSION['error'] = 'Email already exists!';
      $this->redirect('/register');
    }
    // Check if the password and confirmation match
    if (Input::post('password') !== Input::post('password_confirmation')) {
      $_SESSION['error'] = 'Passwords do not match!';
      $this->redirect('/register');
    }
    // Create the user
    $user = Input::sanitize([
      'name' => Input::post('name'),
      'email' => Input::post('email'),
      'password' => password_hash(Input::post('password'), PASSWORD_DEFAULT),
    ]);

    $userId = $this->userModel->create($user);

    if ($userId) {
      $_SESSION['success'] = 'User created successfully!';
      $this->redirect('/login');
    } else {
      $_SESSION['error'] = 'Failed to create user!';
      $this->redirect('/register');
    }
  }

  /**
   * Display the registration page
   */
  public function logout()
  {
    Auth::logout();
    header('Location: /login');
    exit;
  }

}
