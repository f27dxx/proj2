<?php
  require_once('../../config/whitelist.php');
  require_once('../../config/rateLimit.php');

  //header
  header('Access-Control-Allow-Origin:*');
  header('Content-Type: application/json');
  header('CAccess-Control-Allow-Methods: DELETE');
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

  $recipe->recipe_id = $data->recipe_id;


  if($recipe->deleteRecipe()){
    echo json_encode(
      array('message' => 'recipe Delete')
    );
  } else {
    echo json_encode(
      array('message' => 'recipe not Delete')
    );
  }
