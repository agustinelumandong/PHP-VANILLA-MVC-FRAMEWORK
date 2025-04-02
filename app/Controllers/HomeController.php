<?php
// app/Controllers/HomeController.php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class HomeController extends Controller
{

  protected $userModel;

  public function __construct()
  {
    $this->userModel = new User();
  }

  /**
   * Display the home page
   */
  public function index()
  {
    return $this->view('home', [
      'title' => 'Welcome to MVC Framework',
      'message' => 'A simple MVC framework for PHP'
    ]);
  }

  /**
   * Display the about page
   */
  public function profile()
  {
    $sessionUser = $_SESSION['user'] ?? null;
    $currentUser = null; // Initialize currentUser

    if ($sessionUser) {
      $userId = null;
      // Extract user ID whether it's an array or object
      if (is_array($sessionUser) && isset($sessionUser['id'])) {
        $userId = $sessionUser['id'];
      } elseif (is_object($sessionUser) && isset($sessionUser->id)) {
        $userId = $sessionUser->id;
      }

      if ($userId !== null) {
        // Get fresh user data using the extracted ID
        $freshUser = $this->userModel->find($userId);
        if ($freshUser) {
          // Use the fresh data if found
          $currentUser = $freshUser;
        } else {
          // Fallback to session data if fresh data fetch fails,
          // but ensure it's the full data, not just ID
          $currentUser = $sessionUser;
        }
      } else {
        // If session data exists but has no ID, treat as invalid
        $currentUser = null;
      }
    }

    return $this->view('profile', [
      'title' => 'Profile',
      'content' => 'Welcome to your profile page!',
      'currentUser' => $currentUser, // Pass the determined user data (or null)
    ]);
  }

  /**
   * Display the contact page
   */
  public function contact()
  {
    return $this->view('contact', [
      'title' => 'Contact Us',
      'email' => 'info@example.com'
    ]);
  }
}