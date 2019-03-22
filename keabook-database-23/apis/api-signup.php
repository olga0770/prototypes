<?php

  if( empty($_POST['txtName']) ||
      empty($_POST['txtLastName']) ||
      empty($_POST['txtEmail']) ||
      empty($_POST['txtPassword']) ||
      empty($_POST['txtPasswordConfirm']) ||
      !(strlen($_POST['txtName']) >= 2 && strlen($_POST['txtName']) <= 20) ||
      !(strlen($_POST['txtLastName']) >= 2 && strlen($_POST['txtLastName']) <= 20) ||
      !filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL) ||
      !(strlen($_POST['txtPassword']) >= 6 && strlen($_POST['txtPassword']) <= 20) ||
      !($_POST['txtPassword'] == $_POST['txtPasswordConfirm'])
  ){
    echo '{"status":0, "message":"******************"}';
    exit;
  }

  require_once '../database.php';
  try{

    $sActivationKey = password_hash(uniqid(), PASSWORD_DEFAULT);

    $sQuery = $db->prepare('INSERT INTO users
                            VALUES (null, :sName, :sLastName, 
                            :sEmail, :sPassword, :bActive, :sActivationKey)');

    $sQuery->bindValue(':sName', $_POST['txtName']);
    $sQuery->bindValue(':sLastName', $_POST['txtLastName']);
    $sQuery->bindValue(':sEmail', $_POST['txtEmail']);
    $sQuery->bindValue(':sPassword', $_POST['txtPassword']);
    $sQuery->bindValue(':bActive', 0);
    $sQuery->bindValue(':sActivationKey', $sActivationKey);
    $sQuery->execute();
    if( $sQuery->rowCount() ){
      echo '{"status":1, "message":"success"}';
      exit;
    }
    echo '{"status":0, "message":"error"}';
  }catch( PDOException $e ){
    echo '{"status":0, "message":"error", "code":"001", "line":'.__LINE__.'}';
  }

