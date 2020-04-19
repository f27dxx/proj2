<?php
  require_once('../../config/whitelist.php');
  require_once('../../config/rateLimit.php');

  //header
  header('Access-Control-Allow-Origin:*');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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
  $recipe->quantity = $data->quantity;
  $recipe->measurement = $data->measurement;
  $recipe->item = $data->item;
  $recipe->recipe_id = $data->recipe_id;
  $recipe->i_id = $data->i_id;
  $recipe->step = $data->step;
  $recipe->met_id = $data->met_id;



  if($recipe->updateRecipe()){
    echo json_encode(
      array('message' => 'recipe Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'recipe not Updated')
    );
  }
