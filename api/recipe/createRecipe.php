<?php
  require_once('../../config/whitelist.php');
  require_once('../../config/rateLimit.php');

  //header
  header('Access-Control-Allow-Origin:*');
  header('Content-Type: application/json');
  header('CAccess-Control-Allow-Methods: POST');
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

  $recipe->name = $data->name;
  $recipe->description = $data->description;
  $recipe->user_id = $data->user_id;
  $recipe->quantity = $data->quantity;
  $recipe->measurement = $data->measurement;
  $recipe->item = $data->item;
  $recipe->step = $data->step;


  if($recipe->createRecipe()){
    echo json_encode(
      array('message' => 'recipe added')
    );
  } else {
    http_response_code(501);
    echo json_encode(
      array('message' => 'recipe not added')
    );
  }
