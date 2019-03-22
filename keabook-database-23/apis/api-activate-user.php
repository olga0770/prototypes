<?php

// TODO: maybe validate also based on the length of the key
if(empty($_GET['key'])){
  echo '{"status":0,"message":"cannot validate","code":"001"}';
  exit;
}

require_once '../database.php';

try{

  $sQuery = $db->prepare('  UPDATE users
                            SET active = 1
                            WHERE activation_key = :sKey
                        '); 
  $sQuery->bindValue(':sKey', $_GET['key']);
  $sQuery->execute();

  if( $sQuery->rowCount() ){
    echo '{"status":1, "message":"you are activated"}';
    exit;
  }  

  echo '{"status":0, "message":"you could not be activated"}';
  
}catch(PDOException $ex){
  echo '{"status":0,"message":"cannot activate user","code":"1001"}';
}










