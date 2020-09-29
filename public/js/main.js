const navSlide = () => {
  const burger = document.querySelector(".burger");
  const nav = document.querySelector(".nav-links");

  burger.addEventListener("click", () => {
    nav.classList.toggle("nav-active");
    nav.classList.toggle("nav-disabled");
    //Burger animation
    burger.classList.toggle("toggle");
  });
};
navSlide();

//Login Page tabs

const signUpButton = document.querySelector("#signUp");
const signInButton = document.querySelector("#signIn");
const loginContainer = document.querySelector("#login-container");

if (signUpButton && signInButton) {
  signUpButton.addEventListener("click", () => {
    loginContainer.classList.add("right-panel-active");
  });

  signInButton.addEventListener("click", () => {
    loginContainer.classList.remove("right-panel-active");
  });
}

$(function () {
  $("#slider-range").slider({
    range: true,
    min: 0,
    max: 500,
    values: [0, 500],
    slide: function (event, ui) {
      $('#min').val(ui.values[0]);
      $('#max').val(ui.values[1]);
      
      return ui;
    },
  });
  $('#min').val($("#slider-range").slider("values", 0));
  $('#max').val($("#slider-range").slider("values", 1));
  $("#amount").val("€" + $("#slider-range").slider("values", 0) +" - €" +$("#slider-range").slider("values", 1)
  );
});

//PROFILE PAGE
const bookingHistory =document.querySelector('#bookingHistory');
const reviewHistory =document.querySelector('#reviewHistory');
const profileBookings =document.querySelector('#profileBookings');
const profileReviews =document.querySelector('#profileReviews');

bookingHistory.addEventListener('click',()=>{
  profileBookings.classList.remove('secret');
  profileReviews.classList.add('secret');
})
reviewHistory.addEventListener('click',()=>{
  profileReviews.classList.remove('secret');
  profileBookings.classList.add('secret');
})

// //Logout -- NEEDS FIX
// document.querySelector('#logout').addEventListener('click',()=>{
 
//   document.cookie = 'user_token=; expires=Thu, 01 Jan 1970 00:00:01 GMT;'
// })