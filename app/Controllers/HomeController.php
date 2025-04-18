<?php
// app/Controllers/HomeController.php

namespace App\Controllers;

use App\Core\Auth;
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
    $currentUser = Auth::user();
    $userId = Auth::getByUserId();


    // Get user stats
    $userStats = $this->userModel->getUserStats($userId);

    return $this->view('profile', [
      'title' => 'Profile',
      'content' => 'Welcome to your profile page!',
      'currentUser' => $currentUser,
      'userStats' => $userStats,
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