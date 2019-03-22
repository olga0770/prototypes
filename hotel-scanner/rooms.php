<?php
$sTitle = 'Rooms';
$sCss = 'main.css';
require_once './components/top.php';
?>
<h2>Rooms</h2><hr>

<?php
require_once 'database.php';
try{
    $sQuery = $db->prepare('SELECT * FROM hotels WHERE id = :iHotelId');
    $sQuery->bindValue(':iHotelId', $_GET['hotelId']);
    $sQuery->execute();
    $aHotels = $sQuery->fetchAll();

    foreach($aHotels as $aHotel){

        echo  "<div id='".$aHotel['id']."' class='post'>
        <h3 class='hotelName' contenteditable='false'>".$aHotel['name']."</h3>
        </div>
        <h4><a href='room-add.php?hotelId=".$aHotel['id']."'>Add rooms</a></h4>";
      }

      $sQuery = $db->prepare('SELECT * FROM rooms WHERE hotel_id_fk = :iHotelId');
      $sQuery->bindValue(':iHotelId', $_GET['hotelId']);
      $sQuery->execute();
      $aRooms = $sQuery->fetchAll();
  
      foreach($aRooms as $aRoom){
  
          echo  "<div div class='hotelInfo' id='".$aRoom['id']."' class='post'>
          <div><img src='data:image/jpeg;base64,". base64_encode($aRoom['image']) ."' height='120' width='120' /></div>
          <div>
          <span style='display: inline-block; width: 105px;'><b>Room ID:</b> </span><span>".$aRoom['id']."</span><br>
          <span style='display: inline-block; width: 105px;'><b>Room Type:</b> </span><span>".$aRoom['room_type']."</span><br>
          <span style='display: inline-block; width: 105px;'><b>Bed Type:</b> </span><span>".$aRoom['bed_type']."</span><br>
          <span style='display: inline-block; width: 105px;'><b>Person Count:</b> </span><span>".$aRoom['person_count']."</span><br>
          <span style='display: inline-block; width: 105px;'><b>Safe Box:</b> </span><span>".($aRoom['safe_box'] == 1 ? "yes" : "no")."</span><br>
          <span style='display: inline-block; width: 105px;'><b>Minibar:</b> </span><span>".($aRoom['minibar'] == 1 ? "yes" : "no")."</span><br>
          <span style='display: inline-block; width: 105px;'><b>Price:</b> </span><span>".$aRoom['price']."&euro;</span><br></div>                                        
          </div>
          <hr>";
        }


}catch(PDOException $ex){
    echo '{"status":0, "message":"exception"}';
}

