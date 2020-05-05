<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow_Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Recipe.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post obj
$recipe = new Recipe($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$recipe->username = $data->username;
$recipe->password = $data->password;


if($recipe->validateUser()){
  echo json_encode(
    array('message' => 'Logged in')
  );
} else {
  echo json_encode(
    array('message' => 'Wrong Combination, try again.')
  );
}

?>