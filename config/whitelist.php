<?php 

$whitelist = array(
    '127.0.0.1',
    '::1'
);

if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
  $data = "you don't use me correctly.";
  http_response_code(503); //service unavailable
  die(json_encode($data));
}

?>