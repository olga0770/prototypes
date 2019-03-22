<?php

// Validate
if( empty($_POST['txtEmail']) ||
    empty($_POST['txtPassword']) ||  
    !filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL) ||
    !(strlen($_POST['txtPassword']) >= 6 && strlen($_POST['txtPassword']) <= 20)
){
  echo '{"status":0, "message":"cannot login"}';
  exit;
}

// connect to the database
require_once '../database.php';

try{
  $sQuery = $db->prepare('
    SELECT * FROM users WHERE email = :sEmail AND 
    password = :sPassword AND 
    active = 1 LIMIT 1
  ');
  $sQuery->bindValue(':sEmail', $_POST['txtEmail']);
  $sQuery->bindValue(':sPassword', $_POST['txtPassword']);
  $sQuery->execute();
  $aUsers = $sQuery->fetchAll();
  if( count($aUsers) ){
    session_start();
    $_SESSION['jUser'] = $aUsers[0];
    echo '{"status":1, "message":"login success"}';
    exit;
  }
  echo '{"status":0, "message":"cannot login"}';

}catch(PDOException $exception){
  echo '{"status":0, "message":"exception cannot login"}';
}








