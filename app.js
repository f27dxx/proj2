// display 'are you over 18' modal on load
$(window).on('load',function(){
  $('#staticBackdrop').modal('show');
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
  $('.content').removeClass('hidden');
  $('.searchResult').addClass('hidden');
  // $('.form').addClass('hidden');
})

$('#createRecipe').on('click', function(){
  $('.offcanvas-collapse').toggleClass('open');
  $('.form').removeClass('hidden');
  $('.content').addClass('hidden');
  $('.searchResult').addClass('hidden');
  $('.newIngre').empty();
  $('.newStep').empty();
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
function loginUser(e){
  e.preventDefault();

  let username = document.getElementById('l-username').value;
  let password = document.getElementById('l-password').value;
  var status;
  fetch('./api/ws.php?method=login', {
    method: 'POST',
    headers: {
      'Accept': 'applcation/json',
      'Content-type': 'application/json'
    },
    body:JSON.stringify({username:username, password:password})
  })
  .then((res)=> {
    status = res.status;
    return res.json();
  })
  .then(data=>{console.log(data); console.log(status + '1'); });
  setTimeout(function(){console.log(status + '2');}, 200);

  console.log(status + '2');
  // setTimeout(function(){location.reload()}, 200);
}

document.getElementById('logoutUser').addEventListener('click', logoutUser);
function logoutUser(){
  fetch('./api/ws.php?method=logout', {
    method: 'POST'
  })
  .then((res)=>res.json())
  .then((data)=>console.log(data));

  // setTimeout(function(){location.reload()}, 200);

}