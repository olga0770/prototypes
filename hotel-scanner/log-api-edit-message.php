<?php
require_once 'database-sqlite.php';
try{

  $sQuery = $db_lite->prepare('UPDATE log 
                          SET comment = :sComment 
                          WHERE id = :iMessageId');
  
  $sQuery->bindValue(':sComment', $_POST['sNewComment']);
  $sQuery->bindValue(':iMessageId', $_POST['iMessageId']);
  $sQuery->execute();
  if( !$sQuery->rowCount() ){
    echo '{"status":0, "message":"could not edit log"}';
    exit;
  }
  echo '{"status":1, "message":"user updated"}';

}catch(PDOException $ex){
  echo '{"status":0, "message":"exception"}';
}





