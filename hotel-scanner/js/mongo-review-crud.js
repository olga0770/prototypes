// insert

$('#frmReview').submit(function(e){
console.log('mongo')
    e.preventDefault()
    $.ajax({
      url: "mongo-api-review-add.php",
      method: "POST",
      data: $('#frmReview').serialize(),
      dataType: "JSON"
    }).always(function(jData){
      console.log("Review has been added successfully " + jData)
      return 
    })
  })



// insert2

$('#frmInsertReview').submit(function(e){
  console.log('mongo')
      e.preventDefault()
      $.ajax({
        url: "mongo-api-review-add2.php",
        method: "POST",
        data: $('#frmInsertReview').serialize(),
        dataType: "JSON"
      }).always(function(jData){
        console.log("Review has been added successfully " + jData)
        swal("Good job!", "Review has been added successfully!", "success");
        return 
      })
    })




  // delete

  $(document).on('click', '.btnDelete', function(){
    console.log('test delete')
  
    var oDivReviewToDelete = $(this).parent()
    var iReviewId = $(this).parent().attr('id')
    console.log('iReviewId:', iReviewId, oDivReviewToDelete)

    $.get( "mongo-api-review-delete.php", {"iReviewId":iReviewId})
    .done(function( data ) {
      console.log( "Review deleted successfully " + data );
      swal("Deleted!", "Review has been deleted successfully!", "warning");
    });      
  })


  // edit

  $(document).on('click', '.btnEdit', function(){
    console.log('edit')
  
    if($(this).text() == 'Edit'){
      $(this).parent().find('.evaluation').attr('contenteditable', true).focus()
      $(this).parent().find('.review').attr('contenteditable', true).focus()
      $(this).text('Save')

    }else{
      $(this).text('Edit')
      $(this).parent().find('.evaluation').attr('contenteditable', false)
      $(this).parent().find('.review').attr('contenteditable', false)
      swal("Good job!", "Review has been edited successfully!", "success");
      
      var iReviewId = $(this).parent().attr('id')
      var iNewEvaluation = $(this).parent().find('.evaluation').text()
      var sNewReview = $(this).parent().find('.review').text()
      console.log('iReviewId to update:', iReviewId)
      console.log('iNewEvaluation:', iNewEvaluation)
      console.log('sNewReview:', sNewReview)

      $.post( "mongo-api-review-edit.php", {"iReviewId":iReviewId, "iNewEvaluation":iNewEvaluation, "sNewReview":sNewReview})
        .done(function( data ) {
          console.log( "Review updated successfully " + data );
        });      
    }
  })

