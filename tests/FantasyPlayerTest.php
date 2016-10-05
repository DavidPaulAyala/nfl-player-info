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

        function testGetAll()
        {
          $test_player = new FantasyPlayer("Tom Brady", "QB", "NE", 1);
          $test_player->save();
          $test_player2 = new FantasyPlayer("Victor Cruz", "WR", "NYG", 2);
          $test_player2->save();
          $result = FantasyPlayer::getAll();
          $this->assertEquals([($test_player), ($test_player2)], $result);
        }
    }

?>
