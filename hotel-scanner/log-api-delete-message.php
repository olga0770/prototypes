<?php
require_once 'database-sqlite.php';
try{
    $sQuery = $db_lite->prepare('DELETE 
                          FROM log 
                          WHERE id = :iHotelId');
  
  $sQuery->bindValue(':iHotelId', $_GET['iMessageId']);
  $sQuery->execute();

  if( !$sQuery->rowCount() ){
    echo '{"status":0, "message":"could not delete log message"}';
    exit;
  }
  echo '{"status":1, "message":"log message has been deleted"}';

}catch(PDOException $ex){
  echo '{"status":0, "message":"exception"}';
}

