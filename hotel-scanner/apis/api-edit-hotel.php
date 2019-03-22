<?php
require_once '../database.php';
$db->beginTransaction();
try{

    $sQuery = $db->prepare('UPDATE hotels 
                          SET name = :sHotelName, address = :sAddress, city = :sCity, country = :sCountry,
                          postcode = :sPostcode, region = :sRegion, stars = :sStars, description = :sDescription, 
                          check_in = :sCheck_in, check_out = :sCheck_out
                          WHERE id = :iHotelId');

    $sQuery->bindValue(':iHotelId', $_POST['iHotelId']);
    $sQuery->bindValue(':sHotelName', $_POST['sNewHotelName']);
    $sQuery->bindValue(':sAddress', $_POST['sNewAddress']);
    $sQuery->bindValue(':sCity', $_POST['sNewCity']);
    $sQuery->bindValue(':sCountry', $_POST['sNewCountry']);
    $sQuery->bindValue(':sPostcode', $_POST['sNewPostcode']);
    $sQuery->bindValue(':sRegion', $_POST['sNewRegion']);
    $sQuery->bindValue(':sStars', $_POST['sNewStars']);
    $sQuery->bindValue(':sDescription', $_POST['sNewDescription']);
    $sQuery->bindValue(':sCheck_in', $_POST['sNewCheckIn']);
    $sQuery->bindValue(':sCheck_out', $_POST['sNewCheckOut']);


    $sQuery->execute();
    $db->commit();
    if( !$sQuery->rowCount() ){
    echo '{"status":0, "message":"could not insert data"}';
    exit;
    }
    echo '{"status":1, "message":"hotel updated"}';

}catch(PDOException $ex){
    echo '{"status":0, "message":"exception"}';
    $db->rollBack();

}





