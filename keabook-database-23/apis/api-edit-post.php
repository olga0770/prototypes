<?php


// Validate
// TODO: validate iPostId and sNewMessage

session_start();
require_once '../database.php';


// $sQuery = $db->prepare('UPDATE posts 
// SET message = :sMessage 
// WHERE id = :iPostId
// AND user_id = :iUserId');



try{

  $sQuery = $db->prepare('UPDATE posts 
                          SET message = :sMessage 
                          WHERE id = :iPostId');
  
  $sQuery->bindValue(':sMessage', $_POST['sNewMessage']);
  $sQuery->bindValue(':iPostId', $_POST['iPostId']);
  // $sQuery->bindValue(':iUserId', $_SESSION['jUser']['id']);
  $sQuery->execute();
  if( !$sQuery->rowCount() ){
    echo '{"status":0, "message":"could not insert data"}';
    exit;
  }
  // How to get the inserted id
  echo '{"status":1, "message":"post updated"}';

}catch(PDOException $ex){
  echo '{"status":0, "message":"exception"}';
}





