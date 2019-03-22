console.log('test')

$('#frmPost').submit(function(e){
  e.preventDefault()
  $.ajax({
    url: "apis/api-save-post.php",
    method: "POST",
    data: $(this).serialize(),
    dataType: "JSON"
  }).done(function(jData){
    console.log(jData)
    // var dtNow = new Date().getTime() // TODO: show the date for humans
    var sDivPost = `  <div id="${jData.iPostId}" class='post' >
                        <div class='message'>${$('#txtPost').val()}</div>
                        
                      </div>`
    $('#posts').prepend(sDivPost)
  }).fail(function(uData){
    console.log('something went wrong with saving posts')
  })
})



/* extra divs for sDivPost

<div class='date'>${dtNow}</div>
<div class='edit'>edit</div>
<div class='btnDelete'>delete</div>
*/



// ****************************************
$(document).on('click', '.btnDelete', function(){
  console.log('test delete')

  var oDivPostToDelete = $(this).parent()
  var iPostId = $(this).parent().attr('id')
  console.log('iPostId:', iPostId, oDivPostToDelete)

  $.ajax({
    url: "apis/api-delete-post.php",
    method: "GET",
    data: {"postId": iPostId},
    dataType: "JSON"
  }).done(function(jData){
    console.log(jData)
    if(jData.status){
      $(oDivPostToDelete).remove()
    }
  }).fail(function(uData){
    console.log('something went wrong with deleting posts')
  })

})

// ****************************************

$(document).on('click', '.btnEdit', function(){
  console.log('edit')

  if($(this).text() == 'edit'){
    $(this).parent().find('.message').attr('contenteditable', true).focus()
    $(this).text('save')
  }else{ // this is when you click save
    $(this).text('edit')
    $(this).parent().find('.message').attr('contenteditable', false)
    



    var iPostId = $(this).parent().attr('id')
    var sNewMessage = $(this).parent().find('.message').text()
    console.log('iPostId:', iPostId)
    console.log('sNewMessage:', sNewMessage)
    
    $.ajax({
      url: "apis/api-edit-post.php",
      method: "POST",
      data: {"iPostId": iPostId, "sNewMessage":sNewMessage},
      dataType: "JSON"
    }).done(function(jData){
      console.log(jData)
    }).fail(function(uData){
      console.log('something went wrong with editing posts')
    })      
    



  }

  // $(this).siblings('.message')[0].attr('contenteditable') = true
  





  // var oDivPostToDelete = $(this).parent()
  // var iPostId = $(this).parent().attr('id')
  // console.log('sPostId:', iPostId)
  // $.ajax({
  //   url: "apis/api-delete-post.php",
  //   method: "GET",
  //   data: {"postId": iPostId},
  //   dataType: "JSON"
  // }).done(function(jData){
  //   console.log(jData)
  //   if(jData.status){
  //     $(oDivPostToDelete).remove()
  //   }
  // }).fail(function(uData){
  //   console.log('something went wrong')
  // })  
})
