// display 'are you over 18' modal on load
$(window).on('load',function(){
  if(window.localStorage.getItem('adult') != 'yes'){
    $('#staticBackdrop').modal('show');
  }
  
});

// off-canvas menu

$(document).ready(function() {
 // executes when HTML-Document is loaded and DOM is ready
  console.log("document is ready");
  $('[data-toggle="offcanvas"], #navToggle').on('click', function () {
  $('.offcanvas-collapse').toggleClass('open');
  })
});

$('.spirit').on('click', function(){
  $('.offcanvas-collapse').toggleClass('open');
  $('.content').addClass('hidden');
  $('.form').addClass('hidden');
  $('.searchResult').removeClass('hidden');

  var spiritName = this.innerText;
  console.log(spiritName);

  $.getJSON('https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=' + spiritName, function(data) {
    for(i=0; i<data.drinks.length; i++){

    
    var text = `<div class="row" style="padding-top: 5%;">
                <div class="col-5">
                  <img src="${data.drinks[i].strDrinkThumb}" class="rounded img-thumbnail p-0" style="height: 100px;" alt="...">
                </div>
                <div class="col-7">
                  <p>${data.drinks[i].strDrink}</p>
                  <a class="btn btn-primary btn-sm" href="#" role="button">more</a>
                </div>
                </div>`
                
    $("#searchResult"+i).html(text);
    }
    console.log(data)
});
})

//end of off-canvas menu
var ingredientsCount = 3;
var stepCount = 2;


//user interaction
$('.navbar-brand').on('click', function(){
  $('.offcanvas-collapse').removeClass('open');
  $('.form').attr('hidden', 'hidden');
  $('.content').removeClass('hidden');
  $('.searchResult').addClass('hidden');
})

$('.showForm').on('click', function(){
  var showFormTarget = this.innerText;
  console.log(showFormTarget);
  $('.offcanvas-collapse').removeClass('open');
  $('.form').attr('hidden', 'hidden');
  $('.content').attr('hidden', 'hidden');
  $('.searchResult').addClass('hidden');
  $('.newIngre').empty();
  $('.newStep').empty();
  if(showFormTarget == 'Login'){
    showFormTarget = '#loginFormDiv';
  }
  if(showFormTarget == 'Sign Up'){
    showFormTarget = '#registerFormDiv';
  }
  if(showFormTarget == 'Create your recipe'){
    showFormTarget = '#createRecipeDiv';
  }
  console.log(showFormTarget);
  $(showFormTarget).removeAttr('hidden');
  ingredientsCount = 3;
  stepCount = 2;
  $("#ingreButton").text('Add more ingredients.');
  $("#stepButton").text('Add more steps.');
})


$('.fa-search').on('click', function(){
  $('#searchbar').toggleClass('hidden');
})
//end of user interaction

//form ingredients count
$('#ingreButton').on('click', function(){
  var html = `<div class="form-row">
                <div class="form-group col-6">
                  <label for="quantity${ingredientsCount}">Quantity</label>
                  <input type="number" class="form-control" name="quantity${ingredientsCount}" id="quantity${ingredientsCount}">
                </div>
                <div class="form-group col-6">
                  <label for="measurement${ingredientsCount}">Measurement</label>
                  <select class="form-control" id="measurement${ingredientsCount}" name="measurement${ingredientsCount}">
                    <option value="1">ml</option>
                    <option value="2">dash</option>
                  </select>
                </div>
                <div class="form-group col-12">
                  <label for="item${ingredientsCount}">Item</label>
                  <input type="text" class="form-control" name="item${ingredientsCount}" id="item${ingredientsCount}">
                </div>
              </div>`
  if(ingredientsCount<16) {
    $(".newIngre").append(html);
    ingredientsCount++
  }
  if(ingredientsCount==16) {
    $("#ingreButton").text('Maxium 15 ingredients.');
  }
})

//form step count
$('#stepButton').on('click', function(){
  var html = `<div class="form-group">
                <label for="step${stepCount}">step ${stepCount}</label>
                <textarea class="form-control" id="step${stepCount}" name="step${stepCount}" rows="3"></textarea>
              </div>`
  if(stepCount<6) {
    $(".newStep").append(html);
    stepCount++
  }
  if(stepCount==6) {
    $("#stepButton").text('Maxium 5 steps.');
  } 
})


