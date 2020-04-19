<?php
  require_once('../../config/whitelist.php');
  require_once('../../config/rateLimit.php');

  //header
  header('Access-Control-Allow-Origin:*');
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

  $recipe->recipe_id = $data->recipe_id;
  $recipe->content = $data->content;
  $recipe->user_id = $data->user_id;


  if($recipe->createComment()){
    echo json_encode(
      array('message' => 'Comment added')
    );
  } else {
    echo json_encode(
      array('message' => 'Comment not added')
    );
  }