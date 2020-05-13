// display 'are you over 18' modal on load
$(window).on('load',function(){
  if(window.localStorage.getItem('adult') != 'yes'){
    $('#staticBackdrop').modal('show');
  }
  if(window.localStorage.getItem('user_id')){
    showLoggedInItem(true);
  }
});
// off-canvas menu
showContent(false);
$(document).ready(function() {
 // executes when HTML-Document is loaded and DOM is ready
  console.log("document is ready");
  $('[data-toggle="offcanvas"], #navToggle').on('click', function () {
  $('.offcanvas-collapse').toggleClass('open');
  })
});

$('.spirit').on('click', function(){
  $('.offcanvas-collapse').toggleClass('open');

  var spiritName = this.innerText;
  console.log(spiritName);

  searchThis(spiritName);
})

//end of off-canvas menu
var ingredientsCount = 3;
var stepCount = 2;


//user interaction
$('.navbar-brand').on('click', function(){
  $('.offcanvas-collapse').removeClass('open');
  showContent(true);
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
  
  $(showFormTarget).removeAttr('hidden');
  ingredientsCount = 3;
  stepCount = 2;
  $("#ingreButton").text('Add more ingredients.');
  $("#stepButton").text('Add more steps.');
  for(i=1;i<3;i++){
    document.getElementById('quantity'+ i).value ='';
    document.getElementById('measurement'+ i).value = 1;
    document.getElementById('item'+ i).value = '';
  }
  document.getElementById('recipeName').value = '';
  document.getElementById('recipeDes').value = '';
  document.getElementById('recipeUrl').value = '';
  document.getElementById('step1').value = '';

})


$('.fa-search').on('click', function(){
  $('#searchbarDiv').toggleClass('hidden');
})

//end of user interaction

