<?php

// CHECK THAT THE USER IS LOGGED


// TODO: Validate if the id of the post is a valid id
// filter validate int

// $_GET['postId'] = 2;

require_once '../database.php';
try{
  


  $sQuery = $db->prepare('DELETE 
                          FROM posts 
                          WHERE id = :iPostId');
  
  $sQuery->bindValue(':iPostId', $_GET['postId']);
  file_put_contents('log.txt', "1\n", FILE_APPEND );

  // $sQuery->bindValue(':iUserId', $_SESSION['jUser']['id']);
  // file_put_contents('log.txt', "2\n", FILE_APPEND );

  $sQuery->execute();
  file_put_contents('log.txt', "3\n", FILE_APPEND );

  if( !$sQuery->rowCount() ){
    echo '{"status":0, "message":"could not delete post"}';
    file_put_contents('log.txt', "4\n", FILE_APPEND );
    exit;
  }
  echo '{"status":1, "message":"post deleted"}';
  file_put_contents('log.txt', "5\n", FILE_APPEND );


}catch(PDOException $ex){
  echo '{"status":0, "message":"exception"}';
  file_put_contents('log.txt', $ex, FILE_APPEND );

}