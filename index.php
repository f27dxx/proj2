<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/e0994be304.js" crossorigin="anonymous"></script>
  <script defer src="app.js"></script>
  <link rel="stylesheet" href="style.css">
  <title>Cocktailer</title>
</head>
<body>
<?php session_start(); ?>
  <!-- modal -->
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Are you over 18 years old?</h5>
        </div>
        <div class="modal-body">
          <p>Consume alcohol under 18 years old without supervisition is prohibited in Australia.</p>
        </div>
        <div class="modal-footer">
          <a href="https://www.health.gov.au/health-topics/alcohol/about-alcohol/alcohol-laws-in-australia"><button type="button" class="btn btn-secondary">No</button></a>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No, but I am not drinking</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
        </div>
      </div>
    </div>
  </div>

<!--  START NAVBAR   -->
<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light navbar-offcanvas">
 <button class="navbar-toggler d-block border-0" type="button" id="navToggle">
  <span><i class="fas fa-bars"></i></span>
</button>
<a class="navbar-brand mx-auto" href="#">Cocktailer</a>
<label for="searchbar"><span><i class="fas fa-search"></i></span></label>
<input class='hidden' type="search" name="searchbar" id="searchbar">


  <div class="navbar-collapse offcanvas-collapse">
    <ul class="navbar-nav mr-auto">
      <?php 
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 'yes') {
          echo '<li class="nav-item" id="nav-username">';
          echo '<a class="nav-link active" href="#">'.'Welcome back, '.$_SESSION['username'].'</a>';
          echo '</li>';
        };
      ?>
      <?php 
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 'yes') {
          echo '<li class="nav-item" id="createRecipe">';
          echo '<a class="nav-link" href="#">Create your recipe</a>';
          echo '</li>';
        };
      ?>
      <li class="nav-item">
        <a class="nav-link spirit" href="#">Vodka</a>
      </li>
      <li class="nav-item">
        <a class="nav-link spirit" href="#">Tequila</a>
      </li>
      <li class="nav-item">
        <a class="nav-link spirit" href="#">Rum</a>
      </li>
      <li class="nav-item">
        <a class="nav-link spirit" href="#">Brandy</a>
      </li>
      <li class="nav-item">
        <a class="nav-link spirit" href="#">Whiskey</a>
      </li>
      <li class="nav-item">
        <a class="nav-link spirit" href="#">Gin</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
        <div class="dropdown-menu border-0" aria-labelledby="dropdownMenu2">
          <a class="dropdown-item" href="#">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="darkSwitch" />
              <label class="custom-control-label" for="darkSwitch">Dark Mode</label>
            </div>
          </a>
       
          <div class="dropdown-divider"></div>
        </div>
      </li>
      <li class="nav-item" style="position: absolute;, left:0; top:92%;">
        <a class="nav-link" href="#">Login/Sign up</a>
      </li>
      <li class="nav-item" style="position: absolute;, left:0; top:89%;">
        <a class="nav-link" id="logoutUser">Logout</a>
      </li>
    </ul>
    
      
    
    
  </div>
</nav>
<!--  END NAVBAR   -->
<!-- slide show -->
<div style='height:25px; width: 100%; color:white; text-align:center; position:fixed; top:56px; z-index:1;' id='friendly-reminder' hidden></div>

<div id="carouselExampleCaptions" class="carousel slide content " data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://www.bbcgoodfood.com/sites/default/files/guide/guide-image/2017/11/five.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Try Your Luck</h5>
        <p>Pick 10 random cocktail</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://www.bbcgoodfood.com/sites/default/files/editor_files/2017/11/bloody_mary.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Second slide label</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://www.bbcgoodfood.com/sites/default/files/editor_files/2017/11/cosmo.jpg" class="d-block w-100" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Third slide label</h5>
        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!-- end slide show -->
