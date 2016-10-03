<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Player.php";
    require_once "src/functions.php";
    // $server = 'mysql:host=localhost;dbname=nfl_players_test';
    // $username = 'root';
    // $password = 'root';
    // $DB = new PDO($server, $username, $password);

    class PlayerTest extends PHPUnit_Framework_TestCase
    {
        function test_getPlayer()
        {
            // Arrange
            $testPlayer = new Player("Andrew", "Luck", "QB");

            $result = $testPlayer->getFirstName();


            // Assert
            $this->assertEquals("Andrew", $result);
        }

        function test_getFirst()
        {
            // Arrange

            $first_player = setUp();
            $testPlayer = new Player((string)$first_player['firstName'], (string)$first_player['lastName'], "QB");

            $result = $testPlayer->getFirstName();


            // Assert
            $this->assertEquals("Andrew", $result);
        }
    }



?>
