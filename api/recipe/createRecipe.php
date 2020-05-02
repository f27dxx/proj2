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

  $recipe->name = $data->name;
  $recipe->description = $data->description;
  $recipe->user_id = $data->user_id;


  $recipe->quantity1 = $data->quantity1;
  $recipe->measurement1 = $data->measurement1;
  $recipe->item1 = $data->item1;
  $recipe->quantity2 = $data->quantity2;
  $recipe->measurement2 = $data->measurement2;
  $recipe->item2 = $data->item2;

  if(isset($data->quantity3) && isset($data->measurement3) && isset($data->item3)){
    $recipe->quantity3 = $data->quantity3;
    $recipe->measurement3 = $data->measurement3;
    $recipe->item3 = $data->item3;
  }

  if(isset($data->quantity4) && isset($data->measurement4) && isset($data->item4)){
    $recipe->quantity4 = $data->quantity4;
    $recipe->measurement4 = $data->measurement4;
    $recipe->item4 = $data->item4;
  }

  if(isset($data->quantity5) && isset($data->measurement5) && isset($data->item5)){
    $recipe->quantity5 = $data->quantity5;
    $recipe->measurement5 = $data->measurement5;
    $recipe->item5 = $data->item5;
  }

  if(isset($data->quantity6) && isset($data->measurement6) && isset($data->item6)){
    $recipe->quantity6 = $data->quantity6;
    $recipe->measurement6 = $data->measurement6;
    $recipe->item6 = $data->item6;
  }

  if(isset($data->quantity7) && isset($data->measurement7) && isset($data->item7)){
    $recipe->quantity7 = $data->quantity7;
    $recipe->measurement7 = $data->measurement7;
    $recipe->item7 = $data->item7;
  }

  if(isset($data->quantity8) && isset($data->measurement8) && isset($data->item8)){
    $recipe->quantity8 = $data->quantity8;
    $recipe->measurement8 = $data->measurement8;
    $recipe->item8 = $data->item8;
  }

  if(isset($data->quantity9) && isset($data->measurement9) && isset($data->item9)){
    $recipe->quantity9 = $data->quantity9;
    $recipe->measurement9 = $data->measurement9;
    $recipe->item9 = $data->item9;
  }

  if(isset($data->quantity10) && isset($data->measurement10) && isset($data->item10)){
    $recipe->quantity10 = $data->quantity10;
    $recipe->measurement10 = $data->measurement10;
    $recipe->item10 = $data->item10;
  }

  if(isset($data->quantity11) && isset($data->measurement11) && isset($data->item11)){
    $recipe->quantity11 = $data->quantity11;
    $recipe->measurement11 = $data->measurement11;
    $recipe->item11 = $data->item11;
  }

  if(isset($data->quantity12) && isset($data->measurement12) && isset($data->item12)){
    $recipe->quantity12 = $data->quantity12;
    $recipe->measurement12 = $data->measurement12;
    $recipe->item12 = $data->item12;
  }

  if(isset($data->quantity13) && isset($data->measurement13) && isset($data->item13)){
    $recipe->quantity13 = $data->quantity13;
    $recipe->measurement13 = $data->measurement13;
    $recipe->item13 = $data->item13;
  }

  if(isset($data->quantity14) && isset($data->measurement14) && isset($data->item14)){
    $recipe->quantity14 = $data->quantity14;
    $recipe->measurement14 = $data->measurement14;
    $recipe->item14 = $data->item14;
  }

  if(isset($data->quantity15) && isset($data->measurement15) && isset($data->item15)){
    $recipe->quantity15 = $data->quantity15;
    $recipe->measurement15 = $data->measurement15;
    $recipe->item15 = $data->item15;
  }



  //////////////////  step /////////////////
  $recipe->step1 = $data->step1;

  if(isset($data->step2)){
    $recipe->step2 = $data->step2;
  }

  if(isset($data->step3)){
    $recipe->step3 = $data->step3;
  }

  if(isset($data->step4)){
    $recipe->step4 = $data->step4;
  }

  if(isset($data->step5)){
    $recipe->step5 = $data->step5;
  }



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
