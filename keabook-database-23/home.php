<?php

// check if the user is logged
// not logged, take the user to the login page
session_start();
if( !$_SESSION['jUser'] ){
  header('Location: login.php');
  exit;
}
else{
  echo "<p class='welcome'>welcome ".$_SESSION['jUser']['email']."</p>";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>keabook : : home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/home.css">
</head>
<body>
  

<div class="container">

  <div class="top">
    <div id="logo">keabook</div>
    <div>friends</div>
    <div><a href="logout.php">logout</a></div>
  </div>


  <div class="content">

    <form id="frmPost">
      <input id="txtPost" type="text" placeholder="what is in your mind?" name="txtPost">
      <button class="ok mt10">post</button>
    </form>

    <div id="posts">
      <?php
      require_once 'database.php';
      try{
        $sQuery = $db->prepare('SELECT * FROM posts');
        $sQuery->execute();
        // Array
        $aPosts = $sQuery->fetchAll();
        foreach($aPosts as $aPost){

          $sEditAndDelete = '';
          if( $aPost['user_id'] == $_SESSION['jUser']['id'] ){
            $sEditAndDelete = "<div class='btnEdit'>edit</div><div class='btnDelete'>delete</div>";
          }
          
          echo "  <div id='".$aPost['id']."' class='post'>
                    <div class='message' contenteditable='false'>".$aPost['message']."</div>
                    <div class='date'>".$aPost['date']."</div>
                    ".$sEditAndDelete."                                        
                  </div>";
          }


      }catch(PDOException $ex){
        echo "Sorry, system is updating ...";
      }

      ?>
    </div>
   

  </div>

</div>


<?php
  $sScript = 'home.js';
  require_once './components/bottom.php';


