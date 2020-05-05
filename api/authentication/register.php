<?php
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
if(isset($data->privilege)){
  $recipe->privilege = $data->privilege;
} else {
  $recipe->privilege = 2;
}

if($recipe->createUser()){
  echo json_encode(
    array('message' => 'user added')
  );
} else {
  echo json_encode(
    array('message' => 'user not added, user already exist')
  );
}

?>