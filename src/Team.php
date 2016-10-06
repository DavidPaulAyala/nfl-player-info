<?php
  class Team
  {
    private $id;
    private $user_id;
    private $team;

    function __construct($user_id, $team, $id=null)
    {
      $this->id = $id;
      $this->user_id = $user_id;
      $this->team = $team;
    }

    function getId()
    {
      return $this->id;
    }

    function getUserId()
    {
      return $this->user_id;
    }

    function getTeam()
    {
      return $this->team;
    }

    function setUserId($user_id)
    {
      $this->user_id = $user_id;
    }

    function setTeam($team)
    {
      $this->team = $team;
    }

    function getOwner()
    {
      $owner_obj = $GLOBALS['DB']->query("SELECT * FROM users WHERE id = {$this->user_id};");
      $owner_arr = $owner_obj->fetch(PDO::FETCH_ASSOC);
      return $owner_arr['name'];
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO teams (user_id, team) VALUES ('{$this->user_id}', '{$this->team}');");
      $this->id = $GLOBALS['DB']->lastInsertID();
    }

    function addPlayer($id){
      $GLOBALS['DB']->exec("UPDATE players SET team_id = {$this->id} WHERE id = {$id};");
    }

    function getPlayers(){
      $players = $GLOBALS['DB']->query("SELECT * FROM players WHERE team_id = {$this->id};");
      $player_array = array();
      foreach ($players as $player) {
        $name = $player['name'];
        $position = $player['position'];
        $team = $player['team'];
        $team_id = $player['team_id'];
        $id = $player['id'];
        $new_player = new FantasyPlayer($name, $position, $team, $team_id, $id);
        array_push($player_array, $new_player);
      }
      return $player_array;
    }

    static function find($id)
    {
      $teams = Team::getAll();
      $matched_team = null;
      foreach($teams as $team){
        if ($team->getId() == $id){
          $matched_team = $team;
        }
      }
      return $matched_team;
    }

    static function getAll()
    {
      $teams = $GLOBALS['DB']->query("SELECT * FROM teams;");
      $team_array = array();
      foreach ($teams as $team) {
        $user_id = $team['user_id'];
        $team_name = $team['team'];
        $id = $team['id'];
        $new_team = new Team($user_id, $team_name, $id);
        array_push($team_array, $new_team);
      }
      return $team_array;
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM teams;");
    }
  }
?>
