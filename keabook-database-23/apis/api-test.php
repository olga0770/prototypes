<?php

$sTheEmail = "a@a.comfgfgf";
$sThePassword = "A1b2c3";

// connect to the database
require_once '../database.php';
try{
  $sQuery = $db->prepare('
    SELECT * FROM users WHERE email = :sEmail AND 
    password = :sPassword AND 
    active = 1 LIMIT 1
  ');
  $sQuery->bindValue(':sEmail', $sTheEmail);
  $sQuery->bindValue(':sPassword', $sThePassword);
  $sQuery->execute();
  $aUsers = $sQuery->fetchAll();
  echo json_encode($aUsers);
  
}catch(PDOException $exception){
  echo '{"status":0, "message":"cannot login"}';
}








