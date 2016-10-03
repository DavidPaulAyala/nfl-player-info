<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Player.php";



    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost:8889;dbname=nfl_players';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);





    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      $players = Player::getAll();
      return $app['twig']->render("index.html.twig", array('players'=>$players));
    });

    $app->get("/p", function() use($app) {
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



    // $app->get("/test", function() use ($app) {
    //   return 'test variables here';
    // });

    return $app;
?>
