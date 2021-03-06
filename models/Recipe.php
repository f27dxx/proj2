<?php
  class Recipe {
    //DB stuff
    private $conn;
    private $table = 'recipe';

    //recipe Properties
    public $recipe_id;
    public $name;
    public $description;
    public $user_id;
    public $quantity;
    public $measurement;
    public $item;
    public $imgUrl;
    public $content;
    public $thumbsUp;


    //Construstor with DB
    public function __construct($db){
      $this->conn = $db;
    }

    //Get Recipe
    public function getRecipe(){
      //Query
      $query = 'SELECT r.*, l.username FROM recipe r
                JOIN login l
                where l.user_id = r.user_id
                ORDER BY thumbsUp DESC';

      //Prepare statment
      $stmt = $this->conn->prepare($query);

      //Execute query
      $stmt->execute();

      return $stmt;
    }

    //get ingredients
    public function getIngre($recipe_id){
      //Query
      // $query = 'SELECT CONCAT(i.quantity, " ", m.type, " " ,i.item) AS ingredients
      $query = 'SELECT i.i_id, i.quantity, m.type, i.item, i.measurement
      FROM recipe r 
      JOIN ingredient i on i.recipe_id = r.recipe_id 
      JOIN measurement m on m.mea_id = i.measurement 
      WHERE r.recipe_id =' . $recipe_id ;

      //Prepare statment
      $stmt = $this->conn->prepare($query);

      //Execute query
      $stmt->execute();

      return $stmt;
    }

    //get step
    public function getStep($recipe_id){
      //Query
      $query = 'SELECT  m.met_id, m.step
      FROM recipe r 
      JOIN method m on m.recipe_id = r.recipe_id 
      WHERE r.recipe_id = ' . $recipe_id ;

      //Prepare statment
      $stmt = $this->conn->prepare($query);

      //Execute query
      $stmt->execute();

      return $stmt;
    }

    //get comment
    public function getComment($recipe_id){
      $query = 'SELECT c.c_id, c.content, l.username 
                FROM comment c
                JOIN login l on c.user_id = l.user_id
                WHERE recipe_id = ' . $recipe_id;

      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    //get single post
    public function read_single($id){
      $query = 'SELECT r.*, l.username FROM recipe r
                JOIN login l
                where l.user_id = r.user_id and recipe_id = ' .$id ;
      $stmt = $this->conn->prepare($query);
      //bind id
      // $stmt->bindParam(1, $this->id);

      //execute query
      $stmt->execute();

      return $stmt;
      
    }

    //create recipe
    public function createRecipe(){
     
      $this->conn->beginTransaction();

      //insert to recipe
      $query = 'INSERT INTO recipe 
              SET
              name = :name,
              description = :description,
              imgUrl = :imgUrl,
              user_id = :user_id';

      //prepate statement
      $stmt = $this->conn->prepare($query);

      //input filter
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
      $this->user_id = htmlspecialchars(strip_tags($this->user_id));

      //bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':imgUrl', $this->imgUrl);
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->execute();
      
      //get the recipeID
      $lastRecipeId = $this->conn->lastInsertId();

      //insert into ingredient
      $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

      $stmt = $this->conn->prepare($query);

      //input filter
      $this->quantity1 = htmlspecialchars(strip_tags($this->quantity1));
      $this->measurement1 = htmlspecialchars(strip_tags($this->measurement1));
      $this->item1 = htmlspecialchars(strip_tags($this->item1));

      //bind data
      $stmt->bindValue(':recipe_id', $lastRecipeId);
      $stmt->bindParam(':quantity', $this->quantity1);
      $stmt->bindParam(':measurement', $this->measurement1);
      $stmt->bindParam(':item', $this->item1);
      $stmt->execute();

      $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

      $stmt = $this->conn->prepare($query);

      //input filter
      $this->quantity2 = htmlspecialchars(strip_tags($this->quantity2));
      $this->measurement2 = htmlspecialchars(strip_tags($this->measurement2));
      $this->item2 = htmlspecialchars(strip_tags($this->item2));

      //bind data
      $stmt->bindValue(':recipe_id', $lastRecipeId);
      $stmt->bindParam(':quantity', $this->quantity2);
      $stmt->bindParam(':measurement', $this->measurement2);
      $stmt->bindParam(':item', $this->item2);
      $stmt->execute();

      if(!empty($this->quantity3) && !empty($this->measurement3) && !empty($this->item3)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity3 = htmlspecialchars(strip_tags($this->quantity3));
        $this->measurement3 = htmlspecialchars(strip_tags($this->measurement3));
        $this->item3 = htmlspecialchars(strip_tags($this->item3));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity3);
        $stmt->bindParam(':measurement', $this->measurement3);
        $stmt->bindParam(':item', $this->item3);
        $stmt->execute();
      }

      if(!empty($this->quantity4) && !empty($this->measurement4) && !empty($this->item4)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity4 = htmlspecialchars(strip_tags($this->quantity4));
        $this->measurement4 = htmlspecialchars(strip_tags($this->measurement4));
        $this->item4 = htmlspecialchars(strip_tags($this->item4));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity4);
        $stmt->bindParam(':measurement', $this->measurement4);
        $stmt->bindParam(':item', $this->item4);
        $stmt->execute();
      }

      if(!empty($this->quantity5) && !empty($this->measurement5) && !empty($this->item5)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity5 = htmlspecialchars(strip_tags($this->quantity5));
        $this->measurement5 = htmlspecialchars(strip_tags($this->measurement5));
        $this->item5 = htmlspecialchars(strip_tags($this->item5));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity5);
        $stmt->bindParam(':measurement', $this->measurement5);
        $stmt->bindParam(':item', $this->item5);
        $stmt->execute();
      }
    
      if(!empty($this->quantity6) && !empty($this->measurement6) && !empty($this->item6)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity6 = htmlspecialchars(strip_tags($this->quantity6));
        $this->measurement6 = htmlspecialchars(strip_tags($this->measurement6));
        $this->item6 = htmlspecialchars(strip_tags($this->item6));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity6);
        $stmt->bindParam(':measurement', $this->measurement6);
        $stmt->bindParam(':item', $this->item6);
        $stmt->execute();
      }

      if(!empty($this->quantity7) && !empty($this->measurement7) && !empty($this->item7)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity7 = htmlspecialchars(strip_tags($this->quantity7));
        $this->measurement7 = htmlspecialchars(strip_tags($this->measurement7));
        $this->item7 = htmlspecialchars(strip_tags($this->item7));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity7);
        $stmt->bindParam(':measurement', $this->measurement7);
        $stmt->bindParam(':item', $this->item7);
        $stmt->execute();
      }

      if(!empty($this->quantity8) && !empty($this->measurement8) && !empty($this->item8)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity8 = htmlspecialchars(strip_tags($this->quantity8));
        $this->measurement8 = htmlspecialchars(strip_tags($this->measurement8));
        $this->item8 = htmlspecialchars(strip_tags($this->item8));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity8);
        $stmt->bindParam(':measurement', $this->measurement8);
        $stmt->bindParam(':item', $this->item8);
        $stmt->execute();
      }

      if(!empty($this->quantity9) && !empty($this->measurement9) && !empty($this->item9)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity9 = htmlspecialchars(strip_tags($this->quantity9));
        $this->measurement9 = htmlspecialchars(strip_tags($this->measurement9));
        $this->item9 = htmlspecialchars(strip_tags($this->item9));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity9);
        $stmt->bindParam(':measurement', $this->measurement9);
        $stmt->bindParam(':item', $this->item9);
        $stmt->execute();
      }

      if(!empty($this->quantity10) && !empty($this->measurement10) && !empty($this->item10)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity10 = htmlspecialchars(strip_tags($this->quantity10));
        $this->measurement10 = htmlspecialchars(strip_tags($this->measurement10));
        $this->item10 = htmlspecialchars(strip_tags($this->item10));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity10);
        $stmt->bindParam(':measurement', $this->measurement10);
        $stmt->bindParam(':item', $this->item10);
        $stmt->execute();
      }

      if(!empty($this->quantity11) && !empty($this->measurement11) && !empty($this->item11)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity11 = htmlspecialchars(strip_tags($this->quantity11));
        $this->measurement11 = htmlspecialchars(strip_tags($this->measurement11));
        $this->item11 = htmlspecialchars(strip_tags($this->item11));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity11);
        $stmt->bindParam(':measurement', $this->measurement11);
        $stmt->bindParam(':item', $this->item11);
        $stmt->execute();
      }

      if(!empty($this->quantity12) && !empty($this->measurement12) && !empty($this->item12)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity12 = htmlspecialchars(strip_tags($this->quantity12));
        $this->measurement12 = htmlspecialchars(strip_tags($this->measurement12));
        $this->item12 = htmlspecialchars(strip_tags($this->item12));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity12);
        $stmt->bindParam(':measurement', $this->measurement12);
        $stmt->bindParam(':item', $this->item12);
        $stmt->execute();
      }

      if(!empty($this->quantity13) && !empty($this->measurement13) && !empty($this->item13)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity13 = htmlspecialchars(strip_tags($this->quantity13));
        $this->measurement13 = htmlspecialchars(strip_tags($this->measurement13));
        $this->item13 = htmlspecialchars(strip_tags($this->item13));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity13);
        $stmt->bindParam(':measurement', $this->measurement13);
        $stmt->bindParam(':item', $this->item13);
        $stmt->execute();
      }

      if(!empty($this->quantity14) && !empty($this->measurement14) && !empty($this->item14)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity14 = htmlspecialchars(strip_tags($this->quantity14));
        $this->measurement14 = htmlspecialchars(strip_tags($this->measurement14));
        $this->item14 = htmlspecialchars(strip_tags($this->item14));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity14);
        $stmt->bindParam(':measurement', $this->measurement14);
        $stmt->bindParam(':item', $this->item14);
        $stmt->execute();
      }

      if(!empty($this->quantity15) && !empty($this->measurement15) && !empty($this->item15)){
        $query = 'INSERT INTO ingredient
                SET
                recipe_id = :recipe_id,
                quantity = :quantity,
                measurement = :measurement,
                item = :item';

        $stmt = $this->conn->prepare($query);

        //input filter
        $this->quantity15 = htmlspecialchars(strip_tags($this->quantity15));
        $this->measurement15 = htmlspecialchars(strip_tags($this->measurement15));
        $this->item15 = htmlspecialchars(strip_tags($this->item15));

        //bind data
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':quantity', $this->quantity15);
        $stmt->bindParam(':measurement', $this->measurement15);
        $stmt->bindParam(':item', $this->item15);
        $stmt->execute();
      }


      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
      // //insert into method
      $query = 'INSERT INTO method
                SET
                recipe_id = :recipe_id,
                step = :step';

      $stmt = $this->conn->prepare($query);

      $this->step1 = htmlspecialchars(strip_tags($this->step1));

      //bind value
      $stmt->bindValue(':recipe_id', $lastRecipeId);
      $stmt->bindParam(':step', $this->step1);
      $stmt->execute();

      if(!empty($this->step2)){
        $query = 'INSERT INTO method
        SET
        recipe_id = :recipe_id,
        step = :step';

        $stmt = $this->conn->prepare($query);

        $this->step2 = htmlspecialchars(strip_tags($this->step2));

        //bind value
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':step', $this->step2);
        $stmt->execute();
      }

      if(!empty($this->step3)){
        $query = 'INSERT INTO method
        SET
        recipe_id = :recipe_id,
        step = :step';

        $stmt = $this->conn->prepare($query);

        $this->step3 = htmlspecialchars(strip_tags($this->step3));

        //bind value
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':step', $this->step3);
        $stmt->execute();
      }

      if(!empty($this->step4)){
        $query = 'INSERT INTO method
        SET
        recipe_id = :recipe_id,
        step = :step';

        $stmt = $this->conn->prepare($query);

        $this->step4 = htmlspecialchars(strip_tags($this->step4));

        //bind value
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':step', $this->step4);
        $stmt->execute();
      }


      if(!empty($this->step5)){
        $query = 'INSERT INTO method
        SET
        recipe_id = :recipe_id,
        step = :step';

        $stmt = $this->conn->prepare($query);

        $this->step5 = htmlspecialchars(strip_tags($this->step5));

        //bind value
        $stmt->bindValue(':recipe_id', $lastRecipeId);
        $stmt->bindParam(':step', $this->step5);
        $stmt->execute();
      }


      //save into database
      if($this->conn->commit()){
        $_SESSION['myLastRecipe'] = $lastRecipeId;
        return true;
      }

      //print error if something goes wrong
      printf('Error: %s.\n', $stmt->error);

      return false;
    }

    //update recipe
    public function updateRecipe(){
     
      $this->conn->beginTransaction();

      //insert to recipe
      $query = 'UPDATE recipe 
                SET
                name = :name,
                description = :description,
                imgUrl = :imgUrl
                WHERE recipe_id = :recipe_id';

      //prepate statement
      $stmt = $this->conn->prepare($query);

      //input filter
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->imgUrl = htmlspecialchars(strip_tags($this->imgUrl));
      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));
      

      //bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':imgUrl', $this->imgUrl);
      $stmt->bindParam(':recipe_id', $this->recipe_id);

      $stmt->execute();
      
      //get the recipeID
      $query = 'UPDATE ingredient
                SET
                quantity = :quantity,
                measurement = :measurement,
                item = :item
                WHERE i_id = :i_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->quantity1 = htmlspecialchars(strip_tags($this->quantity1));
      $this->measurement1 = htmlspecialchars(strip_tags($this->measurement1));
      $this->item1 = htmlspecialchars(strip_tags($this->item1));
      $this->i_id1 = htmlspecialchars(strip_tags($this->i_id1));

      //bind data
      $stmt->bindParam(':quantity', $this->quantity1);
      $stmt->bindParam(':measurement', $this->measurement1);
      $stmt->bindParam(':item', $this->item1);
      $stmt->bindParam(':i_id', $this->i_id1);
      $stmt->execute();

      $query = 'UPDATE ingredient
      SET
      quantity = :quantity,
      measurement = :measurement,
      item = :item
      WHERE i_id = :i_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->quantity2 = htmlspecialchars(strip_tags($this->quantity2));
      $this->measurement2 = htmlspecialchars(strip_tags($this->measurement2));
      $this->item2 = htmlspecialchars(strip_tags($this->item2));
      $this->i_id2 = htmlspecialchars(strip_tags($this->i_id2));

      //bind data
      $stmt->bindParam(':quantity', $this->quantity2);
      $stmt->bindParam(':measurement', $this->measurement2);
      $stmt->bindParam(':item', $this->item2);
      $stmt->bindParam(':i_id', $this->i_id2);
      $stmt->execute();

      if(!empty($this->quantity3) && !empty($this->measurement3) && !empty($this->item3) && !empty($this->i_id3)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity3 = htmlspecialchars(strip_tags($this->quantity3));
        $this->measurement3 = htmlspecialchars(strip_tags($this->measurement3));
        $this->item3 = htmlspecialchars(strip_tags($this->item3));
        $this->i_id3 = htmlspecialchars(strip_tags($this->i_id3));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity3);
        $stmt->bindParam(':measurement', $this->measurement3);
        $stmt->bindParam(':item', $this->item3);
        $stmt->bindParam(':i_id', $this->i_id3);
        $stmt->execute();

      }

      if(!empty($this->quantity4) && !empty($this->measurement4) && !empty($this->item4) && !empty($this->i_id4)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity4 = htmlspecialchars(strip_tags($this->quantity4));
        $this->measurement4 = htmlspecialchars(strip_tags($this->measurement4));
        $this->item4 = htmlspecialchars(strip_tags($this->item4));
        $this->i_id4 = htmlspecialchars(strip_tags($this->i_id4));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity4);
        $stmt->bindParam(':measurement', $this->measurement4);
        $stmt->bindParam(':item', $this->item4);
        $stmt->bindParam(':i_id', $this->i_id4);
        $stmt->execute();

      }

      if(!empty($this->quantity5) && !empty($this->measurement5) && !empty($this->item5) && !empty($this->i_id5)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity5 = htmlspecialchars(strip_tags($this->quantity5));
        $this->measurement5 = htmlspecialchars(strip_tags($this->measurement5));
        $this->item5 = htmlspecialchars(strip_tags($this->item5));
        $this->i_id5 = htmlspecialchars(strip_tags($this->i_id5));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity5);
        $stmt->bindParam(':measurement', $this->measurement5);
        $stmt->bindParam(':item', $this->item5);
        $stmt->bindParam(':i_id', $this->i_id5);
        $stmt->execute();

      }

      if(!empty($this->quantity6) && !empty($this->measurement6) && !empty($this->item6) && !empty($this->i_id6)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity6 = htmlspecialchars(strip_tags($this->quantity6));
        $this->measurement6 = htmlspecialchars(strip_tags($this->measurement6));
        $this->item6 = htmlspecialchars(strip_tags($this->item6));
        $this->i_id6 = htmlspecialchars(strip_tags($this->i_id6));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity6);
        $stmt->bindParam(':measurement', $this->measurement6);
        $stmt->bindParam(':item', $this->item6);
        $stmt->bindParam(':i_id', $this->i_id6);
        $stmt->execute();

      }

      if(!empty($this->quantity7) && !empty($this->measurement7) && !empty($this->item7) && !empty($this->i_id7)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity7 = htmlspecialchars(strip_tags($this->quantity7));
        $this->measurement7 = htmlspecialchars(strip_tags($this->measurement7));
        $this->item7 = htmlspecialchars(strip_tags($this->item7));
        $this->i_id7 = htmlspecialchars(strip_tags($this->i_id7));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity7);
        $stmt->bindParam(':measurement', $this->measurement7);
        $stmt->bindParam(':item', $this->item7);
        $stmt->bindParam(':i_id', $this->i_id7);
        $stmt->execute();

      }
    
      if(!empty($this->quantity8) && !empty($this->measurement8) && !empty($this->item8) && !empty($this->i_id8)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity8 = htmlspecialchars(strip_tags($this->quantity8));
        $this->measurement8 = htmlspecialchars(strip_tags($this->measurement8));
        $this->item8 = htmlspecialchars(strip_tags($this->item8));
        $this->i_id8 = htmlspecialchars(strip_tags($this->i_id8));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity8);
        $stmt->bindParam(':measurement', $this->measurement8);
        $stmt->bindParam(':item', $this->item8);
        $stmt->bindParam(':i_id', $this->i_id8);
        $stmt->execute();

      }

      if(!empty($this->quantity9) && !empty($this->measurement9) && !empty($this->item9) && !empty($this->i_id9)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity9 = htmlspecialchars(strip_tags($this->quantity9));
        $this->measurement9 = htmlspecialchars(strip_tags($this->measurement9));
        $this->item9 = htmlspecialchars(strip_tags($this->item9));
        $this->i_id9 = htmlspecialchars(strip_tags($this->i_id9));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity9);
        $stmt->bindParam(':measurement', $this->measurement9);
        $stmt->bindParam(':item', $this->item9);
        $stmt->bindParam(':i_id', $this->i_id9);
        $stmt->execute();

      }

      if(!empty($this->quantity10) && !empty($this->measurement10) && !empty($this->item10) && !empty($this->i_id10)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity10 = htmlspecialchars(strip_tags($this->quantity10));
        $this->measurement10 = htmlspecialchars(strip_tags($this->measurement10));
        $this->item10 = htmlspecialchars(strip_tags($this->item10));
        $this->i_id10 = htmlspecialchars(strip_tags($this->i_id10));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity10);
        $stmt->bindParam(':measurement', $this->measurement10);
        $stmt->bindParam(':item', $this->item10);
        $stmt->bindParam(':i_id', $this->i_id10);
        $stmt->execute();

      }

      if(!empty($this->quantity11) && !empty($this->measurement11) && !empty($this->item11) && !empty($this->i_id11)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity11 = htmlspecialchars(strip_tags($this->quantity11));
        $this->measurement11 = htmlspecialchars(strip_tags($this->measurement11));
        $this->item11 = htmlspecialchars(strip_tags($this->item11));
        $this->i_id11 = htmlspecialchars(strip_tags($this->i_id11));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity11);
        $stmt->bindParam(':measurement', $this->measurement11);
        $stmt->bindParam(':item', $this->item11);
        $stmt->bindParam(':i_id', $this->i_id11);
        $stmt->execute();

      }

      if(!empty($this->quantity12) && !empty($this->measurement12) && !empty($this->item12) && !empty($this->i_id12)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity12 = htmlspecialchars(strip_tags($this->quantity12));
        $this->measurement12 = htmlspecialchars(strip_tags($this->measurement12));
        $this->item12 = htmlspecialchars(strip_tags($this->item12));
        $this->i_id12 = htmlspecialchars(strip_tags($this->i_id12));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity12);
        $stmt->bindParam(':measurement', $this->measurement12);
        $stmt->bindParam(':item', $this->item12);
        $stmt->bindParam(':i_id', $this->i_id12);
        $stmt->execute();

      }

      if(!empty($this->quantity13) && !empty($this->measurement13) && !empty($this->item13) && !empty($this->i_id13)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity13 = htmlspecialchars(strip_tags($this->quantity13));
        $this->measurement13 = htmlspecialchars(strip_tags($this->measurement13));
        $this->item13 = htmlspecialchars(strip_tags($this->item13));
        $this->i_id13 = htmlspecialchars(strip_tags($this->i_id13));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity13);
        $stmt->bindParam(':measurement', $this->measurement13);
        $stmt->bindParam(':item', $this->item13);
        $stmt->bindParam(':i_id', $this->i_id13);
        $stmt->execute();

      }

      if(!empty($this->quantity14) && !empty($this->measurement14) && !empty($this->item14) && !empty($this->i_id14)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity14 = htmlspecialchars(strip_tags($this->quantity14));
        $this->measurement14 = htmlspecialchars(strip_tags($this->measurement14));
        $this->item14 = htmlspecialchars(strip_tags($this->item14));
        $this->i_id14 = htmlspecialchars(strip_tags($this->i_id14));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity14);
        $stmt->bindParam(':measurement', $this->measurement14);
        $stmt->bindParam(':item', $this->item14);
        $stmt->bindParam(':i_id', $this->i_id14);
        $stmt->execute();

      }

      if(!empty($this->quantity15) && !empty($this->measurement15) && !empty($this->item15) && !empty($this->i_id15)){
        $query = 'UPDATE ingredient
        SET
        quantity = :quantity,
        measurement = :measurement,
        item = :item
        WHERE i_id = :i_id';

        $stmt = $this->conn->prepare($query);


        //input filter
        $this->quantity15 = htmlspecialchars(strip_tags($this->quantity15));
        $this->measurement15 = htmlspecialchars(strip_tags($this->measurement15));
        $this->item15 = htmlspecialchars(strip_tags($this->item15));
        $this->i_id15 = htmlspecialchars(strip_tags($this->i_id15));

        //bind data
        $stmt->bindParam(':quantity', $this->quantity15);
        $stmt->bindParam(':measurement', $this->measurement15);
        $stmt->bindParam(':item', $this->item15);
        $stmt->bindParam(':i_id', $this->i_id15);
        $stmt->execute();

      }
      ///////////////////////////method/////////////////////////////
      //get the method id
      $query = 'UPDATE method
      SET
      step = :step
      WHERE met_id = :met_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->step1 = htmlspecialchars(strip_tags($this->step1));
      $this->met_id1 = htmlspecialchars(strip_tags($this->met_id1));

      //bind data
      $stmt->bindParam(':step', $this->step1);
      $stmt->bindParam(':met_id', $this->met_id1);
      $stmt->execute();

      if(!empty($this->step2) && !empty($this->met_id2)){
        $query = 'UPDATE method
        SET
        step = :step
        WHERE met_id = :met_id';
  
        $stmt = $this->conn->prepare($query);
  
  
        //input filter
        $this->step2 = htmlspecialchars(strip_tags($this->step2));
        $this->met_id2 = htmlspecialchars(strip_tags($this->met_id2));
  
        //bind data
        $stmt->bindParam(':step', $this->step2);
        $stmt->bindParam(':met_id', $this->met_id2);
        $stmt->execute();

      }

      if(!empty($this->step3) && !empty($this->met_id3)){
        $query = 'UPDATE method
        SET
        step = :step
        WHERE met_id = :met_id';
  
        $stmt = $this->conn->prepare($query);
  
  
        //input filter
        $this->step3 = htmlspecialchars(strip_tags($this->step3));
        $this->met_id3 = htmlspecialchars(strip_tags($this->met_id3));
  
        //bind data
        $stmt->bindParam(':step', $this->step3);
        $stmt->bindParam(':met_id', $this->met_id3);
        $stmt->execute();

      }

      if(!empty($this->step4) && !empty($this->met_id4)){
        $query = 'UPDATE method
        SET
        step = :step
        WHERE met_id = :met_id';
  
        $stmt = $this->conn->prepare($query);
  
  
        //input filter
        $this->step4 = htmlspecialchars(strip_tags($this->step4));
        $this->met_id4 = htmlspecialchars(strip_tags($this->met_id4));
  
        //bind data
        $stmt->bindParam(':step', $this->step4);
        $stmt->bindParam(':met_id', $this->met_id4);
        $stmt->execute();

      }

      if(!empty($this->step5) && !empty($this->met_id5)){
        $query = 'UPDATE method
        SET
        step = :step
        WHERE met_id = :met_id';
  
        $stmt = $this->conn->prepare($query);
  
  
        //input filter
        $this->step5 = htmlspecialchars(strip_tags($this->step5));
        $this->met_id5 = htmlspecialchars(strip_tags($this->met_id5));
  
        //bind data
        $stmt->bindParam(':step', $this->step5);
        $stmt->bindParam(':met_id', $this->met_id5);
        $stmt->execute();

      }

    //save into database
      // $conn->commit();

      if($this->conn->commit()){
        return true;
      }

      //print error if something goes wrong
      printf('Error: %s.\n', $stmt->error);

      return false;
    }
    public function deleteRecipe(){
      $this->conn->beginTransaction();

      $query = 'DELETE FROM method
                WHERE recipe_id = :recipe_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));

      //bind data
      $stmt->bindParam(':recipe_id', $this->recipe_id);

      $stmt->execute();
      
      //get the recipeID
      $query = 'DELETE FROM ingredient
                WHERE recipe_id = :recipe_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));

      //bind data
      $stmt->bindParam(':recipe_id', $this->recipe_id);

      $stmt->execute();
    
      $query = 'DELETE FROM comment
                WHERE recipe_id = :recipe_id';

      $stmt = $this->conn->prepare($query);

      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));

      $stmt->bindParam(':recipe_id', $this->recipe_id);

      $stmt->execute();


      //Delete recipe
      $query = 'DELETE FROM recipe 
      WHERE recipe_id = :recipe_id';

      //prepate statement
      $stmt = $this->conn->prepare($query);

      //input filter
      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));

      //bind data
      $stmt->bindParam(':recipe_id', $this->recipe_id);
      $stmt->execute();

      if($this->conn->commit()){
        return true;
      }

      //print error if something goes wrong
      printf('Error: %s.\n', $stmt->error);

      return false;
    
    }


    /////////////// Comment
    public function createComment(){
     
      //insert to recipe
      $query = 'INSERT INTO comment 
              SET
              recipe_id = :recipe_id,
              content = :content,
              user_id = :user_id';

      //prepate statement
      $stmt = $this->conn->prepare($query);

      //input filter
      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));
      $this->content = htmlspecialchars(strip_tags($this->content));
      $this->user_id = htmlspecialchars(strip_tags($this->user_id));

      //bind data
      $stmt->bindParam(':recipe_id', $this->recipe_id);
      $stmt->bindParam(':content', $this->content);
      $stmt->bindParam(':user_id', $this->user_id);

      //save into database
      if($stmt->execute()){

        return true;
      }

      //print error if something goes wrong
      printf('Error: %s.\n', $stmt->error);

      return false;
    }

    public function deleteComment(){

      $query = 'DELETE FROM comment
                WHERE c_id = :c_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->c_id = htmlspecialchars(strip_tags($this->c_id));

      //bind data
      $stmt->bindParam(':c_id', $this->c_id);

      if($stmt->execute()){
        return true;
      }

      //print error if something goes wrong
      printf('Error: %s.\n', $stmt->error);

      return false;
    
    }

    public function createUser(){
      $query = 'SELECT username FROM login
                WHERE username = :username';

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':username', $this->username);
      $stmt->execute();
      if($stmt->rowCount()<1) {
        $query = 'INSERT INTO login
        SET
        username = :username,
        password = :password,
        privilege = :privilege';

        $stmt = $this->conn->prepare($query);

        //encrypt
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':privilege', $this->privilege);

        if($stmt->execute()){

        return true;
        }

        //print error if something goes wrong
        printf('Error: %s.\n', $stmt->error);

        return false;
      }
    }


    public function validateUser(){
      $query = 'SELECT user_id, username, password, privilege
                FROM login
                WHERE username = :username';

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':username', $this->username);
      $stmt->execute();
      if($stmt->rowCount() > 0 ){
        $row = $stmt->fetch();
        // $password = $this->password;
        if(password_verify($this->password, $row['password'])) {
          // assign session variables
          $_SESSION['username'] = $this->username;
          $_SESSION['user_id'] = $row['user_id'];
          $_SESSION['privilege'] = $row['privilege'];
          $_SESSION['logged_in'] = true;
          // echo  $_SESSION['username'];
          // echo $_SESSION['user_id'];
          // echo $_SESSION['privilege'];
          // echo $_SESSION['logged_in'];
          return true;
        }
      }

      // printf('Error: %s.\n', $stmt->error);

      return false;
    }

    public function checkRecipeOwnership($id){
      $query = 'SELECT user_id FROM recipe
                WHERE recipe_id = :recipe_id';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':recipe_id', $id);
      $stmt->execute();
      $row = $stmt->fetch();
      // echo $row['user_id'];
      return $row['user_id'];
    }

    public function checkCommentOwnership($id){
      $query = 'SELECT user_id FROM comment
                WHERE c_id = :c_id';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':c_id', $id);
      $stmt->execute();
      $row = $stmt->fetch();
      // echo $row['user_id'];
      return $row['user_id'];
    }

    public function searchCocktail(){
      $query = 'SELECT recipe_id FROM recipe
                WHERE name LIKE :name
                ORDER BY thumbsUp DESC';

      $this->searchItem = '%'.$this->searchItem.'%';
      //Prepare statment
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':name', $this->searchItem);
      //Execute query
      $stmt->execute();
      if($stmt->rowCount() > 0){
        return $stmt;
      }
      $query = 'SELECT DISTINCT r.thumbsUp, i.recipe_id FROM ingredient i
                JOIN recipe r
                WHERE item LIKE :item and i.recipe_id = r.recipe_id
                ORDER BY thumbsUp DESC';

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':item', $this->searchItem);
      //Execute query
      $stmt->execute();

      return $stmt;
      
    }

    public function logging($action, $success) {
      $query = 'INSERT INTO log
                SET
                ip = :ip,
                browser = :browser,
                action = :action,
                success= :success';

      //prepate statement
      $stmt = $this->conn->prepare($query);

      //bind data
      $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
      $stmt->bindParam(':browser', $_SERVER['HTTP_USER_AGENT']);
      $stmt->bindParam(':action', $action);
      $stmt->bindParam(':success', $success);

      //save into database
      if($stmt->execute()){
        return true;
      }
      return false;
    }
  }