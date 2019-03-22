$(document).on('click', '.btnDelete', function(){
    console.log('test delete')
  
    var oDivHotelToShow = $(this).parent()
    var iHotelId = $(this).parent().attr('id')
    console.log('iHotelId:', iHotelId, oDivHotelToShow)
  
    $.ajax({
      url: "apis/api-delete-hotel.php",
      method: "GET",
      data: {"hotelId": iHotelId},
      dataType: "JSON"
    }).done(function(jData){
      console.log(jData)
      if(jData.status){
        $(oDivHotelToShow).remove()
      }
    }).fail(function(uData){
      console.log('something went wrong with deleting hotel')
    })
  
  })



// ***********EDIT HOTEL*****************************

$(document).on('click', '.btnEdit', function(){
    console.log('edit')
  
    if($(this).text() == 'Start editing'){
      $(this).parent().find('.hotelName').attr('contenteditable', true).focus()
      $(this).parent().find('.address').attr('contenteditable', true).focus()
      $(this).parent().find('.city').attr('contenteditable', true).focus()
      $(this).parent().find('.country').attr('contenteditable', true).focus()
      $(this).parent().find('.postcode').attr('contenteditable', true).focus()
      $(this).parent().find('.region').attr('contenteditable', true).focus()
      $(this).parent().find('.stars').attr('contenteditable', true).focus()
      $(this).parent().find('.description').attr('contenteditable', true).focus()
      $(this).parent().find('.checkIn').attr('contenteditable', true).focus()
      $(this).parent().find('.checkOut').attr('contenteditable', true).focus()

      $(this).text('Save')
    }else{ // this is when you click save
      $(this).text('Start editing')
      $(this).parent().find('.hotelName').attr('contenteditable', false)
      $(this).parent().find('.address').attr('contenteditable', false)
      $(this).parent().find('.city').attr('contenteditable', false)
      $(this).parent().find('.country').attr('contenteditable', false)
      $(this).parent().find('.postcode').attr('contenteditable', false)
      $(this).parent().find('.region').attr('contenteditable', false)
      $(this).parent().find('.stars').attr('contenteditable', false)
      $(this).parent().find('.description').attr('contenteditable',false)
      $(this).parent().find('.checkIn').attr('contenteditable', false)
      $(this).parent().find('.checkOut').attr('contenteditable', false)
      
    var iHotelId = $(this).parent().attr('id')
    var sNewHotelName = $(this).parent().find('.hotelName').text()
    var sNewAddress = $(this).parent().find('.address').text()
    var sNewCity = $(this).parent().find('.city').text()
    var sNewCountry = $(this).parent().find('.country').text()
    var sNewPostcode = $(this).parent().find('.postcode').text()
    var sNewRegion = $(this).parent().find('.region').text()
    var sNewStars = $(this).parent().find('.stars').text()
    var sNewDescription = $(this).parent().find('.description').text()
    var sNewCheckIn = $(this).parent().find('.checkIn').text()
    var sNewCheckOut = $(this).parent().find('.checkOut').text()    

    console.log('ihotelId:', iHotelId)
    console.log('sNewHotelName:', sNewHotelName)

    $.ajax({
        url: "apis/api-edit-hotel.php",
        method: "POST",
        data: {"iHotelId":iHotelId, "sNewHotelName":sNewHotelName, "sNewAddress":sNewAddress, "sNewCity":sNewCity, "sNewCountry":sNewCountry, "sNewPostcode":sNewPostcode, "sNewRegion":sNewRegion, "sNewStars":sNewStars, "sNewDescription":sNewDescription, "sNewCheckIn":sNewCheckIn, "sNewCheckOut":sNewCheckOut},
        dataType: "JSON"
      }).done(function(jData){
        console.log(jData)
      }).fail(function(uData){
        console.log('something went wrong with editing hotel')
      })      
        
    }


})

