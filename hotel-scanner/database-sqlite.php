<?php

try{
    $db_lite = new PDO ('sqlite:log.db');
    $db_lite -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch( PDOException $e){
    echo '{"status":"err","message":"cannot connect to database"}';
    exit();
  }


  function _loglite($msg) {
    global $db_lite;
    $sQuery1 = $db_lite->prepare("INSERT INTO log (message) VALUES (?)");  
    $sQuery1->bindValue(1, $msg);
    $sQuery1->execute();
}


