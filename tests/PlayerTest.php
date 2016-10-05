<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Player.php";
    $server = 'mysql:host=localhost;dbname=nfl_players_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class PlayerTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Player::deleteAll();
        }

        function testGetPlayer()
        {
            // Arrange
            $testPlayer = new Player("Andrew", "Luck", "QB", "IND", 4.1,1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

            $result = $testPlayer->getFirstName();


            // Assert
            $this->assertEquals("Andrew", $result);
        }

        function testGetPlayers()
        {
          $quarterbacks = Player::getPlayers(0);
          $first_player = $quarterbacks[0];
          $result = $first_player->getFirstName();
          $this->assertTrue(is_string($result));
        }

        function testGetTouchdowns()
        {
          $quarterbacks = Player::getPlayers(0);
          $first_player = $quarterbacks[0];
          $result = $first_player->getTd();
          $this->assertTrue(is_int($result));
        }

        function testSave()
        {
          $test_quaterback = new Player("Joe", "Montana", "QB", "SF", 4.1,1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
          $test_quaterback->save();

          $output = Player::getAll();

          $this->assertEquals($test_quaterback, $output[0]);
        }

    }

?>
