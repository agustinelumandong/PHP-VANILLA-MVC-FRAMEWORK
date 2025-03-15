<?php
// app/Controllers/HomeController.php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
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
  public function about()
  {
    return $this->view('about', [
      'title' => 'About Us',
      'content' => 'This is the about page content.'
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