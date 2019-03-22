$('#frmLogin').submit(function(e){
  e.preventDefault()
  // validate
  
  var sEmail    = $('#txtEmail').val()
  var sPassword = $('#txtPassword').val()

  $('#invalidEmail, #invalidPassword').hide()

  var bErrorsFound = false

  if(!fnIsEmailValid(sEmail)){
    $('#invalidEmail').show()
    bErrorsFound = true
  }

  if( sPassword.length < 6 || sPassword.length > 20 ){
    $('#invalidPassword').show()
    bErrorsFound = true
  }

  if(bErrorsFound){
    return
  }
  



  $.ajax({
    url: "apis/api-login.php",
    method: "POST",
    data: $('#frmLogin').serialize(),
    dataType: "JSON"
  }).always(function(jData){
    console.log(jData)
    if(jData.status === 1){
      location.href="home.php"
      return
    }

    $('h1').text('Incorrect login')
  })

})




function fnIsEmailValid(sEmail) {
  var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return regex.test(String(sEmail).toLowerCase()); // true or false
}




