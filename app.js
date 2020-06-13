// display 'are you over 18' modal on load
$(window).on('load',function(){
  if(window.localStorage.getItem('adult') != 'yes'){
    $('#staticBackdrop').modal('show');
  }
  if(window.localStorage.getItem('user_id')){
    showLoggedInItem(true);
  }
  searchThis(false, true);
});
// off-canvas menu

$(document).ready(function() {
 // executes when HTML-Document is loaded and DOM is ready
  // console.log("document is ready");
  $('[data-toggle="offcanvas"], #navToggle').on('click', function () {
  $('.offcanvas-collapse').toggleClass('open');
  })
});

$('.spirit').on('click', function(){
  $('.offcanvas-collapse').toggleClass('open');

  var spiritName = this.innerText;
  // console.log(spiritName);

  searchThis(spiritName);
  showSpinner(true);
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
  // console.log(showFormTarget);
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
                  <div class="errorMsg" hidden>number only</div>
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
                    <div class="errorMsg" hidden></div>
                </div>
                <div class="form-group col-12">
                  <label for="item${ingredientsCount}">Item</label>
                  <input pattern="[a-zA-Z '.]{3,50}" title="Item must within 3-50 English letters" type="text" class="form-control" name="item${ingredientsCount}" id="item${ingredientsCount}">
                  <div class="errorMsg" hidden>within 3 - 50 letters</div>
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
                <textarea pattern="[A-Za-z0-9' ]{20,600}" title="Each step must within 15-200 English letters or numbers" class="form-control" id="step${stepCount}" name="step${stepCount}" rows="3"></textarea>
                <div class="errorMsg" hidden>within 15 - 200 letters</div>
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
  showSpinner(true);

  let username = document.getElementById('r-username').value;
  let password = document.getElementById('r-password').value;

  let response = await fetch('./api/ws.php?method=register', {
    method: 'POST',
    cache: 'no-cache',
    credentials: 'include',
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

  showSpinner(false);

}

document.getElementById('login').addEventListener('submit', loginUser);
async function loginUser(e){
  e.preventDefault();
  showSpinner(true);

  let username = document.getElementById('l-username').value;
  let password = document.getElementById('l-password').value;

  let response = await fetch('./api/ws.php?method=login', {
    method: 'POST',
    cache: 'no-cache',
    credentials: 'include',
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
  friendlyReminder(response.ok, data.message);
  showSpinner(false);

}

document.getElementById('logoutUser').addEventListener('click', logoutUser);
async function logoutUser(){
  showSpinner(true);

  let response = await fetch('./api/ws.php?method=logout', {
    method: 'POST',
    cache: 'no-cache',
    credentials: 'include'
  });
  let data = await response.json();

  window.localStorage.removeItem('user_id');
  window.localStorage.removeItem('privilege');
  window.localStorage.removeItem('username');

  // setTimeout(function(){location.reload()}, 200);
  friendlyReminder(response.ok, data.message)
  showLoggedInItem(false);  

  showSpinner(false);

}

document.getElementById('createRecipe').addEventListener('submit', createRecipe);
async function createRecipe(e, isUpdate){
  e.preventDefault();
  showSpinner(true);
  formValidation();
  if(!formValidation()){
    return showSpinner(false);
  }
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

  if(isUpdate){
    var i_idArray = [];
    var met_idArray = [];
  }

  for(i=1; i<16;i++){
    // console.log(i);
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
            if(isUpdate){
              i_idArray.push(document.getElementById('quantity'+ i).getAttribute('data-iid'));
            }
          }
        }

    if(Boolean(document.getElementById('step'+ i))){
      if((document.getElementById('step'+ i).value)){
        stepArray.push(document.getElementById('step'+ i).value);
        if(isUpdate){
          met_idArray.push(document.getElementById('step'+ i).getAttribute('data-metId'));
        }
      }
    }
  }
  
  for(i=1; i <= quantityArray.length; i++){
    eval('outputObj.quantity' + i + '= ' + 'quantityArray[i-1]' +';');
    eval('outputObj.measurement' + i + '= ' + 'measurementArray[i-1]' +';');
    eval('outputObj.item' + i + '= ' + 'itemArray[i-1]' +';');
    if(isUpdate){
      eval('outputObj.i_id' + i + '= ' + 'i_idArray[i-1]' +';');
    }
  }

  for(i=1; i<= stepArray.length; i++){
    eval('outputObj.step' + i + '= ' + 'stepArray[i-1]' +';');
    if(isUpdate){
      eval('outputObj.met_id' + i + '= ' + 'met_idArray[i-1]' +';');
    }
  }

  if(isUpdate){
    let response = await fetch('./api/ws.php?method=urecipe&id=' + isUpdate, {
      method: 'PUT',
      cache: 'no-cache',
      credentials: 'include',
      headers: {
        'Accept': 'applcation/json',
        'Content-type': 'application/json'
      },
      body:JSON.stringify(outputObj)
    });
    let data = await response.json();
    friendlyReminder(response.ok, data.message);
    if(response.ok){
      setTimeout(function(){bringThisRecipe(isUpdate)}, 1000);
    }

  }
  if(!isUpdate){
    let response = await fetch('./api/ws.php?method=crecipe', {
      method: 'POST',
      cache: 'no-cache',
      credentials: 'include',
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
  
  showSpinner(false);

}

async function bringThisRecipe(recipeId){
  showSpinner(true);

  let response = await fetch('./api/ws.php?method=rrecipe&id=' + recipeId, {
    method: 'GET',
    cache: 'no-cache',
    credentials: 'include'
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
                    <span><i class="far fa-heart" onclick="this.style.color='red'"></i> ${result.data[0].thumbsUp}</span>
                  </div>
                </div>`

  if (window.localStorage.getItem('user_id') == result.data[0].user_id ||
      window.localStorage.getItem('privilege') == 1 ){
    
    output += `<div class="row mb-2">
                <div class="col-12">
                  <button type="button" class="btn btn-secondary btn-sm" onclick="bringUpdatePage(${result.data[0].recipe_id})">Update</button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="showConfirmModal(${result.data[0].recipe_id}, false)">Delete</button>
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
                      <i id="addCommentIcon" class="fas fa-level-down-alt mt-3" style="left:90%; transform:rotate(90deg);"></i> 
                      <form id="addCommentForm">
                        <input required pattern="[a-zA-Z '.!\?]{3,50}" title="Comment must within 3-50 characters" class="input-field" type="text" id="commentContent">
                      </form>
                    </div>`
  for(i=0; i < result.data[0].comm_arr.length; i++ ){
    if(window.localStorage.getItem('username') == result.data[0].comm_arr[i].username || window.localStorage.getItem('privilege') == 1){
      output += `<li class="list-group-item">${result.data[0].comm_arr[i].content}<span onclick="showConfirmModal(${result.data[0].comm_arr[i].c_id}, ${result.data[0].recipe_id})" class='float-right'>x</span></li>`;
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

  showSpinner(false);
  //// linking function
  $('#addCommentButton').on('click', function(){
    $('#addCommentDiv').toggleClass('hidden');
  })

  addCommentForm.addEventListener('submit', function(e){
    createComment(e);
  })

  addCommentIcon.addEventListener('click', function(e){
    createComment(e);
  })
}

async function deleteThisRecipe(recipe_id){
  showSpinner(true);


  let response = await fetch('./api/ws.php?method=drecipe&id=' + recipe_id, {
    method: 'DELETE',
    cache: 'no-cache',
    credentials: 'include'
  });
  let result = await response.json();

  friendlyReminder(response.ok, result.message);
  if(response.ok){
    showContent(true);
  }
  confirmModal.innerHTML = '';

  showSpinner(false);

}


async function searchThis(searchItem, forMainPage){
  showSpinner(true);

  if(!forMainPage){
    var response = await fetch('./api/ws.php?method=search&searchfield=' + searchItem, {
      method: 'GET',
      cache: 'no-cache',
      credentials: 'include'
    });
    var result = await response.json();
  
    if(!response.ok){
      showSpinner(false);
      return friendlyReminder(response.ok, result.message);
    }
  }

  
  if(forMainPage){
    response = await fetch('./api/ws.php?method=rrecipe', {
      method: 'GET',
      cache: 'no-cache',
      credentials: 'include'
    });
    result = await response.json();
  }

  let output = '';
  var loopTime = result.data.length;
  if(forMainPage){
    loopTime = 3;
  }
  for( i = 0; i < loopTime; i++){
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
                    <span><i class="far fa-heart" onclick="this.style.color='red'"></i> ${result.data[i].thumbsUp}</span>
                  </div>
                </div>
              </div>
              <hr>`

  }

  if(forMainPage){
    mainPageDiv.innerHTML = output;
  }
  if(!forMainPage){
    searchDiv.innerHTML = output;
    showContent(false);
    hideAllForm();
    searchDiv.removeAttribute('hidden');
  }

  showSpinner(false);
}
////// comment related //////////////////////////////


async function createComment(e){
  e.preventDefault();
  showSpinner(true);


  let recipe_id = document.querySelector('#resultDiv h3').id;
  let content = commentContent.value;

  let response = await fetch('./api/ws.php?method=ccomment&id=' + recipe_id, {
    method: 'POST',
    cache: 'no-cache',
    credentials: 'include',
    headers: {
      'Accept': 'applcation/json',
      'Content-type': 'application/json'
    },
    body:JSON.stringify({content:content})
  });
  let result = await response.json();

  friendlyReminder(response.ok, result.message);
  setTimeout(function(){bringThisRecipe(recipe_id)}, 1000);
  showSpinner(false);

}

async function deleteThisComment(cId, recipeId){
  showSpinner(true);

  let response = await fetch('./api/ws.php?method=dcomment&id=' + recipeId, {
    method: 'DELETE',
    cache: 'no-cache',
    credentials: 'include',
    headers: {
      'Accept': 'applcation/json',
      'Content-type': 'application/json'
    },
    body:JSON.stringify({c_id:cId})
  });
  let result = await response.json();

  friendlyReminder(response.ok, result.message);
  
  confirmModal.innerHTML = '';
  if(response.ok){
    setTimeout(function(){bringThisRecipe(recipeId);}, 1000); 
  }
  showSpinner(false);

}
/////// update related //////////////////////////////
async function bringUpdatePage(recipeId){
  showSpinner(true);

  let response = await fetch('./api/ws.php?method=rrecipe&id=' + recipeId, {
    method: 'GET',
    cache: 'no-cache',
    credentials: 'include'
  });
  let result = await response.json();
  let output = '';

  output += `<form id='updateRecipe'>
              <h5>Update recipe</h5>
              <hr>
              <div class="form-group">
                <label for="recipeName">Cocktail name:</label>
                <input value="${result.data[0].name}" required pattern="[A-Za-z0-9 ']{2,30}" title="Name must within 2-30 English letters or numbers" type="text" class="form-control" id="recipeName" name="recipeName" placeholder="What's the name of your cocktail?">
                <div class="errorMsg" hidden>Required, within 2-30 letters, no symbols</div>
              </div>
              <div class="form-group">
                <label for="recipeDes">Cocktail description:</label>
                <textarea required pattern="[A-Za-z0-9' ]{20,600}" title="Description must within 20-600 English letters or numbers" class="form-control" name="recipeDes" id="recipeDes" rows="3" placeholder="Please briefly tell us about your cocktail (within 100 words)">${result.data[0].description}</textarea>
                <div class="errorMsg" hidden>required, within 15 - 600 letters</div>
              </div>
              <div class="form-group">
                <label for="recipeUrl">Cocktail image url:</label>
                <input value="${result.data[0].imgUrl}" required pattern="https://.+" title="Must input a valid link with https://" type="text" class="form-control" id="recipeUrl" name="recipeUrl" placeholder="Please paste the link here">
                <div class="errorMsg" hidden>Required, must start with https://</div>
              </div>
              <hr>
              <h6>Ingredients</h6>`;
  for( i=1; i <= result.data[0].ingre_arr.length; i++){
    output += `<div class="form-row">
                <div class="form-group col-6">
                  <label for="quantity${i}">Quantity</label>
                  <input data-iid="${result.data[0].ingre_arr[i-1].i_id}" value="${result.data[0].ingre_arr[i-1].quantity}" required pattern="[0-9/ ]{1,6}" title="Must within 1-6 numbers or '/'" type="text" class="form-control" name="quantity${i}" id="quantity${i}">
                  <div class="errorMsg" hidden>number only</div>
                </div>
                <div class="form-group col-6">
                  <label for="measurement${i}">Measurement</label>
                  <select  required class="form-control" name="measurement1" id="measurement${i}">
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
                  <div class="errorMsg" hidden></div>
                </div>
                <div class="form-group col-12">
                  <label for="item${i}">Item</label>
                  <input value="${result.data[0].ingre_arr[i-1].item}" required pattern="[a-zA-Z0-9 '.]{3,50}" title="Item must within 3-50 English letters" type="text" class="form-control" name="item${i}" id="item${i}">
                  <div class="errorMsg" hidden>within 3 - 50 letters</div>
                </div>
              </div>`;
  }
  output += `<hr>
  <h6>Please update your recipe</h6>`;
  for( i=1; i<= result.data[0].step_arr.length; i++){
    output += `<div class="form-group">
                <label for="step${i}">step ${i}</label>
                <textarea data-metId="${result.data[0].step_arr[i-1].met_id}" required pattern="[A-Za-z0-9' ]{20,600}" title="Each step must within 20-600 English letters or numbers" class="form-control" id="step${i}" name="step${i}" rows="3">${result.data[0].step_arr[i-1].step}</textarea>
                <div class="errorMsg" hidden>within 15 - 200 letters</div>
              </div>`;
  }
  
  output += `<hr>
          <input class="btn btn-primary mx-auto" type="submit" value="Submit">
        </form>`
  
  resultDiv.innerHTML = output;
  updateRecipe.addEventListener('submit', function(e){
    createRecipe(e, result.data[0].recipe_id);
  });
  showSpinner(false);

}

////// search related ///////////////////////////////
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

function showConfirmModal(id, boo){
  
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
                    <button type="button" class="btn" onclick='confirmModal.innerHTML=""' id="confirmModalNo">No</button>`
  if(!boo){
    output += `<button type="button" class="btn btn-danger" onclick="deleteThisRecipe(${id})">Delete</button>`
  }
  if(boo){
    output += `<button type="button" class="btn btn-danger" onclick="deleteThisComment(${id}, ${boo})">Delete</button>`
  }
  output +=       `</div>
                </div>
              </div>
            </div>`

  confirmModal.innerHTML = output;

}

darkSwitch.addEventListener('click', function(){
  document.querySelector('.offcanvas-collapse').classList.remove('open');
})

function showSpinner(boo) {
  var spinner = document.getElementById("spinner");
  if(boo){
    spinner.removeAttribute('hidden');
  }
  if(!boo){
    spinner.setAttribute('hidden', 'hidden');
  }
}

window.addEventListener('unload', function(){
  window.localStorage.removeItem('user_id');
  window.localStorage.removeItem('privilege');
  window.localStorage.removeItem('username');
})

function formValidation() {
  var allGood = true;
  const nameRex = /^[\w][a-zA-Z0-9 ']{1,29}$/;
  const descRex = /^[\w][a-zA-Z0-9 !?.']{14,599}$/;
  const urlRex = /^(https:\/\/)/;
  const quanRex = /^\d{1,3}$/;
  const meaRex = /^\d{1,2}$/;
  const itemRex = /^[\w][a-zA-Z0-9 ?!.']{1,49}$/;
  const stepRex = /^[\w][a-zA-Z0-9 ?!.']{14,199}$/;
  var quanTarget;
  var meaTarget;
  var itemTarget;
  var stepTarget;

  // validate create / update form
  if(recipeName){
    document.querySelector("#recipeName + div.errorMsg").setAttribute('hidden', 'hidden');
    if(!nameRex.test(recipeName.value)){
      document.querySelector("#recipeName + div.errorMsg").removeAttribute('hidden');
      allGood = false;
    }
  }
  if(recipeDes){
    document.querySelector("#recipeDes + div.errorMsg").setAttribute('hidden', 'hidden');
    if(!descRex.test(recipeDes.value)){
      document.querySelector("#recipeDes + div.errorMsg").removeAttribute('hidden');
      allGood = false;
    }
  }
  if(recipeUrl){
    document.querySelector("#recipeUrl + div.errorMsg").setAttribute('hidden', 'hidden');
    if(!urlRex.test(recipeUrl.value)){
      document.querySelector("#recipeUrl + div.errorMsg").removeAttribute('hidden');
      allGood = false;
    }
  }

  //validate ingredients
  for(i=1; i<16; i++){
    quanTarget = document.getElementById('quantity' + i);
    meaTarget = document.getElementById('measurement' + i);
    itemTarget = document.getElementById('item' + i);
    // validate quantity
    if(quanTarget){
      document.querySelector(`#quantity${i} + div.errorMsg`).setAttribute('hidden', 'hidden');
      if(quanTarget && quanTarget.value) {
        if(quanRex.test(quanTarget.value)) {
        } else {
          document.querySelector(`#quantity${i} + div.errorMsg`).removeAttribute('hidden');
          allGood = false
        }
      }
    }
    if(meaTarget){
      document.querySelector(`#measurement${i} + div.errorMsg`).setAttribute('hidden', 'hidden');
      if(meaTarget && meaTarget.value) {
        if(meaRex.test(meaTarget.value)) {
        } else {
          document.querySelector(`#measurement${i} + div.errorMsg`).removeAttribute('hidden');
          allGood = false
        }
      }
    }
    if(itemTarget){
      document.querySelector(`#item${i} + div.errorMsg`).setAttribute('hidden', 'hidden');
      if(itemTarget && itemTarget.value) {
        if(itemRex.test(itemTarget.value)) {
        } else {
          document.querySelector(`#item${i} + div.errorMsg`).removeAttribute('hidden');
          allGood = false
        }
      }
    }
  }
  //validate steps
  for(i=1; i < 6; i++){
    stepTarget = document.getElementById('step' + i);
    if(stepTarget){
      document.querySelector(`#step${i} + div.errorMsg`).setAttribute('hidden', 'hidden');
      if(stepTarget && stepTarget.value) {
        if(stepRex.test(stepTarget.value)) {
        } else {
          document.querySelector(`#step${i} + div.errorMsg`).removeAttribute('hidden');
          allGood = false
        }
      }
    }
  }
  allError = document.querySelectorAll(".errorMsg");
  for (i=0; i<allError.length;i++) {
    allError[i].style.color = "red";
  }
  return allGood;
}