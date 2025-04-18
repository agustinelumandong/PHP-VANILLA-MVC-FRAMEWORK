<?php

namespace Tests\Models;

use App\Core\Database;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class UserModelAdvancedTest extends TestCase
{
  private $user;
  private $dbMock;
  private $queryMock;

  protected function setUp(): void
  {
    // Create mock objects
    $this->dbMock = $this->createMock(Database::class);
    $this->queryMock = $this->getMockBuilder(\stdClass::class)
      ->addMethods(['bind', 'execute', 'fetch', 'fetchAll'])
      ->getMock();

    // Configure query mock for chaining
    $this->queryMock->method('bind')->willReturn($this->queryMock);
    $this->queryMock->method('execute')->willReturn($this->queryMock);

    // Configure db mock to return query mock
    $this->dbMock->method('query')->willReturn($this->queryMock);

    // Create User instance
    $this->user = new User();

    // Set the mock db into User class
    $reflectionClass = new ReflectionClass(User::class);
    $dbProperty = $reflectionClass->getProperty('db');
    $dbProperty->setAccessible(true);
    $dbProperty->setValue(null, $this->dbMock); // static property
  }

  public function testFindByEmailReturnsUserWhenFound()
  {
    // Setup expected data
    $testEmail = 'test@example.com';
    $mockUserData = [
      'id' => 1,
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => 'hashed_password'
    ];

    // Set expectations
    $this->dbMock->expects($this->once())
      ->method('query')
      ->with($this->stringContains('SELECT * FROM users WHERE email = ?'))
      ->willReturn($this->queryMock);

    $this->queryMock->expects($this->once())
      ->method('bind')
      ->with($this->equalTo([1 => $testEmail]))
      ->willReturn($this->queryMock);

    $this->queryMock->expects($this->once())
      ->method('fetch')
      ->willReturn($mockUserData);

    // Execute test
    $result = User::findByEmail($testEmail);

    // Assertions
    $this->assertEquals($mockUserData, $result);
  }

  public function testAuthenticateReturnsUserDataWhenCredentialsAreValid()
  {
    // Setup test data
    $testEmail = 'test@example.com';
    $testPassword = 'password123';
    $hashedPassword = password_hash($testPassword, PASSWORD_DEFAULT);

    $mockUserData = [
      'id' => 1,
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => $hashedPassword
    ];

    // Configure mocks
    $this->queryMock->method('fetch')->willReturn($mockUserData);

    // Execute test
    $result = User::authenticate($testEmail, $testPassword);

    // Assertions
    $this->assertEquals($mockUserData, $result);
  }

  public function testAuthenticateReturnsFalseWhenCredentialsAreInvalid()
  {
    // Setup test data
    $testEmail = 'test@example.com';
    $testPassword = 'password123';
    $hashedPassword = password_hash('different_password', PASSWORD_DEFAULT);

    $mockUserData = [
      'id' => 1,
      'name' => 'Test User',
      'email' => 'test@example.com',
      'password' => $hashedPassword
    ];

    // Configure mocks
    $this->queryMock->method('fetch')->willReturn($mockUserData);

    // Execute test
    $result = User::authenticate($testEmail, $testPassword);

    // Assertions
    $this->assertFalse($result);
  }

  public function testGetAllUserIdsReturnsArrayOfIds()
  {
    // Setup mock data
    $mockIds = [
      ['id' => 1],
      ['id' => 2],
      ['id' => 3]
    ];

    // Configure mocks
    $this->queryMock->expects($this->once())
      ->method('fetchAll')
      ->willReturn($mockIds);

    // Execute test
    $result = $this->user->getAllUserIds();

    // Assertions
    $this->assertEquals($mockIds, $result);
  }

  public function testGetAllUserIdsReturnsEmptyArrayWhenNoUsers()
  {
    // Configure mocks
    $this->queryMock->method('fetchAll')->willReturn(false);

    // Execute test
    $result = $this->user->getAllUserIds();

    // Assertions
    $this->assertEquals([], $result);
  }
}