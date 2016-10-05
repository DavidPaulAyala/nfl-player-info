<?php
  class Team
  {
    private $id;
    private $owner;
    private $team;

    function __construct($owner, $team, $id=null)
    {
      $this->id = $id;
      $this->owner = $owner;
      $this->team = $team;
    }

    function getId()
    {
      return $this->id;
    }

    function getOwner()
    {
      return $this->owner;
    }

    function getTeam()
    {
      return $this->team;
    }

    function setOwner($owner)
    {
      $this->owner = $owner;
    }

    function setTeam($team)
    {
      $this->team = $team;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO teams (owner, team) VALUES ('{$this->owner}', '{$this->team}');");
      $this->id = $GLOBALS['DB']->lastInsertID();
    }

    static function getAll()
    {
      $teams = $GLOBALS['DB']->query("SELECT * FROM teams;");
      $team_array = array();
      foreach ($teams as $team) {
        $owner = $team['owner'];
        $team_name = $team['team'];
        $id = $team['id'];
        $new_team = new Team($owner, $team_name, $id);
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
