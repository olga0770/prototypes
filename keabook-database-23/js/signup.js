$('#frmSignup').submit(function(e){
  e.preventDefault()
  $.ajax({
    url: "apis/api-signup.php",
    method: "POST",
    data: $('#frmSignup').serialize(),
    dataType: "JSON"
  }).always(function(jData){
    console.log(jData)
    return
    // {"status":1, "message":"signup success"}
    // {"status":0, "message":"signup error"}
    if(jData.status === 1){
      location.href="verify.php"
      return
    }

    console.log('Cannot sign you up') // show something in browser

  })
})