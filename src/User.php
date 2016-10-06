<?php
  class User
  {
    private $id;
    private $name;
    private $password;

    function __construct($name, $password = null, $id=null)
    {
      $this->id = $id;
      $this->name = $name;
      $this->password = $password;
    }

    function getId()
    {
      return $this->id;
    }

    function getName()
    {
      return $this->name;
    }

    function getPassword()
    {
      return $this->password;
    }

    function checkUserNameAvailable()
    {
      $results = $GLOBALS['DB']->query("SELECT * FROM users WHERE name = '{$this->name}';");
      if($results->rowCount() > 0){
        return false;
      } else {
        return true;
      }
    }

    function addUser()
    {
      if ($this->checkUserNameAvailable()){
        $salt = (string) bin2hex(openssl_random_pseudo_bytes(3));
        $password_hash = (string) hash('sha256', $salt . $this->password);
        $GLOBALS['DB']->exec("INSERT INTO users (name, password_hash, salt) VALUES ('{$this->name}','{$password_hash}', '{$salt}');");
        $this->id = $GLOBALS['DB']->lastInsertID();
        return $this->id;
      }
      return null;
    }

    function login()
    {
      $user_data = $GLOBALS['DB']->query("SELECT * FROM users WHERE name = '{$this->name}';");
      if($user_data->rowCount() > 0) {
        $user_data_array = $user_data->fetch(PDO::FETCH_ASSOC);
        $salt = $user_data_array['salt'];
        $password_hash = hash('sha256', $salt . $this->password);
        if ($password_hash === $user_data_array['password_hash']){
          $this->id = $user_data_array['id'];
          return $this->id;
        }
      }
      return null;
    }

    function addTeam()
    {}

    function getTeams()
    {
      $teams = $GLOBALS['DB']->query("SELECT * FROM teams WHERE user_id = {$this->id};");
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
      $GLOBALS['DB']->exec("DELETE FROM users;");
    }

    static function getAll()
    {
      $users = $GLOBALS['DB']->query("SELECT * FROM users;");
      $user_array = array();
      foreach ($users as $user) {
        $name = $user['name'];
        $id = $user['id'];
        $new_user = new user($name, null, $id);
        array_push($user_array, $new_user);
      }
      return $user_array;
    }

    static function find($id)
    {
      $users = User::getAll();
      $matched_user = null;
      foreach($users as $user){
        if ($user->getId() == $id){
          $matched_user = $user;
        }
      }
      return $matched_user;
    }

  }
?>
