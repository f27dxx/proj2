<?php
  header('Access-Control-Allow-Origin:*');
  header('Content-Type: application/json');
  include '../config/Database.php';
  include '../models/SessionManager.php';
  session_start();
  
  //check AccessLimit and Referrer
  if(!isset($_SESSION['newSeObj'])){
    $_SESSION['newSeObj'] = new SessionManager();
  }
  if($_SESSION['newSeObj']->userReferrer() == true && 
    $_SESSION['newSeObj']->secLimit() == true &&
    $_SESSION['newSeObj']->dailyLimit() == true){
    // echo 'ok';
  } else {
    http_response_code(401);
    echo json_encode(
      array('message' => 'Access not authorized.')
    );
    die();
  }
  //connect to database
  include '../models/Recipe.php';
  $database = new Database();
  $db = $database->connect();
  $recipe = new Recipe($db);
  if(isset($_GET['method'])){
    switch($_GET['method']){
      case 'rrecipe':
      if(isset($_GET['id'])){
        $id = $_GET['id'];
        $result = $recipe->read_single($id);
      } else {
        $result = $recipe->getRecipe();
      }

      $num = $result->rowCount();

      if($num > 0){
        $i = 0 ;
        //Post array
        $recipes_arr = array();
        $recipes_arr['data'] = array();
        $ingre_arr = array();
        $step_arr = array();
        $comm_arr = array();
    
        // getRecipe
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $recipe_info = array(
            'recipe_id' => $recipe_id,
            'name' => $name,
            'description' => $description,
            'imgUrl' => $imgUrl,
            'thumbsUp' => $thumbsUp,
            'user_id' => $user_id,
            'ingre_arr' => $ingre_arr,
            'step_arr'=> $step_arr,
            'comm_arr' => $comm_arr
          );
          
          array_push($recipes_arr['data'], $recipe_info);
    
          //get Ingredients
          $ingreResult = $recipe->getIngre((int)$recipe_id);
          $ingreNum = $ingreResult->rowCount();
    
          if($ingreNum>0){
            while($ingreRow = $ingreResult->fetch(PDO::FETCH_ASSOC)){
              // extract($ingreRow);
              
              // $recipe_item = array(
              //   'ingredients' => $ingredients,
              // );
              array_push($recipes_arr['data'][$i]['ingre_arr'], $ingreRow);
            };
          }
          
          //get step
          $stepResult = $recipe->getStep((int)$recipe_id);
          $stepNum = $stepResult->rowCount();
    
          if($stepNum>0){
            while($stepRow = $stepResult->fetch(PDO::FETCH_ASSOC)){
              // extract($stepRow);
    
              // $recipe_step = array(
              //   'step' => $step
              // );
              array_push($recipes_arr['data'][$i]['step_arr'], $stepRow);
            };
          }
          
          $commResult = $recipe->getComment((int)$recipe_id);
          $commNum = $commResult->rowCount();
    
          if($commNum>0){
            while($commRow = $commResult->fetch(PDO::FETCH_ASSOC)){
    
              array_push($recipes_arr['data'][$i]['comm_arr'], $commRow);
            };
          }
    
    
          $i++;
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

      break;
      case 'register':
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
          http_response_code(409);
          echo json_encode(
            array('message' => 'user not added, user already exist')
          );
        }
      break;
      case 'login':
        $data = json_decode(file_get_contents("php://input"));

        $recipe->username = $data->username;
        $recipe->password = $data->password;


        if($recipe->validateUser()){
          echo json_encode(
            array('message' => 'Logged in')
          );
        } else {
          http_response_code(401);
          echo json_encode(
            array('message' => 'Wrong Combination, try again.')
          );
        }
      break;
      case 'logout':
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        unset($_SESSION['privilege']);
        unset($_SESSION['logged_in']);
        echo json_encode(
          array('message' => 'You have logged out')
        );
        // echo  $_SESSION['username'];
        // echo $_SESSION['user_id'];
        // echo $_SESSION['privilege'];
        // echo $_SESSION['logged_in'];
        // session_destroy();
      break;
      case 'crecipe':
        if(isset($_SESSION['logged_in'])){
          $data = json_decode(file_get_contents("php://input"));

          $recipe->name = $data->name;
          $recipe->description = $data->description;
          $recipe->imgUrl = $data->imgUrl;
          $recipe->user_id = $_SESSION['user_id'];


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
        } else {
          //if user is not logged in
          http_response_code(403);
          echo json_encode(
            array('message' => 'Access denied')
          );
        }
        
      break;
      case 'drecipe':
        if(isset($_GET['id']) && isset($_SESSION['logged_in'])){
          if(
            //if the logged in user own the recipe
            $recipe->checkRecipeOwnership($_GET['id']) == $_SESSION['user_id'] ||
            // or the logged in user have admin privilege
            $_SESSION['privilege'] == 1){
              
            $data = json_decode(file_get_contents("php://input"));

            $recipe->recipe_id = $_GET['id'];
            //delete recipe
            if($recipe->deleteRecipe()){
              echo json_encode(
                array('message' => 'recipe Delete')
              );
            } else {
              //if somehow the user own the recipe cannot delete it
              echo json_encode(
                array('message' => 'recipe not Delete')
              );
            }
            
          } else {
            //if logged in but user does not own the recipe
            http_response_code(403);
            echo json_encode(
              array('message' => 'Access denied')
            );
          }

        } else {
          //if get access to delete recipe but not logged in
          http_response_code(401);
          echo json_encode(
            array('message' => 'Not authorized.')
          );
        }

      break;
      case 'urecipe':
        if(isset($_GET['id']) && isset($_SESSION['logged_in'])){
          if(
            //if the logged in user own the recipe
            $recipe->checkRecipeOwnership($_GET['id']) == $_SESSION['user_id'] ||
            // or the logged in user have admin privilege
            $_SESSION['privilege'] == 1){
              
            $data = json_decode(file_get_contents("php://input"));
            
            $recipe->name = $data->name;
            $recipe->description = $data->description;
            $recipe->imgUrl = $data->imgUrl;  
            $recipe->recipe_id = $_GET['id'];

            $recipe->quantity1 = $data->quantity1;
            $recipe->measurement1 = $data->measurement1;
            $recipe->item1 = $data->item1;
            $recipe->i_id1 = $data->i_id1;
            $recipe->quantity2 = $data->quantity2;
            $recipe->measurement2 = $data->measurement2;
            $recipe->item2 = $data->item2;
            $recipe->i_id2 = $data->i_id2;
  
            if(isset($data->quantity3) && isset($data->measurement3) && isset($data->item3) && isset($data->i_id3)){
              $recipe->quantity3 = $data->quantity3;
              $recipe->measurement3 = $data->measurement3;
              $recipe->item3 = $data->item3;
              $recipe->i_id3 = $data->i_id3;
            }
  
            if(isset($data->quantity4) && isset($data->measurement4) && isset($data->item4) && isset($data->i_id4)){
              $recipe->quantity4 = $data->quantity4;
              $recipe->measurement4 = $data->measurement4;
              $recipe->item4 = $data->item4;
              $recipe->i_id4 = $data->i_id4;
            }
  
            if(isset($data->quantity5) && isset($data->measurement5) && isset($data->item5) && isset($data->i_id5)){
              $recipe->quantity5 = $data->quantity5;
              $recipe->measurement5 = $data->measurement5;
              $recipe->item5 = $data->item5;
              $recipe->i_id5 = $data->i_id5;
            }
  
            if(isset($data->quantity6) && isset($data->measurement6) && isset($data->item6) && isset($data->i_id6)){
              $recipe->quantity6 = $data->quantity6;
              $recipe->measurement6 = $data->measurement6;
              $recipe->item6 = $data->item6;
              $recipe->i_id6 = $data->i_id6;
            }
  
            if(isset($data->quantity7) && isset($data->measurement7) && isset($data->item7) && isset($data->i_id7)){
              $recipe->quantity7 = $data->quantity7;
              $recipe->measurement7 = $data->measurement7;
              $recipe->item7 = $data->item7;
              $recipe->i_id7 = $data->i_id7;
            }
  
            if(isset($data->quantity8) && isset($data->measurement8) && isset($data->item8) && isset($data->i_id8)){
              $recipe->quantity8 = $data->quantity8;
              $recipe->measurement8 = $data->measurement8;
              $recipe->item8 = $data->item8;
              $recipe->i_id8 = $data->i_id8;
            }
  
            if(isset($data->quantity9) && isset($data->measurement9) && isset($data->item9) && isset($data->i_id9)){
              $recipe->quantity9 = $data->quantity9;
              $recipe->measurement9 = $data->measurement9;
              $recipe->item9 = $data->item9;
              $recipe->i_id9 = $data->i_id9;
            }
  
            if(isset($data->quantity10) && isset($data->measurement10) && isset($data->item10) && isset($data->i_id10)){
              $recipe->quantity10 = $data->quantity10;
              $recipe->measurement10 = $data->measurement10;
              $recipe->item10 = $data->item10;
              $recipe->i_id10 = $data->i_id10;
            }
  
            if(isset($data->quantity11) && isset($data->measurement11) && isset($data->item11) && isset($data->i_id11)){
              $recipe->quantity11 = $data->quantity11;
              $recipe->measurement11 = $data->measurement11;
              $recipe->item11 = $data->item11;
              $recipe->i_id11 = $data->i_id11;
            }
  
            if(isset($data->quantity12) && isset($data->measurement12) && isset($data->item12) && isset($data->i_id12)){
              $recipe->quantity12 = $data->quantity12;
              $recipe->measurement12 = $data->measurement12;
              $recipe->item12 = $data->item12;
              $recipe->i_id12 = $data->i_id12;
            }
  
            if(isset($data->quantity13) && isset($data->measurement13) && isset($data->item13) && isset($data->i_id13)){
              $recipe->quantity13 = $data->quantity13;
              $recipe->measurement13 = $data->measurement13;
              $recipe->item13 = $data->item13;
              $recipe->i_id13 = $data->i_id13;
            }
  
            if(isset($data->quantity14) && isset($data->measurement14) && isset($data->item14) && isset($data->i_id14)){
              $recipe->quantity14 = $data->quantity14;
              $recipe->measurement14 = $data->measurement14;
              $recipe->item14 = $data->item14;
              $recipe->i_id14 = $data->i_id14;
            }
  
            if(isset($data->quantity15) && isset($data->measurement15) && isset($data->item15) && isset($data->i_id15)){
              $recipe->quantity15 = $data->quantity15;
              $recipe->measurement15 = $data->measurement15;
              $recipe->item15 = $data->item15;
              $recipe->i_id15 = $data->i_id15;
            }
  
            //////////////////  step /////////////////
            $recipe->step1 = $data->step1;
            $recipe->met_id1 = $data->met_id1;
  
            if(isset($data->step2) && isset($data->met_id2)){
              $recipe->step2 = $data->step2;
              $recipe->met_id2 = $data->met_id2;
            }
  
            if(isset($data->step3) && isset($data->met_id3)){
              $recipe->step3 = $data->step3;
              $recipe->met_id3 = $data->met_id3;
            }
  
            if(isset($data->step4) && isset($data->met_id4)){
              $recipe->step4 = $data->step4;
              $recipe->met_id4 = $data->met_id4;
            }
  
            if(isset($data->step5) && isset($data->met_id5)){
              $recipe->step5 = $data->step5;
              $recipe->met_id5 = $data->met_id5;
            }

            if($recipe->updateRecipe()){
              echo json_encode(
                array('message' => 'recipe updated')
              );
            } else {
              echo json_encode(
                array('message' => 'recipe NOT updated')
              );
            }


          ////////////////////////////////////////////////////////
            
          } else {
            //if logged in but user does not own the recipe
            http_response_code(403);
            echo json_encode(
              array('message' => 'Access denied')
            );
          }

        } else {
          //if get access to delete recipe but not logged in
          http_response_code(401);
          echo json_encode(
            array('message' => 'Not authorized.')
          );
        }
      break;
      case 'ccomment':
        if(isset($_GET['id']) && isset($_SESSION['logged_in'])){

              
          $data = json_decode(file_get_contents("php://input"));

          $recipe->recipe_id = $_GET['id'];
          $recipe->content = $data->content;
          $recipe->user_id = $_SESSION['user_id'];
        
        
          if($recipe->createComment()){
            echo json_encode(
              array('message' => 'Comment added')
            );
          } else {
            echo json_encode(
              array('message' => 'Comment not added')
            );
          }

        } else {
          //if get access to delete recipe but not logged in
          http_response_code(401);
          echo json_encode(
            array('message' => 'Not authorized.')
          );
        }
      break;
      case 'dcomment':
        if(isset($_GET['id']) && isset($_SESSION['logged_in'])){
          $data = json_decode(file_get_contents("php://input"));
          if(
            //if the logged in user own the comment
            $recipe->checkCommentOwnership($data->c_id) == $_SESSION['user_id'] ||
            // or the logged in user have admin privilege
            $_SESSION['privilege'] == 1){

            $recipe->c_id = $data->c_id;
          
            if($recipe->deleteComment()){
              echo json_encode(
                array('message' => 'Comment Delete')
              );
            } else {
              echo json_encode(
                array('message' => 'Comment not Delete')
              );
            }
            
          } else {
            //if logged in but user does not own the recipe
            http_response_code(403);
            echo json_encode(
              array('message' => 'Access denied')
            );
          }

        } else {
          //if get access to delete recipe but not logged in
          http_response_code(401);
          echo json_encode(
            array('message' => 'Not authorized.')
          );
        }
      break;
      case 'search':
        if(isset($_GET['searchfield'])){
          $recipe->searchItem = $_GET['searchfield'];
          $searchResult = $recipe->searchCocktail();
          $searchNum = $searchResult->rowCount();
          if($searchNum > 0){
            $i = 0 ;
            //Post array
            $recipes_arr = array();
            $recipes_arr['data'] = array();
            $ingre_arr = array();
            $step_arr = array();
            $comm_arr = array();

            while($searchRow = $searchResult->fetch(PDO::FETCH_ASSOC)){
              extract($searchRow);
              // echo $searchRow['recipe_id'];
              $result = $recipe->read_single($searchRow['recipe_id']);
              //////////////////////////////////////
              while($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $recipe_info = array(
                  'recipe_id' => $recipe_id,
                  'name' => $name,
                  'description' => $description,
                  'imgUrl' => $imgUrl,
                  'user_id' => $user_id,
                  'thumbsUp' => $thumbsUp,
                  'ingre_arr' => $ingre_arr,
                  'step_arr'=> $step_arr,
                  'comm_arr' => $comm_arr
                );
                
                array_push($recipes_arr['data'], $recipe_info);
          
                //get Ingredients
                $ingreResult = $recipe->getIngre((int)$recipe_id);
                $ingreNum = $ingreResult->rowCount();
          
                if($ingreNum>0){
                  while($ingreRow = $ingreResult->fetch(PDO::FETCH_ASSOC)){
                    // extract($ingreRow);
                    
                    // $recipe_item = array(
                    //   'ingredients' => $ingredients,
                    // );
                    array_push($recipes_arr['data'][$i]['ingre_arr'], $ingreRow);
                  };
                }
                
                //get step
                $stepResult = $recipe->getStep((int)$recipe_id);
                $stepNum = $stepResult->rowCount();
          
                if($stepNum>0){
                  while($stepRow = $stepResult->fetch(PDO::FETCH_ASSOC)){
                    // extract($stepRow);
          
                    // $recipe_step = array(
                    //   'step' => $step
                    // );
                    array_push($recipes_arr['data'][$i]['step_arr'], $stepRow);
                  };
                }
                
                $commResult = $recipe->getComment((int)$recipe_id);
                $commNum = $commResult->rowCount();
          
                if($commNum>0){
                  while($commRow = $commResult->fetch(PDO::FETCH_ASSOC)){
          
                    array_push($recipes_arr['data'][$i]['comm_arr'], $commRow);
                  };
                }
          
          
              };
              
              $i++;
              ////////////////////////////////////////
            }

            echo json_encode($recipes_arr);

          } else {
            http_response_code(404);
            //No posts
            echo json_encode(
              array('message' => 'No Posts Found')
            );
          }
        }
      break;
      default:
        http_response_code(404);
        echo json_encode(
          array('message' => 'Page not found.')
        );
    }
  }


