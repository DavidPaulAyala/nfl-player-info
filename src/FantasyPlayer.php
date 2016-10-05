<?php
  class FantasyPlayer
  {
    private $id;
    private $name;
    private $position;
    private $team;
    private $team_id;


    function __construct($name, $position, $team, $team_id, $id=null)
    {
      $this->id = $id;
      $this->name = $name;
      $this->position = $position;
      $this->team = $team;
      $this->team_id = $team_id;
    }

    function getId()
    {
      return $this->id;
    }

    function getName()
    {
      return $this->name;
    }

    function getPosition()
    {
      return $this->position;
    }

    function getTeam()
    {
      return $this->team;
    }

    function getTeamId()
    {
      return $this->team_id;
    }

    function setName($name)
    {
      $this->name = $name;
    }

    function setPosition($position)
    {
      $this->position = $position;
    }

    function setTeam($team)
    {
      $this->team = $team;
    }

    function setTeamId($team_id)
    {
      $this->team_id = $team_id;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO players (name, position, team, team_id) VALUES ('{$this->name}', '{$this->position}', '{$this->team}', {$this->team_id});");
      $this->id = $GLOBALS['DB']->lastInsertID();
    }

    function updateTeamId($id)
    {
      $GLOBALS['DB']->exec("UPDATE players SET team_id = $id WHERE id = {$this->id};");
      $this->team_id = $id;
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM players;");
    }

    static function getAll()
    {
      $players = $GLOBALS['DB']->query("SELECT * FROM players;");
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

}
?>