//dark theme
!function(){var t,e=document.getElementById("darkSwitch");if(e){t=null!==localStorage.getItem("darkSwitch")&&"dark"===localStorage.getItem("darkSwitch"),(e.checked=t)?document.body.setAttribute("data-theme","dark"):document.body.removeAttribute("data-theme"),e.addEventListener("change",function(t){e.checked?(document.body.setAttribute("data-theme","dark"),localStorage.setItem("darkSwitch","dark")):(document.body.removeAttribute("data-theme"),localStorage.removeItem("darkSwitch"))})}}();


///////// register form 
document.getElementById('registerUser').addEventListener('submit', registerUser);
function registerUser(e){
  e.preventDefault();

  let username = document.getElementById('r-username').value;
  let password = document.getElementById('r-password').value;

  fetch('./api/ws.php?method=register', {
    method: 'POST',
    headers: {
      'Accept': 'applcation/json',
      'Content-type': 'application/json'
    },
    body:JSON.stringify({username:username, password:password})
  })
  .then((res)=>res.json())
  .then((data)=>console.log(data))
}

document.getElementById('login').addEventListener('submit', loginUser);
async function loginUser(e){
  e.preventDefault();

  let username = document.getElementById('l-username').value;
  let password = document.getElementById('l-password').value;

  let response = await fetch('./api/ws.php?method=login', {
    method: 'POST',
    headers: {
      'Accept': 'applcation/json',
      'Content-type': 'application/json'
    },
    body:JSON.stringify({username:username, password:password})
  });
  let data = await response.json();
  if(response.ok){
    window.localStorage.setItem('user_id', data.user_id);
    window.localStorage.setItem('privilege', data.privilege);
    window.localStorage.setItem('username', data.username);
    
    //UI control
    showLoggedInItem(true);
    showContent(true);

  }
  document.getElementById('l-password').value = '';
  friendlyReminder(response.ok, data.message)
}

document.getElementById('logoutUser').addEventListener('click', logoutUser);
async function logoutUser(){
  let response = await fetch('./api/ws.php?method=logout', {
    method: 'POST'
  });
  let data = await response.json();

  window.localStorage.removeItem('user_id');
  window.localStorage.removeItem('privilege');
  window.localStorage.removeItem('username');

  // setTimeout(function(){location.reload()}, 200);
  friendlyReminder(true, data.message)
  showLoggedInItem(false);  


}

function friendlyReminder(responseOK, message) {
  var reminderDiv = document.getElementById('friendly-reminder');
  reminderDiv.removeAttribute('hidden');
  if(responseOK){
    reminderDiv.style.backgroundColor = 'green';
  } else {
    reminderDiv.style.backgroundColor = 'red';
  }
  reminderDiv.innerText = message;
  setTimeout(function(){
    reminderDiv.setAttribute('hidden', 'hidden')
  }, 3000);
}
function showLoggedInItem(boo){
  if(boo){
    var username = window.localStorage.getItem('username');
    // var welcomebackDiv = document.getElementById('welcomebackDiv');
    var insideWelcomebackDiv = `<li class="nav-item" id="nav-username"></li>`;
    insideWelcomebackDiv += `<a class="nav-link active" href="#">Welcome back, ${username}</a>`;
    insideWelcomebackDiv += `</li>`;
  
    welcomebackDiv.innerHTML = insideWelcomebackDiv;
    welcomebackDiv.removeAttribute('hidden');
    createRecipe.removeAttribute('hidden');
    document.getElementById('logoutUser').removeAttribute('hidden');
    document.getElementById('loginLink').setAttribute('hidden', 'hidden');
    document.getElementById('registerLink').setAttribute('hidden', 'hidden');
  }
  if(!boo){
    document.getElementsByClassName('offcanvas-collapse')[0].classList.remove('open');
    welcomebackDiv.setAttribute('hidden', 'hidden');
    createRecipe.setAttribute('hidden', 'hidden');
    document.getElementById('logoutUser').setAttribute('hidden', 'hidden');
    document.getElementById('registerLink').removeAttribute('hidden', 'hidden');
    loginLink.removeAttribute('hidden');
  }

}

function isAdult(){
  window.localStorage.setItem('adult', 'yes');
}

function showContent(boo){
  var content = document.getElementsByClassName('content');
  var form = document.getElementsByClassName('form');

  if(boo){
    for(i=0; i<content.length;i++){
      content[i].removeAttribute('hidden');
    }
    for(i=0; i<form.length; i++){
      form[i].setAttribute('hidden', 'hidden');
    }
  }
  if(!boo){
    for(i=0; i<content.length;i++){
      content[i].setAttribute('hidden', 'hidden');
    }
  }
}