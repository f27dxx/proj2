<?php
  require_once('../../config/rateLimit.php');
  require_once('../../config/whitelist.php');

  //header
  header('Access-Control-Allow-Origin:*');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Recipe.php';

  //Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  //Instantiate blog post obj
  $recipe = new Recipe($db);

  // Blog post query
  $result = $recipe->getRecipe();
  //Get row count
  $num = $result->rowCount();

  //Check if any posts
  if($num > 0){
    //Post array
    $recipes_arr = array();
    $recipes_arr['data'] = array();
    $ingre_arr = array();
    $step_arr = array();

    // getRecipe
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row);
      $recipe_info = array(
        'recipe_id' => $recipe_id,
        'name' => $name,
        'description' => $description,
        'user_id' => $user_id,
        'ingre_arr' => $ingre_arr,
        'step_arr'=> $step_arr
      );
      
      array_push($recipes_arr['data'], $recipe_info);

      //get Ingredients
      $ingreResult = $recipe->getIngre((int)$recipe_id);
      $ingreNum = $ingreResult->rowCount();

      if($ingreNum>0){
        while($ingreRow = $ingreResult->fetch(PDO::FETCH_ASSOC)){
          extract($ingreRow);

          $recipe_item = array(
            'ingredients' => $ingredients,
          );
          array_push($recipes_arr['data'], $recipe_item);
        };
      }
      
      //get step
      $stepResult = $recipe->getStep((int)$recipe_id);
      $stepNum = $stepResult->rowCount();

      if($stepNum>0){
        while($stepRow = $stepResult->fetch(PDO::FETCH_ASSOC)){
          extract($stepRow);

          $recipe_step = array(
            'step' => $step
          );
          array_push($recipes_arr['data'], $recipe_step);
        };
      }
    };

    //Trun to JSON & output
    echo json_encode($recipes_arr);
  } else {
    http_response_code(404);
    //No posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
?>
