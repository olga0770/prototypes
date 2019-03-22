<?php
$sTitle = 'Add room';
$sCss = 'main.css';
require_once './components/top.php';
?>

<a href="rooms.php?hotelId=<?php echo $_GET['hotelId']; ?>">Back to rooms</a>
<hr>

<h2>Add room</h2><hr>
<form method="post" action="room-add.php?hotelId=<?php echo $_GET['hotelId']; ?>"
      enctype="multipart/form-data">

<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Room Image: </label><input type="file" name="document"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Room Type: </label><input name="txtRoomType" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Bed Type: </label><input name="txtBedType" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Person Count: </label><input name="intPersonCount" type="number"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Safe Box: </label><input name="intSafeBox" type="number"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Minibar: </label><input name="intMinibar" type="number"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Price: </label><input name="price" type="number"/></p>
<input type="submit" value="Add Room"/>
</form>

<?php
require_once 'database.php';
require_once 'database-sqlite.php';

  if(
  !empty($_POST['document']) || 
  !empty($_POST['txtRoomType']) ||
  !empty($_POST['txtBedType']) ||
  !empty($_POST['intPersonCount']) ||
  !empty($_POST['intSafeBox']) ||
  !empty($_POST['intMinibar']) ||
  !empty($_POST['price'])
){

$sHotelIdFk = $_GET['hotelId'];
$sRoomType = $_POST['txtRoomType'];
$sBedType = $_POST['txtBedType'];
$sPersonCount = $_POST['intPersonCount'];
$sSafeBox = $_POST['intSafeBox'];
$sMinibar = $_POST['intMinibar'];
$sPrice = $_POST['price'];

    if (isset($_FILES['document']) &&
    ($_FILES['document']['error'] == UPLOAD_ERR_OK)) {

        $newPath = "/" . basename($_FILES['document']['name']);
        if (move_uploaded_file($_FILES['document']['tmp_name'], $newPath)) {
            print "File saved in $newPath";
            $binaryContent = file_get_contents($newPath);

        $db->beginTransaction();
        try{
            $sQuery = $db->prepare("INSERT INTO rooms 
            (hotel_id_fk, image, room_type, bed_type, person_count, safe_box, minibar, price) 
            VALUES (:sHotelIdFk, :binData, :sRoomType, :sBedType, :sPersonCount, :sSafeBox, :sMinibar, :sPrice)");
                     
            $sQuery->bindValue(':sHotelIdFk', $sHotelIdFk);
            $sQuery->bindValue(':binData', $binaryContent);
            $sQuery->bindValue(':sRoomType', $sRoomType);
            $sQuery->bindValue(':sBedType', $sBedType);
            $sQuery->bindValue(':sPersonCount', $sPersonCount);
            $sQuery->bindValue(':sSafeBox', $sSafeBox);
            $sQuery->bindValue(':sMinibar', $sMinibar);
            $sQuery->bindValue(':sPrice', $sPrice);

            $sQuery->execute();
            $db->commit();
            $db->lastInsertId();
                    
            if( $sQuery->rowCount() ){
            echo '{"status":1, "message":"success"}';

            // SQLite log
            _loglite('New room has been added to the list');

            exit;
            }
            echo '{"status":0, "message":"error"}';

            }catch( PDOException $e ){
                echo '{"status":0, "message":"error", "code":"001", "line":'.__LINE__.'}';
                $db->rollBack();
            }          
        }else{
            print "Couldn't move file to $newPath";
        }
    }else{
        print "No valid file uploaded.";
        
        // SQLite log
        _loglite('You have a problem with adding a new room to the list');

    }
} 



