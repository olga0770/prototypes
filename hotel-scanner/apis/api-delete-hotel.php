<?php
require_once '../database.php';
$db->beginTransaction();
try{
    $sQuery = $db->prepare('DELETE 
                          FROM hotels 
                          WHERE id = :iHotelId');
  
  $sQuery->bindValue(':iHotelId', $_GET['hotelId']);

  $sQuery->execute();
  $db->commit();

  if( !$sQuery->rowCount() ){
    echo '{"status":0, "message":"could not delete hotel"}';
    exit;
  }
  echo '{"status":1, "message":"hotel deleted"}';


}catch(PDOException $ex){
  echo '{"status":0, "message":"exception"}';
  $db->rollBack();


}