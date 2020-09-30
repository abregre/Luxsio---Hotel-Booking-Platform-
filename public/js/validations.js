//Register Form validation

$('#registerName').on('blur',validateName);
$('#registerEmail').on('blur',validateEmail);
$('#registerEmailRepeat').on('blur',validateEmailR);
$('#registerPassword').on('blur',validatePassword);
$('#registerPasswordRepeat').on('blur',validatePasswordR);


function validateName(){
  const name = $('#registerName');
  const reg = /^[a-zA-Z]{2,15}$/;
  
  if(!reg.test(name.val())){
    name.addClass('is-invalid');
    name.next().addClass('error')
  } else {
    name.removeClass('is-invalid');
    name.next().removeClass('error')
  }
}
function validateEmail(){
  const email = $('#registerEmail');
  const reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
  if(!reg.test(email.val())){
    email.addClass('is-invalid');
    email.next().addClass('error')
  } else {
    email.removeClass('is-invalid');
    email.next().removeClass('error')
  }
}
function validateEmailR(){
  const email = $('#registerEmailRepeat');
  if($('#registerEmailRepeat').val()!==$('#registerEmail').val()){
    email.addClass('is-invalid');
    email.next().addClass('error')
  }  else {
    email.removeClass('is-invalid');
    email.next().removeClass('error')
  }
}
function validatePassword(){
  const password = $('#registerPassword');
  const reg = /^.{6,}$/;
  
  if(!reg.test(password.val())){
    password.addClass('is-invalid');
    password.next().addClass('error')
  } else {
    password.removeClass('is-invalid');
    password.next().removeClass('error')
  }
}
function validatePasswordR(){
  const password = $('#registerPasswordRepeat');
  if($('#registerPassword').val()!==password.val()){
    password.addClass('is-invalid');
    password.next().addClass('error')
  }  else {
    password.removeClass('is-invalid');
    password.next().removeClass('error')
  }
}


if(validateName() || validateEmail() || validateEmailR() || validatePassword() || validatePasswordR() ){
  $('#registerForm').on('submit',(e)=>{ 
    e.preventDefault()
  })
}

//Dates validation

$('#searchBtn').on('click',(e)=>{
  var startDate = $("#checkInDate").val();
  var endDate = $("#checkOutDate").val();
  var curDate = new Date();

  if (Date.parse(startDate)< Date.parse(curDate) || Date.parse(startDate) >= Date.parse(endDate)){

    $('.search-container').on('submit',function(e){
      e.preventDefault();
    })
    $('.errorDates').html('Check your dates again');
      setTimeout(()=>{
        $('.errorDates').html('');
      },3000)
  } else {
      $('.search-container').on('submit',function(){
        $(this).unbind('submit').submit()         
      })
  }

})
