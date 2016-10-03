<?php
  function setUp()
  {
    $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders?season=2016&week=1";
    $all_info = simplexml_load_file($url);
    // var_dump($all_info);
    $first_player = $all_info->scoringLeader->players->player;

    
    return $first_player;

  }



?>
