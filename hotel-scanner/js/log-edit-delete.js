$(document).on('click', '.btnDelete', function(){
    console.log('test delete')
  
    var sLogMessageToDelete = $(this).parent()
    var iMessageId = $(this).parent().attr('id')
    console.log('iMessageId:', iMessageId, sLogMessageToDelete)
  
    $.ajax({
      url: "log-api-delete-message.php",
      method: "GET",
      data: {"iMessageId": iMessageId},
      dataType: "JSON"
    }).done(function(jData){
      console.log(jData)
      if(jData.status){
        $(sLogMessageToDelete).remove()
      }
    }).fail(function(uData){
      console.log('something went wrong with deleting hotel')
    })
  
  })





  $(document).on('click', '.btnEdit', function(){
    console.log('edit')
  
    if($(this).text() == 'Edit comment'){
      $(this).parent().find('.message').attr('contenteditable', true).focus()
      $(this).text('Save')
    }else{ // this is when you click save
      $(this).text('Edit comment')
      $(this).parent().find('.message').attr('contenteditable', false)
      
      var iMessageId = $(this).parent().attr('id')
      var sNewComment = $(this).parent().find('.message').text()
      console.log('iMessageId:', iMessageId)
      console.log('sNewComment:', sNewComment)
      
      $.ajax({
        url: "log-api-edit-message.php",
        method: "POST",
        data: {"iMessageId": iMessageId, "sNewComment":sNewComment},
        dataType: "JSON"
      }).done(function(jData){
        console.log(jData)
      }).fail(function(uData){
        console.log('something went wrong with editing users names')
      })          
    }
  })