//form ingredients count
$('#ingreButton').on('click', function(){
  var html = `<div class="form-row">
                <div class="form-group col-6">
                  <label for="quantity${ingredientsCount}">Quantity</label>
                  <input pattern="[0-9/ ]{1,6}" title="Must within 1-6 numbers or '/'" type="text" class="form-control" name="quantity${ingredientsCount}" id="quantity${ingredientsCount}">
                </div>
                <div class="form-group col-6">
                  <label for="measurement${ingredientsCount}">Measurement</label>
                  <select class="form-control" id="measurement${ingredientsCount}" name="measurement${ingredientsCount}">
                    <option value="1">ml</option>
                    <option value="2">dash(es)</option>
                    <option value="3">oz</option>
                    <option value="4">drop(s)</option>
                    <option value="5">cup(s)</option>
                    <option value="6">slice(s)</option>
                    <option value="7">fresh</option>
                    <option value="8">cube(s)</option>
                    <option value="9">tsp</option>
                    <option value="10">tbsp</option>
                    <option value="11">bottle(s)</option>
                    <option value="12">can(s)</option>
                    <option value="13">pinch</option>
                  </select>
                </div>
                <div class="form-group col-12">
                  <label for="item${ingredientsCount}">Item</label>
                  <input pattern="[a-zA-Z '.]{3,50}" title="Item must within 3-50 English letters" type="text" class="form-control" name="item${ingredientsCount}" id="item${ingredientsCount}">
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
                <textarea pattern="[A-Za-z0-9' ]{20,600}" title="Each step must within 20-600 English letters or numbers" class="form-control" id="step${stepCount}" name="step${stepCount}" rows="3"></textarea>
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
async function registerUser(e){
  e.preventDefault();

  let username = document.getElementById('r-username').value;
  let password = document.getElementById('r-password').value;

  let response = await fetch('./api/ws.php?method=register', {
    method: 'POST',
    headers: {
      'Accept': 'applcation/json',
      'Content-type': 'application/json'
    },
    body:JSON.stringify({username:username, password:password})
  });
  let data = await response.json();
  if(response.ok){
    registerFormDiv.setAttribute('hidden', 'hidden');
    loginFormDiv.removeAttribute('hidden');
  }
  friendlyReminder(response.ok, data.message);
  document.getElementById('r-password').value = '';


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
  friendlyReminder(response.ok, data.message)
  showLoggedInItem(false);  


}

document.getElementById('createRecipe').addEventListener('submit', createRecipe);
async function createRecipe(e){
  e.preventDefault();

  var name = document.getElementById('recipeName').value;
  var description = document.getElementById('recipeDes').value;
  var imgUrl = document.getElementById('recipeUrl').value;

  var outputObj = {};
  outputObj.name = name;
  outputObj.description = description;
  outputObj.imgUrl = imgUrl;

  var quantityArray = [];
  var measurementArray = [];
  var itemArray = [];
  var stepArray = [];

  for(i=1; i<16;i++){
    console.log(i);
    if( Boolean(document.getElementById('quantity'+ i)) &&
        Boolean(document.getElementById('measurement'+ i)) &&
        Boolean(document.getElementById('item'+ i))
        ){
          if(
            (document.getElementById('quantity'+ i).value) &&
            (document.getElementById('measurement'+ i).value) &&
            (document.getElementById('item'+ i).value)
            ){
            quantityArray.push(document.getElementById('quantity'+ i).value);
            measurementArray.push(document.getElementById('measurement'+ i).value);
            itemArray.push(document.getElementById('item'+ i).value);
          }
        }

    if(Boolean(document.getElementById('step'+ i))){
      if((document.getElementById('step'+ i).value)){
        stepArray.push(document.getElementById('step'+ i).value);
      }
    }
  }
  
  for(i=1; i <= quantityArray.length; i++){
    eval('outputObj.quantity' + i + '= ' + 'quantityArray[i-1]' +';');
    eval('outputObj.measurement' + i + '= ' + 'measurementArray[i-1]' +';');
    eval('outputObj.item' + i + '= ' + 'itemArray[i-1]' +';');
  }

  for(i=1; i<= stepArray.length; i++){
    eval('outputObj.step' + i + '= ' + 'stepArray[i-1]' +';');
  }

  let response = await fetch('./api/ws.php?method=crecipe', {
    method: 'POST',
    headers: {
      'Accept': 'applcation/json',
      'Content-type': 'application/json'
    },
    body:JSON.stringify(outputObj)
  });
  let data = await response.json();

  friendlyReminder(response.ok, data.message);
  if(response.ok){
    setTimeout(function(){bringThisRecipe(data.recipe_id)}, 1000); 
  }
}

async function bringThisRecipe(recipeId){
  let response = await fetch('./api/ws.php?method=rrecipe&id=' + recipeId, {
    method: 'GET'
  });
  let result = await response.json();

  if(!response.ok){
    return friendlyReminder(response.ok, result.message);
  }

  let output;
  output = `  <img src="${result.data[0].imgUrl}" style="width:100%;" class="img-fluid" alt="Responsive image">
                <div class="row">
                  <div class="col-12">
                    <h3 style="margin-top:10px;" id="${result.data[0].recipe_id}"><b>${result.data[0].name}</b></h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-9">
                    <p class='mb-2'>by <i>${result.data[0].username}</i></p>
                  </div>
                  <div class="col-3">
                    <span><i class="far fa-heart"></i> ${result.data[0].thumbsUp}</span>
                  </div>
                </div>`

  if (window.localStorage.getItem('user_id') == result.data[0].user_id ||
      window.localStorage.getItem('privilege') == 1 ){
    
    output += `<div class="row mb-2">
                <div class="col-12">
                  <button type="button" class="btn btn-secondary btn-sm">Update</button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="showConfirmModal(${result.data[0].recipe_id}, 'recipe')">Delete</button>
                </div>
              </div>`
  }


    output +=  `<div class="row">
                  <div class="col-12">
                    <p>${result.data[0].description}</p>
                  </div>
                </div>`

  //Desc OK
  output += `<div class="row mb-1">
              <p class='col-12 m-0'>
                <button class="btn btn-primary col-12" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  Ingredients
                </button>
              </p>
              <div class="collapse col-12" id="collapseExample">
                <div class="card card-body pt-0 px-0" style="border:0;" >
                  <ul class="list-group list-group-flush2">`

  for(i = 0; i < result.data[0].ingre_arr.length; i++){
    output += `<li class="list-group-item">${result.data[0].ingre_arr[i].quantity} ${result.data[0].ingre_arr[i].type} ${result.data[0].ingre_arr[i].item}</li>`
  }
        
  output += `</ul>
            </div>
          </div>
          </div>`
  //Ingre OK
  output += `<div class="row mb-5">
              <p class="col-12 m-0">
                <button class="btn btn-primary col-12" type="button" data-toggle="collapse" data-target="#stepShowPage" aria-expanded="false" aria-controls="collapseExample">
                  Steps
                </button>
              </p>
              <div class="collapse col-12" id="stepShowPage">
                <div class="card card-body pt-0 px-0" style="border:0;">
                  <ul class="list-group list-group-flush2">`

  for(i=0; i < result.data[0].step_arr.length; i++ ){
    output += `<li class="list-group-item">${result.data[0].step_arr[i].step}</li>`
  }
    
  output += `</ul>
          </div>
        </div>
      </div>`
  //Step OK

  output += `<div class="row">
              <p class="col-12 m-0">
                <button class="btn btn-primary col-12" type="button" data-toggle="collapse" data-target="#none" aria-expanded="false" aria-controls="collapseExample">Comment`;
  if(window.localStorage.getItem('user_id')){
    output += `<span class='float-right' id="addCommentButton">+</span>`;
  }

  output += `</button>
              </p>
              <div class="collapse show col-12" id="commentShowPage">
                <div class="card card-body pt-0 px-0" style="border:0;">
                  <ul class="list-group list-group-flush2">
                    <div class="input-icons mb-0 hidden" id="addCommentDiv"> 
                      <i class="fas fa-level-down-alt mt-3" style="left:90%; transform:rotate(90deg);"></i> 
                      <input class="input-field" type="text">
                    </div>`
  for(i=0; i < result.data[0].comm_arr.length; i++ ){
    if(window.localStorage.getItem('username') == result.data[0].comm_arr[i].username){
      output += `<li class="list-group-item">${result.data[0].comm_arr[i].content}<span class='float-right'>x</span></li>`;
    } else {
      output += `<li class="list-group-item">${result.data[0].comm_arr[i].content}<span class='float-right' style="font-size : .8em;"><i>${result.data[0].comm_arr[i].username}</i></span></li>`;
    }
  }

  output += `</ul>
          </div>
        </div>
        </div>`;

  resultDiv.innerHTML = output;
  showContent(false);
  hideAllForm();
  resultDiv.removeAttribute('hidden');
  $('#addCommentButton').on('click', function(){
    $('#addCommentDiv').toggleClass('hidden');
  })
}

async function deleteThisRecipe(recipe_id){
  let response = await fetch('./api/ws.php?method=drecipe&id=' + recipe_id, {
    method: 'DELETE'
  });
  let result = await response.json();

  friendlyReminder(response.ok, result.message);
  showContent(true);
  confirmModal.innerHTML = '';
}


async function searchThis(searchItem){
  let response = await fetch('./api/ws.php?method=search&searchfield=' + searchItem, {
    method: 'GET'
  });
  let result = await response.json();

  if(!response.ok){
    return friendlyReminder(response.ok, result.message);
  }

  let output = '';

  for( i = 0; i < result.data.length; i++){
    output += `<div class="row mt-3">
                <div class="col-5">
                  <img src="${result.data[i].imgUrl}" class="rounded img-thumbnail p-0" style="height: 100px;" alt="...">
                </div>
                <div class="col-7">
                  <div class="row h-25 mh-25">
                    <p class="mb-1" onclick="bringThisRecipe(${result.data[i].recipe_id})"><strong><u>${result.data[i].name}</u></strong></p>
                  </div>
                  <div class="row h-50 mh-50">`
    if(result.data[i].ingre_arr.length >2 ){
      output += `<p style="font-size:.8em;" class="m-0"><i>${result.data[i].ingre_arr[0].item}, ${result.data[i].ingre_arr[1].item}, ${result.data[i].ingre_arr[2].item} ...</i></p>`
    } else {
      output += `<p style="font-size:.8em;" class="m-0"><i>${result.data[i].ingre_arr[0].item}, ${result.data[i].ingre_arr[1].item}</i></p>`
    }
      output +=  `</div>
                  <div class="row h-25 mh-25">
                    <span><i class="far fa-heart"></i> ${result.data[i].thumbsUp}</span>
                  </div>
                </div>
              </div>
              <hr>`

  }
  searchDiv.innerHTML = output;
  showContent(false);
  hideAllForm();
  searchDiv.removeAttribute('hidden');

}

searchbarForm.addEventListener('submit', function(e){
  searchbarSubmit(e);
});

searchbarIcon.addEventListener('click', function(){
  var searchItem = searchbar.value;
  searchbarDiv.classList.add('hidden');
  searchbar.value = '';
  searchThis(searchItem);
});

function searchbarSubmit(e){
  e.preventDefault();
  var searchItem = searchbar.value;
  searchbarDiv.classList.add('hidden');
  searchbar.value = '';
  searchThis(searchItem);
}

////////// UX function below /////////////////////////
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
    createRecipeLink.removeAttribute('hidden');
    document.getElementById('logoutUser').removeAttribute('hidden');
    document.getElementById('loginLink').setAttribute('hidden', 'hidden');
    document.getElementById('registerLink').setAttribute('hidden', 'hidden');
  }
  if(!boo){
    document.getElementsByClassName('offcanvas-collapse')[0].classList.remove('open');
    welcomebackDiv.setAttribute('hidden', 'hidden');
    createRecipeLink.setAttribute('hidden', 'hidden');
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

function hideAllForm(){
  var form = document.getElementsByClassName('form');
  for(i=0; i<form.length; i++){
    form[i].setAttribute('hidden', 'hidden');
  }
}

function showConfirmModal(id, which){
  
  var output = '';
  output += `<div class="modal" style="display:block;">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Delete confirmation</h5>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure you want to delete this?</p><p> This can't be undone</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn" onclick='confirmModal.innerHTML=""'>No</button>`
  if(which == 'recipe'){
    output += `<button type="button" class="btn btn-danger" onclick="deleteThisRecipe(${id})">Delete</button>`
  }
  if(which == 'comment'){
    console.log('test ok');
  }
  output +=       `</div>
                </div>
              </div>
            </div>`

  confirmModal.innerHTML = output;

}