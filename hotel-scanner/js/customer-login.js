$('#frmLogin').submit(function(e){
  e.preventDefault()

  $.ajax({
    url: "apis/api-customer-login.php",
    method: "POST",
    data: $('#frmLogin').serialize(),
    dataType: "JSON"
  }).always(function(jData){
    console.log(jData)
    if(jData.status === 1){
      location.href="customer-account.php"
      return
    }

    // $('h1').text('Incorrect login')
    swal("Incorrect!", "Your login or password are incorrect!", "warning");
  })

})



