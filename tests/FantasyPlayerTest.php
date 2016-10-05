<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/FantasyPlayer.php";
    $server = 'mysql:host=localhost;dbname=fantasy_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class FantasyPlayerTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          FantasyPlayer::deleteAll();
        }

        function testGetPlayer()
        {
            $testPlayer = new FantasyPlayer("Tom Brady", "QB", "NE", 1);
            $result = $testPlayer->getName();
            $this->assertEquals("Tom Brady", $result);
        }

        function testSave()
        {
          $testPlayer = new FantasyPlayer("Tom Brady", "QB", "NE", 1);
          $testPlayer->save();
          $result = FantasyPlayer::getAll();
          $this->assertEquals($testPlayer, $result[0]);
        }

        function testUpdateTeamId()
        {
          $testPlayer = new FantasyPlayer("Tom Brady", "QB", "NE", 1);
          $testPlayer->save();
          $testPlayer->updateTeamId(2);
          $result = FantasyPlayer::getAll()[0];
          $this->assertEquals($result->getTeamId(), 2);
        }

        // function testGetPlayers()
        // {
        //   $players = FantasyPlayer::getPlayers(0);
        //   $first_player = $players[0];
        //   $result = $first_player->getName();
        //   $this->assertTrue(is_string($result));
        // }
    }

?>
