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
      private $rec_yds;
      private $rec_tds;
      private $intercepts;
      private $fum;
      private $pat;
      private $fg19;
      private $fg29;
      private $fg39;
      private $fg49;
      private $fg50;
      private $td;
      private $sack;
      private $safety;
      private $pts_alw;
      private $id;


      function __construct($first_name, $last_name, $position, $team, $ff_points, $pass_yds, $pass_tds, $rush_yds, $rush_tds, $rec_yds, $rec_tds, $intercepts, $fum, $pat, $fg19, $fg29, $fg39, $fg49, $fg50, $td, $sack, $safety, $pts_alw, $id = null)
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
        $this->rec_yds = $rec_yds;
        $this->rec_tds = $rec_tds;
        $this->intercepts = $intercepts;
        $this->fum = $fum;
        $this->pat = $pat;
        $this->fg19 = $fg19;
        $this->fg29 = $fg29;
        $this->fg39 = $fg39;
        $this->fg49 = $fg49;
        $this->fg50 = $fg50;
        $this->td = $td;
        $this->sack = $sack;
        $this->safety = $safety;
        $this->pts_alw = $pts_alw;


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

      function getRecYds()
      {
        return $this->rec_yds;
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

      function getPat()
      {
        return $this->pat;
      }

      function getFg19()
      {
        return $this->fg19;
      }

      function getFg29()
      {
        return $this->fg29;
      }

      function getFg39()
      {
        return $this->fg39;
      }

      function getFg49()
      {
        return $this->fg49;
      }

      function getFg50()
      {
        return $this->fg50;
      }

      function getTd()
      {
        return $this->td;
      }

      function getSack()
      {
        return $this->sack;
      }

      function getSafety()
      {
        return $this->safety;
      }

      function getPtsAlw()
      {
        return $this->pts_alw;
      }



      static function getPlayers($offset)
      {
        $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders?season=2016&week=1";
        $all_info = simplexml_load_file($url);
        $players = $all_info->scoringLeader[$offset]->players;
        $player_array = array();

        foreach($players->player as $player){
          $first_name = (string) $player['firstName'];
          $last_name = (string) $player['lastName'];
          $position = (string) $player['position'];
          $team = (string) $player['teamAbbr'];
          $ff_points = (float) $player['pts'];
          $pass_yds = (int) $player->stats['PassYds'];
          $pass_tds = (int) $player->stats['PassTDs'];
          $rush_yds = (int) $player->stats['RushYds'];
          $rush_tds = (int) $player->stats['RushTDs'];
          $rec_yds = (int) $player->stats['RecYds'];
          $rec_tds = (int) $player->stats['RecTDs'];
          $intercepts = (int) $player->stats['Int'];
          $fum = (int) $player->stats['FumLost'];
          $pat = (int) $player->stats['Pat'];
          $fg19 = (int) $player->stats['Fg19'];
          $fg29 = (int) $player->stats['Fg29'];
          $fg39 = (int) $player->stats['Fg39'];
          $fg49 = (int) $player->stats['Fg49'];
          $fg50 = (int) $player->stats['Fg50'];

          $td = (int) $player->stats['TD'];
          $sack = (int) $player->stats['Sack'];
          $pts_alw = (int) $player->stats['PtsAllowed'];
          $safety = (int) $player->stats['Saf'];

          $new_qb = new Player($first_name, $last_name, $position, $team, $ff_points, $pass_yds, $pass_tds, $rush_yds, $rush_tds, $rec_yds, $rec_tds, $intercepts, $fum, $pat, $fg19, $fg29, $fg39, $fg49, $fg50, $td, $sack, $safety, $pts_alw);

          array_push($player_array, $new_qb);
        }
        return $player_array;
      }

      function save()
      {
        $GLOBALS['DB']->exec("INSERT INTO players (first_name, last_name, position, team, ff_points, pass_yds, pass_tds, rush_yds, rush_tds, rec_yds, rec_tds, intercepts, fum, pat, fg19, fg29, fg39, fg49, fg50, td, sack, safety, pts_alw) VALUES ('{$this->first_name}', '{$this->last_name}','{$this->position}', '{$this->team}', {$this->ff_points}, {$this->pass_yds}, {$this->pass_tds},
          {$this->rush_yds}, {$this->rush_tds}, {$this->rec_yds},{$this->rec_tds},
           {$this->intercepts}, {$this->fum}, {$this->pat}, {$this->fg19}, {$this->fg29}, {$this->fg39}, {$this->fg49}, {$this->fg50}, {$this->td}, {$this->sack}, {$this->safety}, {$this->pts_alw});");
        $this->id = $GLOBALS['DB']->lastInsertID();
      }

      static function getPos($position)
      {
        $players = $GLOBALS['DB']->query("SELECT * FROM players WHERE position = '{$position}';");
        $player_array = array();
        foreach ($players as $player) {
          $first_name = $player['first_name'];
          $last_name = $player['last_name'];
          $position = $player['position'];
          $team = $player['team'];
          $ff_points = $player['ff_points'];
          $pass_yds = $player['pass_yds'];
          $pass_tds = $player['pass_tds'];
          $rush_yds = $player['rush_yds'];
          $rush_tds = $player['rush_tds'];
          $rec_yds = $player['rec_yds'];
          $rec_tds = $player['rec_tds'];
          $intercepts = $player['intercepts'];
          $fum = $player['fum'];
          $pat = $player['pat'];
          $fg19 = $player['fg19'];
          $fg29 = $player['fg29'];
          $fg39 = $player['fg39'];
          $fg49 = $player['fg49'];
          $fg50 = $player['fg50'];

          $td = $player['td'];
          $sack = $player['sack'];
          $safety = $player['safety'];
          $pts_alw = $player['pts_alw'];
          $id = $player['id'];
          $new_player = new Player($first_name, $last_name, $position, $team, $ff_points, $pass_yds, $pass_tds, $rush_yds, $rush_tds, $rec_yds, $rec_tds, $intercepts, $fum, $pat, $fg19, $fg29, $fg39, $fg49, $fg50, $td, $sack, $safety, $pts_alw, $id);
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
