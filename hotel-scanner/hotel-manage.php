<?php
$sTitle = 'Manage hotels';
$sCss = 'main.css';
require_once './components/top.php';
?>
<h2>Manage hotels</h2><hr>

<?php
require_once 'database.php';
  try{

    $sQuery = $db->prepare('SELECT count(name) AS number_of_hotels FROM hotels');
    $sQuery->execute();
    $iHotelsCount = $sQuery->fetchAll();

    foreach($iHotelsCount as $iHotelCount){
    echo "<h3>Number of hotels: ".$iHotelCount['number_of_hotels']."</h3>";
    }

    $sQuery = $db->prepare('SELECT * FROM hotels order by id desc');
    $sQuery->execute();
    $aHotels = $sQuery->fetchAll();
    foreach($aHotels as $aHotel){

      echo  "<div class='hotelInfo' id='".$aHotel['id']."' class='post'>
      <div><img src='data:image/jpeg;base64,". base64_encode($aHotel['hotel_image']) ."' height='120' width='120' style='margin-top: 25px'/></div>
      <div>
      <h3 class='hotelName' contenteditable='false'>".$aHotel['name']."</h3>
      <span style='display: inline-block; width: 90px;'><b>Address:</b> </span><span class='address' contenteditable='false'>".$aHotel['address']."</span><br>
      <span style='display: inline-block; width: 90px;'><b>City:</b> </span><span class='city' contenteditable='false'>".$aHotel['city']."</span><br>
      <span style='display: inline-block; width: 90px;'><b>Country:</b> </span><span class='country' contenteditable='false'>".$aHotel['country']."</span><br>
      <span style='display: inline-block; width: 90px;'><b>Postcode:</b> </span><span class='postcode' contenteditable='false'>".$aHotel['postcode']."</span><br>
      <span style='display: inline-block; width: 90px;'><b>Region:</b> </span><span class='region' contenteditable='false'>".$aHotel['region']."</span><br>
      <span style='display: inline-block; width: 90px;'><b>Stars:</b> </span><span class='stars' contenteditable='false'>".$aHotel['stars']."*</span><br>
      <span style='display: inline-block; width: 90px;'><b>Description:</b> </span><span class='description' contenteditable='false'>".$aHotel['description']."</span><br>
      <span style='display: inline-block; width: 90px;'><b>Check In:</b> </span><span class='checkIn' contenteditable='false'>".$aHotel['check_in']."</span><br>
      <span style='display: inline-block; width: 90px;'><b>Check Out:</b> </span><span class='checkOut' contenteditable='false'>".$aHotel['check_out']."</span><br><br>
      </div>    
      <button class='btnDelete'>Delete</button>
      <button class='btnEdit'>Edit</button>
      <h4><a href='rooms.php?hotelId=".$aHotel['id']."'>Show Rooms</a></h4>                                                                            
      </div>
      <hr>";
    }

    }catch(PDOException $ex){
        echo "Sorry, system is updating ...";
      }

  $sScript = 'hotel-manage.js';
  require_once './components/bottom.php';


