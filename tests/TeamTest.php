<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Team.php";
    require_once "src/User.php";
    $server = 'mysql:host=localhost;dbname=fantasy_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TeamTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Team::deleteAll();
          User::deleteAll();
        }

        function testGetOwner()
        {
          $user = new User("Joe", "password");
          $user->addUser();
          $test_team = new Team($user->getId(), "Awesome Team");
          $test_team->save();
          $result = $test_team->getOwner();
          $this->assertEquals("Joe", $result);
        }

        function testSave()
        {
          $test_team = new Team(1, "Awesome Team");
          $test_team->save();
          $result = Team::getAll();
          $this->assertEquals([$test_team], $result);
        }

        function testGetAll()
        {
          $test_team = new Team(1, "Awesome Team");
          $test_team->save();
          $test_team2 = new Team(2, "Super Awesome Team");
          $test_team2->save();
          $result = Team::getAll();
          $this->assertEquals([($test_team), ($test_team2)], $result);
        }
    }
?>
