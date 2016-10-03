<?php
    class Player
    {
      private $id;
      private $first_name;
      private $last_name;
      private $team;
      private $td;
      private $position;


      function __construct($first_name, $last_name, $position, $team, $td, $id = null)
      {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->team = $team;
        $this->position = $position;
        $this->td = $td;
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

      function getTd()
      {
        return $this->td;
      }

      function setTd($td)
      {
        $this->last_td = $td;
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
          $total_td = (int) $quarterback->stats['PassTDs'] + $quarterback->stats['RushTDs'] + $quarterback->stats['RecTDs'];
          $new_qb = new Player($first_name, $last_name, $position, $team, $total_td);
          array_push($quarterback_array, $new_qb);
        }
        return $quarterback_array;
      }

      function save()
      {
        $GLOBALS['DB']->exec("INSERT INTO players (first_name, last_name, position, team, td) VALUES ('{$this->first_name}', '{$this->last_name}','{$this->position}', '{$this->team}', {$this->td});");
        $this->id = $GLOBALS['DB']->lastInsertID();
      }

      static function getAll()
      {
        $quarterbacks = $GLOBALS['DB']->query('SELECT * FROM players;');
        $player_array = array();
        foreach ($quarterbacks as $quarterback) {
          $id = $quarterback['id'];
          $first_name = $quarterback['first_name'];
          $last_name = $quarterback['last_name'];
          $position = $quarterback['position'];
          $team = $quarterback['team'];
          $td = $quarterback['td'];
          $new_player = new Player($first_name, $last_name, $position, $team, $td, $id);
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
