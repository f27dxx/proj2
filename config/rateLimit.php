<?php
session_start();

// date_default_timezone_set ('Australia/Brisbane');
  //set access counter
  if(!isset($_SESSION['accessCount'])){
    $_SESSION['accessCount'] = 0;
  }
  $_SESSION['accessCount']++;
  // echo $_SESSION['accessCount'];

  //get current time
  $_SESSION['currentTime'] = new DateTime();

  //start count 24 hours
  if(!isset($_SESSION['firstAccess'])){
    $_SESSION['firstAccess'] = new DateTime();
  }

  if(isset($_SESSION['firstAccess'])){
    // print_r ($_SESSION['firstAccess']);

    //calculate the difference btw current time and the firstAccess time
    $diff = $_SESSION['currentTime']->diff($_SESSION['firstAccess']);

    //if the difference greater or equal than 1 day
    if($diff->d >= 1){
      //reset 24 hours counter
      unset($_SESSION['firstAccess']);
      //reset access counter
      unset($_SESSION['accessCount']);
    }
    // print_r( $diff ) ;

    //if access count greater or equal to 1000 output a json error
    if(isset($_SESSION['accessCount']) && $_SESSION['accessCount'] >= 1000){
      $data = 'No more than 1000 access in 1 day';  
      header('Content-Type: application/json');
      die (json_encode($data));        
    }

  }
  
  // Rate limit Web Service to one request per second per user session
  if (isset($_SESSION['LAST_CALL'])) {
    $last = strtotime($_SESSION['LAST_CALL']);
    // echo $last . "last";
    $curr = strtotime(date("Y-m-d h:i:s"));
    // echo $curr . "curr";
    $sec =  abs($last - $curr);
    // echo $sec;
    if ($sec <= 1) {
      $data = 'Rate Limit Exceeded';  // rate limit
      header('Content-Type: application/json');
      die (json_encode($data));        
    }
  }
  $_SESSION['LAST_CALL'] = date("Y-m-d H:i:s");
  // echo $_SESSION['LAST_CALL'];

// session_destroy();

?>