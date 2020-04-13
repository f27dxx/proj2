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
 


    //Construstor with DB
    public function __construct($db){
      $this->conn = $db;
    }

    //Get Recipe
    public function getRecipe(){
      //Query
      $query = 'SELECT * FROM recipe
                ORDER BY recipe_id ASC';

      //Prepare statment
      $stmt = $this->conn->prepare($query);

      //Execute query
      $stmt->execute();

      return $stmt;
    }

    //get ingredients
    public function getIngre($recipe_id){
      //Query
      $query = 'SELECT CONCAT(i.quantity, " ", m.type, " " ,i.item) AS ingredients
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
      $query = 'SELECT m.step
      FROM recipe r 
      JOIN method m on m.recipe_id = r.recipe_id 
      WHERE r.recipe_id = ' . $recipe_id ;

      //Prepare statment
      $stmt = $this->conn->prepare($query);

      //Execute query
      $stmt->execute();

      return $stmt;
    }

    //get single post
    public function read_single($id){
      $query = 'SELECT * FROM recipe
                WHERE recipe_id = ' .$id ;
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
              user_id = :user_id';

      //prepate statement
      $stmt = $this->conn->prepare($query);

      //input filter
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->user_id = htmlspecialchars(strip_tags($this->user_id));

      //bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':description', $this->description);
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
      $this->quantity = htmlspecialchars(strip_tags($this->quantity));
      $this->measurement = htmlspecialchars(strip_tags($this->measurement));
      $this->item = htmlspecialchars(strip_tags($this->item));

      //bind data
      $stmt->bindValue(':recipe_id', $lastRecipeId);
      $stmt->bindParam(':quantity', $this->quantity);
      $stmt->bindParam(':measurement', $this->measurement);
      $stmt->bindParam(':item', $this->item);
      $stmt->execute();
    

      //insert into method
      $query = 'INSERT INTO method
                SET
                recipe_id = :recipe_id,
                step = :step';

      $stmt = $this->conn->prepare($query);

      $this->step = htmlspecialchars(strip_tags($this->step));

      //bind value
      $stmt->bindValue(':recipe_id', $lastRecipeId);
      $stmt->bindParam(':step', $this->step);
      $stmt->execute();

      //save into database
      if($this->conn->commit()){
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
              description = :description
              WHERE recipe_id = :recipe_id';

      //prepate statement
      $stmt = $this->conn->prepare($query);

      //input filter
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));
      

      //bind data
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':description', $this->description);
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
      $this->quantity = htmlspecialchars(strip_tags($this->quantity));
      $this->measurement = htmlspecialchars(strip_tags($this->measurement));
      $this->item = htmlspecialchars(strip_tags($this->item));
      $this->i_id = htmlspecialchars(strip_tags($this->i_id));

      //bind data
      $stmt->bindParam(':quantity', $this->quantity);
      $stmt->bindParam(':measurement', $this->measurement);
      $stmt->bindParam(':item', $this->item);
      $stmt->bindParam(':i_id', $this->i_id);
      $stmt->execute();
    
      //get the method id
      $query = 'UPDATE method
      SET
      step = :step
      WHERE met_id = :met_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->step = htmlspecialchars(strip_tags($this->step));
      $this->met_id = htmlspecialchars(strip_tags($this->met_id));

      //bind data
      $stmt->bindParam(':step', $this->step);
      $stmt->bindParam(':met_id', $this->met_id);
      $stmt->execute();


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

      
      
      //get the recipeID
      $query = 'DELETE FROM ingredient
                WHERE recipe_id = :recipe_id';

      $stmt = $this->conn->prepare($query);


      //input filter
      $this->recipe_id = htmlspecialchars(strip_tags($this->recipe_id));

      //bind data
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
  }