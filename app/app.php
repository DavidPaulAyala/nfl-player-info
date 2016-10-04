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

    $app->get("/qb", function() use($app) {
      $players = Player::getPos("QB");
      return $app['twig']->render("qb.html.twig", array('players'=>$players));
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

    $app->get("/p", function() use($app) {
      $retrieved_players = Player::getPlayers(0);
      foreach ($retrieved_players as $player){
        $player->save();
      }
      $retrieved_players = Player::getPlayers(1);
      foreach ($retrieved_players as $player){
        $player->save();
      }
      $retrieved_players = Player::getPlayers(2);
      foreach ($retrieved_players as $player){
        $player->save();
      }
      $retrieved_players = Player::getPlayers(3);
      foreach ($retrieved_players as $player){
        $player->save();
      }
      $retrieved_players = Player::getPlayers(4);
      foreach ($retrieved_players as $player){
        $player->save();
      }
      return $app->redirect("/");
    });

    $app->get("/d", function() use($app) {
      Player::deleteAll();
      return $app->redirect("/");
    });

    return $app;
?>
