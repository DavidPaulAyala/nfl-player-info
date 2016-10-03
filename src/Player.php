<?php
    class Player
    {
      private $id;
      private $first_name;
      private $last_name;
      private $team;
      private $td;


      function __construct($first_name, $last_name, $team, $td, $id = null)
      {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->team = $team;
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

      function getTd()
      {
        return $this->td;
      }

      function setTd($td)
      {
        $this->last_td = $td;
      }

      static function getPlayers()
      {
        $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders?season=2016&week=1";
        $all_info = simplexml_load_file($url);
        $quarterbacks = $all_info->scoringLeader->players;
        $quarterback_array = array();

        foreach($quarterbacks->player as $quarterback){
          $first_name = (string) $quarterback['firstName'];
          $last_name = (string) $quarterback['lastName'];
          $team = (string) $quarterback['teamAbbr'];
          $total_td = (int) $quarterback->stats['PassTDs'] + $quarterback->stats['RushTDs'] + $quarterback->stats['RecTDs'];
          $new_qb = new Player($first_name, $last_name, $team, $total_td);
          array_push($quarterback_array, $new_qb);
        }
        return $quarterback_array;
      }
    }
?>