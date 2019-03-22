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

file_put_contents('log.txt', "1-validate\n", FILE_APPEND );

require_once '../database.php';
try{
  $sQuery = $db->prepare('SELECT * FROM customers WHERE email = :sEmail 
    AND password = :sPassword 
    AND status = 1 LIMIT 1');

file_put_contents('log.txt', "2-prepare\n", FILE_APPEND );

  $sQuery->bindValue(':sEmail', $_POST['txtEmail']);
  $sQuery->bindValue(':sPassword', hash("sha256", $_POST['txtPassword']));
  $sQuery->execute();
  $aUsers = $sQuery->fetchAll();

  file_put_contents('log.txt', "3-bind\n", FILE_APPEND );

  if( count($aUsers) ){
    session_start();
    $_SESSION['jUser'] = $aUsers[0];
    echo '{"status":1, "message":"login success"}';

    file_put_contents('log.txt', "4-session\n", FILE_APPEND );
    exit;
  }
  echo '{"status":0, "message":"cannot login"}';

}catch(PDOException $exception){
  echo '{"status":0, "message":"exception cannot login"}';

  file_put_contents('log.txt', "5-exception\n", FILE_APPEND );
}








