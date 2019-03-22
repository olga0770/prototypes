<?php

// CHECK THAT THE USER IS LOGGED

// Validate
// TODO: Check also for min and max

// $_POST['txtPost'] = 'xxxxxx';

if( empty($_POST['txtPost']) ){
  echo '{"status":0, "message":"invalid data"}';
  exit;
}


session_start();
require_once '../database.php';

try{

$sQuery = $db->prepare('INSERT INTO `posts` (`id`, `user_id`, `message`) 
VALUES (NULL, :iUserId, :sPost)');

  //$sQuery = $db->prepare('INSERT INTO posts VALUES (null, :iUserId, :sPost, null)');
  $sQuery->bindValue(':iUserId', $_SESSION['jUser']['id']);
  $sQuery->bindValue(':sPost', $_POST['txtPost']);
  $sQuery->execute();
  if( !$sQuery->rowCount() ){
    echo '{"status":0, "message":"could not insert data"}';
    exit;
  }
  // How to get the inserted id
  $iPostId = $db->lastInsertId();
  echo '{"status":1, "message":"post success", "iPostId":'.$iPostId.'}';

}catch(PDOException $ex){
  echo '{"status":0, "message":"exception"}';
}





