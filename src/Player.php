<?php
    class Player
    {

      private $first_name;
      private $last_name;
      private $position;
      private $team;
      private $ff_points;
      private $pass_yds;
      private $pass_tds;
      private $rush_yds;
      private $rush_tds;
      private $rec_tds;
      private $intercepts;
      private $fum;
      private $id;


      function __construct($first_name, $last_name, $position, $team, $ff_points, $pass_yds, $pass_tds, $rush_yds, $rush_tds, $rec_tds, $intercepts, $fum, $id = null)
      {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->position = $position;
        $this->team = $team;
        $this->ff_points = $ff_points;
        $this->pass_yds = $pass_yds;
        $this->pass_tds = $pass_tds;
        $this->rush_yds = $rush_yds;
        $this->rush_tds = $rush_tds;
        $this->rec_tds = $rec_tds;
        $this->intercepts = $intercepts;
        $this->fum = $fum;
      }

      function getId()
      {
        return $this->id;
      }

      function getFirstName()
      {
        return $this->first_name;
      }

      function setFirstName($name)
      {
        $this->first_name = $name;
      }

      function getLastName()
      {
        return $this->last_name;
      }

      function setLastName($name)
      {
        $this->last_name = $name;
      }

      function getTeam()
      {
        return $this->team;
      }

      function setTeam($team)
      {
        $this->team = $team;
      }

      function getPosition()
      {
        return $this->position;
      }

      function setPosition($position)
      {
        $this->position = $position;
      }

      function getFfPoints()
      {
        return $this->ff_points;
      }

      function getPassYds()
      {
        return $this->pass_yds;
      }

      function getPassTds()
      {
        return $this->pass_tds;
      }

      function getRushYds()
      {
        return $this->rush_yds;
      }

      function getRushTds()
      {
        return $this->rush_tds;
      }

      function getRecTds()
      {
        return $this->rec_tds;
      }

      function getIntercepts()
      {
        return $this->intercepts;
      }

      function getFum()
      {
        return $this->fum;
      }



      static function getPlayers($offset)
      {
        $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders?season=2016&week=1";
        $all_info = simplexml_load_file($url);
        $quarterbacks = $all_info->scoringLeader[$offset]->players;
        $quarterback_array = array();

        foreach($quarterbacks->player as $quarterback){
          $first_name = (string) $quarterback['firstName'];
          $last_name = (string) $quarterback['lastName'];
          $position = (string) $quarterback['position'];
          $team = (string) $quarterback['teamAbbr'];
          $ff_points = (float) $quarterback['pts'];
          $pass_yds = (int) $quarterback->stats['PassYds'];
          $pass_tds = (int) $quarterback->stats['PassTDs'];
          $rush_yds = (int) $quarterback->stats['RushYds'];
          $rush_tds = (int) $quarterback->stats['RushTDs'];
          $rec_tds = (int) $quarterback->stats['RecTDs'];
          $intercepts = (int) $quarterback->stats['Int'];
          $fum = (int) $quarterback->stats['FumLost'];

          $new_qb = new Player($first_name, $last_name, $position, $team, $ff_points, $pass_yds, $pass_tds, $rush_yds, $rush_tds, $rec_tds, $intercepts, $fum);

          array_push($quarterback_array, $new_qb);
        }
        var_dump($quarterback_array);
        return $quarterback_array;
      }

      function save()
      {
        $GLOBALS['DB']->exec("INSERT INTO players (first_name, last_name, position, team, ff_points, pass_yds, pass_tds, rush_yds, rush_tds, rec_tds, intercepts, fum) VALUES ('{$this->first_name}', '{$this->last_name}','{$this->position}', '{$this->team}', {$this->ff_points}, {$this->pass_yds}, {$this->pass_tds}, {$this->rush_yds}, {$this->rush_tds}, {$this->rec_tds},
           {$this->intercepts}, {$this->fum});");
        $this->id = $GLOBALS['DB']->lastInsertID();
      }

      static function getPos($position)
      {
        $quarterbacks = $GLOBALS['DB']->query("SELECT * FROM players WHERE position = '{$position}';");
        $player_array = array();
        foreach ($quarterbacks as $quarterback) {
          $first_name = $quarterback['first_name'];
          $last_name = $quarterback['last_name'];
          $position = $quarterback['position'];
          $team = $quarterback['team'];
          $ff_points = $quarterback['ff_points'];
          $pass_yds = $quarterback['pass_yds'];
          $pass_tds = $quarterback['pass_tds'];
          $rush_yds = $quarterback['rush_yds'];
          $rush_tds = $quarterback['rush_tds'];
          $rec_tds = $quarterback['rec_tds'];
          $intercepts = $quarterback['intercepts'];
          $fum = $quarterback['fum'];
          $id = $quarterback['id'];
          $new_player = new Player($first_name, $last_name, $position, $team, $ff_points, $pass_yds, $pass_tds, $rush_yds, $rush_tds, $rec_tds, $intercepts, $id);
          array_push($player_array, $new_player);
        }
        return $player_array;
      }

      static function deleteAll()
      {
        $GLOBALS['DB']->exec("DELETE FROM players;");
      }
    }
?>