<!-- recommandation -->
<div class="container content">
  <div class="row" style="padding-top: 5%;">
    <div class="col-5">
      <img src="https://www.bbcgoodfood.com/sites/default/files/editor_files/2017/11/bloody_mary.jpg" class="rounded img-thumbnail p-0" style="height: 100px;" alt="...">
    </div>
    <div class="col-7">
      <p>Lorem ipsum dolor sit amet consectetu...</p>
      <a class="btn btn-primary btn-sm" href="#" role="button">more</a>
    </div>
  </div>
  <div class="row" style="padding-top: 5%;">
    <div class="col-5">
      <img src="https://www.bbcgoodfood.com/sites/default/files/editor_files/2017/11/cosmo.jpg" class="rounded img-thumbnail p-0" style="height: 100px;" alt="...">
    </div>
    <div class="col-7">
      <p>Lorem ipsum dolor sit amet consectetu...</p>
      <a class="btn btn-primary btn-sm" href="#" role="button">more</a>
    </div>
  </div>
  <div class="row" style="padding-top: 5%;">
    <div class="col-5">
      <img src="https://www.bbcgoodfood.com/sites/default/files/guide/guide-image/2017/11/five.jpg" class="rounded img-thumbnail p-0" style="height: 100px;" alt="...">
    </div>
    <div class="col-7">
      <p>Lorem ipsum dolor sit amet consectetu...</p>
      <a class="btn btn-primary btn-sm" href="#" role="button">more</a>
    </div>
  </div>
</div>
<!-- end of recommandation -->
<!-- search result -->
  <div class="container searchResult hidden">
    <div id='searchResult1'></div>
    <div id='searchResult2'></div>
    <div id='searchResult3'></div>
    <div id='searchResult4'></div>
    <div id='searchResult5'></div>
    <div id='searchResult6'></div>
    <div id='searchResult7'></div>
    <div id='searchResult8'></div>
    <div id='searchResult9'></div>
    <div id='searchResult10'></div>
  </div>
<!-- end of search result -->
<!-- add recipe form element -->
<div class="container form">
  <form action="/UX1/controller/createRecipe.php" method="POST">
    <h5>Create a recipe</h5>
    <hr>
    <div class="form-group">
      <label for="recipeName">Cocktail name:</label>
      <input type="text" class="form-control" id="recipeName" name="recipeName" placeholder="What's the name of your cocktail?">
    </div>
    <div class="form-group">
      <label for="recipeDes">Cocktail description:</label>
      <textarea class="form-control" name="recipeDes" id="recipeDes" rows="3" placeholder="Tell us about your cocktail"></textarea>
    </div>
    <hr>
    <h6>Ingredients</h6>
    <!-- ingredients -->
    <div class="form-row">
      <div class="form-group col-6">
        <label for="quantity1">Quantity</label>
        <input type="number" class="form-control" name="quantity1" id="quantity1">
      </div>
      <div class="form-group col-6">
        <label for="measurement1">Measurement</label>
        <select class="form-control" name="measurement1" id="measurement1">
          <option value="1">ml</option>
          <option value="2">dash</option>
        </select>
      </div>
      <div class="form-group col-12">
        <label for="item1">Item</label>
        <input type="text" class="form-control" name="item1" id="item1">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-6">
        <label for="quantity2">Quantity</label>
        <input type="number" class="form-control" name="quantity2" id="quantity2">
      </div>
      <div class="form-group col-6">
        <label for="measurement2">Measurement</label>
        <select class="form-control" name="measurement2" id="measurement2">
          <option value="1">ml</option>
          <option value="2">dash</option>
        </select>
      </div>
      <div class="form-group col-12">
        <label for="item2">Item</label>
        <input type="text" class="form-control" name="item2" id="item2">
      </div>
    </div>
    <div class="newIngre"></div>
    <button type="button" class="btn btn-link btn-lg btn-block" id='ingreButton'>Add more ingredients</button>

    <!-- end of ingredient -->
    <hr>
    <h6>Add your instructions one at a time</h6>
    <!-- method -->
    <div class="form-group">
      <label for="step1">step 1</label>
      <textarea class="form-control" id="step1" name="step1" rows="3"></textarea>
    </div>
    <div class="newStep"></div>
    <button type="button" class="btn btn-link btn-lg btn-block" id='stepButton'>Add more steps</button>
    <hr>
    <!-- end of method -->
    <input class="btn btn-primary mx-auto" type="submit" value="Submit">
  </form>
</div>
<!-- end recipe form -->
<!-- register form -->
<div class="container">
  <h5>Register form</h5>
  <hr>
  <form id='registerUser'>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" class="form-control" id="r-username" name="username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" class="form-control" id='r-password' name="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<!-- end of register form -->
<!-- login form -->
<div class="container">
  <h5>Login form</h5>
  <hr>
  <form id='login'>
    <div class="form-group">
      <label for="l-username">Username</label>
      <input type="text" class="form-control" id="l-username" name="l-username">
    </div>
    <div class="form-group">
      <label for="l-password">Password</label>
      <input type="password" class="form-control" name="l-password" id="l-password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
<!-- end of login form -->

</body>
</html>