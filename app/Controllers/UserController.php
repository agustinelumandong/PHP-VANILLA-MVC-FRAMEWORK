<?php

// app/Controllers/UserController.php
// main php file

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Input;
use App\Models\User;
use Exception;

class UserController extends Controller
{
  protected $userModel;

  public function __construct()
  {
    $this->userModel = new User();
  }

  /**
   * Display a listing of users
   */
  public function index()
  {
    $users = $this->userModel->all();
    $email = $this->userModel->find($users[0]['id'])['email'] ?? null;

    return $this->view('users/index', [
      'title' => 'Users',
      'users' => $users,
      'email' => $email
    ]);
  }

  /**
   * Show the form for creating a new user
   */
  public function create()
  {
    return $this->view('users/create', [
      'title' => 'Create User'
    ]);
  }

  /**
   * Store a newly created user
   */
  public function store()
  {
    $data = Input::sanitize([
      'name' => Input::post('name'),
      'email' => Input::post('email'),
      'password' => password_hash(Input::post('password'), PASSWORD_DEFAULT)
    ]);

    $userId = $this->userModel->create($data);

    if ($userId) {
      // Flash message in session
      $_SESSION['success'] = 'User created successfully!';
      $this->redirect('/users');
    } else {
      $_SESSION['error'] = 'Failed to create user.';
      $this->redirect('/users/create');
    }
  }

  /**
   * Display the specified user
   */
  public function show($id)
  {
    $user = $this->userModel->find($id);

    if (!$user) {
      $_SESSION['error'] = 'User not found.';
      $this->redirect('/users');
    }

    return $this->view('users/show', [
      'title' => 'User Details',
      'user' => $user
    ]);
  }

  /**
   * Show the form for editing the specified user
   */
  public function edit($id)
  {
    $user = $this->userModel->find($id);

    if (!$user) {
      $_SESSION['error'] = 'User not found.';
      $this->redirect('/users');
    }

    return $this->view('users/edit', [
      'title' => 'Edit User',
      'user' => $user
    ]);
  }

  /**
   * Update the specified user
   */
  public function update($id)
  {
    $data = Input::sanitize([
      'name' => Input::post('name'),
      'email' => Input::post('email')
    ]);

    // Only update password if provided
    if (Input::post('password')) {
      $data['password'] = password_hash(Input::post('password'), PASSWORD_DEFAULT);
    }

    try {

      $updated = $this->userModel->update($id, $data);

      if ($updated) {
        $_SESSION['success'] = 'User updated successfully!';
        $this->redirect('/users');
      } else {
        $_SESSION['error'] = 'Failed to update user.';
        $this->redirect("/users/{$id}/edit");
      }

    } catch (Exception $e) {
      $_SESSION['error'] = 'Failed to update user: ' . $e->getMessage();
      $this->redirect("/users/{$id}/edit");
    }

  }

  /**
   * Delete the specified user
   */
  public function destroy($id): void
  {
    $deleted = $this->userModel->delete($id);

    if ($deleted) {
      $_SESSION['success'] = 'User deleted successfully!';
    } else {
      $_SESSION['error'] = 'Failed to delete user.';
    }

    $this->redirect('/users');
  }

}
