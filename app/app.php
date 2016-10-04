<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Player.php";



    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=nfl_players';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render("index.html.twig");
    });

    $app->get("/admin", function() use($app) {
      return $app['twig']->render("admin.html.twig");
    });

    $app->get("/qb", function() use($app) {
      $players = Player::getPos("QB");
      return $app['twig']->render("qb.html.twig", array('players'=>$players));
    });

    $app->get("/qb/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("QB", $wk, $yr);
      return $app['twig']->render("qb.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr));
    });

    $app->get("/rb/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("RB", $wk, $yr);
      return $app['twig']->render("rb.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr));
    });

    $app->get("/wr/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("WR", $wk, $yr);
      return $app['twig']->render("wr.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr));
    });

    $app->get("/te/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("TE", $wk, $yr);
      return $app['twig']->render("te.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr));
    });

    $app->get("/k/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("K", $wk, $yr);
      return $app['twig']->render("k.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr));
    });

    $app->get("/def/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("DEF", $wk, $yr);
      return $app['twig']->render("def.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr));
    });

    $app->get("/rb", function() use($app) {
      $players = Player::getPos("RB");
      return $app['twig']->render("rb.html.twig", array('players'=>$players));
    });

    $app->get("/wr", function() use($app) {
      $players = Player::getPos("WR");
      return $app['twig']->render("wr.html.twig", array('players'=>$players));
    });

    $app->get("/te", function() use($app) {
      $players = Player::getPos("TE");
      return $app['twig']->render("te.html.twig", array('players'=>$players));
    });

    $app->get("/k", function() use($app) {
      $players = Player::getPos("K");
      return $app['twig']->render("k.html.twig", array('players'=>$players));
    });

    $app->get("/def", function() use($app) {
      $players = Player::getPos("DEF");
      return $app['twig']->render("def.html.twig", array('players'=>$players));
    });

    $app->post("/refresh", function() use($app) {
      Player::deleteAll();

      for($i = 0; $i <= 5; $i++) {
        $retrieved_players = Player::getPlayers($i);
        foreach ($retrieved_players as $player){
          $player->save();
        }
      }
      return $app->redirect("/");
    });

    $app->post("/clear", function() use($app) {
      Player::deleteAll();
      return $app->redirect("/");
    });

    return $app;
?>
