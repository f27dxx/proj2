<?php
  header('Access-Control-Allow-Origin:*');
  header('Content-Type: application/json');
  include '../config/Database.php';
  include '../models/SessionManager.php';
  session_start();
 
  if(!isset($_SESSION['newSeObj'])){
    $_SESSION['newSeObj'] = new SessionManager();
  }
  if($_SESSION['newSeObj']->userReferrer() == true && 
    $_SESSION['newSeObj']->secLimit() == true &&
    $_SESSION['newSeObj']->dailyLimit() == true){
    echo 'ok';
  } else {
    http_response_code(401);
    echo json_encode(
      array('message' => 'Access not authorized.')
    );
  }

  // session_destroy();