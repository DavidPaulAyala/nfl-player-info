<?php
    date_default_timezone_set('America/Los_Angeles');
    $website = require_once __DIR__.'/../app/app.php';
    if(!isset($_SESSION)){
      session_start();
    }
    $website->run();
?>
