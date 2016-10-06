<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/User.php";
    $server = 'mysql:host=localhost;dbname=fantasy_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          User::deleteAll();
        }

        function testCheckUserNameAvailable()
        {
          $user = new User("Joe", "password");
          $result = $user->checkUserNameAvailable();

          $this->assertTrue($result);
        }

        function testAddUser()
        {
          $user = new User("Joe", "password");
          $id = $user->addUser();

          $this->assertTrue(is_numeric($id));
        }

        function testCheckUserNameAvailableFalse()
        {
          $user = new User("Joe", "password");
          $user->addUser();
          $user2 = new User("Joe", "password");
          $result = $user2->checkUserNameAvailable();

          $this->assertFalse($result);
        }

        function testLogin()
        {
          $user = new User("Joe", "password");
          $id = $user->addUser();
          $result = $user->login();

          $this->assertTrue(is_numeric($id));
        }

    }
?>
