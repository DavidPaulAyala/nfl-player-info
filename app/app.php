<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Player.php";
    require_once __DIR__."/../src/FantasyPlayer.php";
    require_once __DIR__."/../src/Team.php";
    require_once __DIR__."/../src/User.php";



    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server2 = 'mysql:host=localhost;dbname=nfl_players';
    $username = 'root';
    $password = 'root';
    $DB2 = new PDO($server2, $username, $password);

    $server = 'mysql:host=localhost;dbname=fantasy';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      if(isset($_SESSION['logged_in'])) {
        $user = User::find($_SESSION['user_id']);
        $teams = $user->getTeams();
        return $app['twig']->render("index.html.twig", array('user' => $user, 'teams' => $teams));
      }
      return $app['twig']->render("login.html.twig");
    });

    $app->get("/admin", function() use($app) {
      return $app['twig']->render("admin.html.twig");
    });

    $app->get("/qb/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("QB", $wk, $yr);
      return $app['twig']->render("qb.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "qb"));
    });

    $app->get("/rb/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("RB", $wk, $yr);
      return $app['twig']->render("rb.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "rb"));
    });

    $app->get("/wr/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("WR", $wk, $yr);
      return $app['twig']->render("wr.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "wr"));
    });

    $app->get("/te/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("TE", $wk, $yr);
      return $app['twig']->render("te.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "te"));
    });

    $app->get("/k/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("K", $wk, $yr);
      return $app['twig']->render("k.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "k"));
    });

    $app->get("/def/{wk}/{yr}", function($wk, $yr) use($app) {
      $players = Player::getPosWkYr("DEF", $wk, $yr);
      return $app['twig']->render("def.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "def"));
    });

    $app->get("/qb", function() use($app) {
      $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders";
      $all_info = simplexml_load_file($url);
      sleep(1);
      $wk = (int) $all_info['week'] - 1;
      $yr = (int) $all_info['season'];
      $players = Player::getPosWkYr("QB", $wk, $yr);
      return $app['twig']->render("qb.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "qb"));
    });

    $app->get("/rb", function() use($app) {
      $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders";
      $all_info = simplexml_load_file($url);
      sleep(1);
      $wk = (int) $all_info['week'] - 1;
      $yr = (int) $all_info['season'];
      $players = Player::getPosWkYr("RB", $wk, $yr);
      return $app['twig']->render("rb.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "rb"));
    });

    $app->get("/wr", function() use($app) {
      $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders";
      $all_info = simplexml_load_file($url);
      sleep(1);
      $wk = (int) $all_info['week'] - 1;
      $yr = (int) $all_info['season'];
      $players = Player::getPosWkYr("WR", $wk, $yr);
      return $app['twig']->render("wr.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "wr"));
    });

    $app->get("/te", function() use($app) {
      $$url = "http://api.fantasy.nfl.com/v1/players/scoringleaders";
      $all_info = simplexml_load_file($url);
      sleep(1);
      $wk = (int) $all_info['week'] - 1;
      $yr = (int) $all_info['season'];
      $players = Player::getPosWkYr("TE", $wk, $yr);
      return $app['twig']->render("te.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "te"));
    });

    $app->get("/k", function() use($app) {
      $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders";
      $all_info = simplexml_load_file($url);
      sleep(1);
      $wk = (int) $all_info['week'] - 1;
      $yr = (int) $all_info['season'];
      $players = Player::getPosWkYr("K", $wk, $yr);
      return $app['twig']->render("k.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "k"));
    });

    $app->get("/def", function() use($app) {
      $url = "http://api.fantasy.nfl.com/v1/players/scoringleaders";
      $all_info = simplexml_load_file($url);
      sleep(1);
      $wk = (int) $all_info['week'] - 1;
      $yr = (int) $all_info['season'];
      $players = Player::getPosWkYr("DEF", $wk, $yr);
      return $app['twig']->render("def.html.twig", array('players'=>$players, 'week' => $wk, 'year' => $yr, 'pos' => "def"));
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
      FantasyPlayer::deleteAll();
      Team::deleteAll();
      User::deleteAll();
      return $app->redirect("/");
    });

    $app->post("/create_team", function() use($app) {
      $new_team = new Team($_SESSION['user_id'], $_POST['team']);
      $new_team->save();
      $players = null;
      return $app['twig']->render("team.html.twig", array('team' => $new_team, 'players' => $players));
    });

    $app->get("/team/{id}", function($id) use($app) {
      $team = Team::find($id);
      $players = $team->getPlayers();
      return $app['twig']->render("team.html.twig", array('team' => $team, 'players' => $players));
    });

    $app->post("/add_player", function() use($app) {
      $team = Team::find($_POST['team_id']);
      $new_player = new FantasyPlayer($_POST['name'], $_POST['position'], $_POST['team'], $_POST['team_id']);
      $new_player->save();
      $team->addPlayer($new_player->getId());
      $players = $team->getPlayers();

      return $app['twig']->render("team.html.twig", array('team' => $team, 'players' => $players));
    });

    $app->post("/newuser", function() use($app) {
      $name = $_POST['user'];
      $password = $_POST['password'];
      $user = new User ($name, $password);
      $id = $user->addUser();
      if($id) {
        $_SESSION['user_id'] = $id;
        $_SESSION['logged_in'] = true;
        return $app->redirect("/");
      } else {
        return $app['twig']->render("autherror.html.twig");
      }
    });

    $app->post("/login", function() use($app) {
      $name = $_POST['user'];
      $password = $_POST['password'];
      $user = new User ($name, $password);
      $id = $user->login();
      if($id) {
        $_SESSION['user_id'] = $id;
        $_SESSION['logged_in'] = true;
        return $app->redirect("/");
      } else {
        return $app['twig']->render("autherror.html.twig");
      }
    });

    $app->get('/logout', function() use($app) {
      $_SESSION['logged_in'] = null;
      $_SESSION['user_id'] = null;
      return $app->redirect("/");
    });

    return $app;
?>
