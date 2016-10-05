<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Team.php";
    $server = 'mysql:host=localhost;dbname=fantasy_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TeamTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Team::deleteAll();
        }

        function testGetOwner()
        {
          $test_team = new Team("Phil Smith", "Awesome Team", 1);
          $result = $test_team->getOwner();
          $this->assertEquals("Phil Smith", $result);
        }

        function testSave()
        {
          $test_team = new Team("Phil Smith", "Awesome Team", 1);
          $test_team->save();
          $result = Team::getAll();
          $this->assertEquals([$test_team], $result);
        }

        function testGetAll()
        {
          $test_team = new Team("Phil Smith", "Awesome Team", 1);
          $test_team->save();
          $test_team2 = new Team("Jane Doe", "Super Awesome Team", 2);
          $test_team2->save();
          $result = Team::getAll();
          $this->assertEquals([($test_team), ($test_team2)], $result);
        }
    }
?>
