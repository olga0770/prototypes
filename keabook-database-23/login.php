<?php

  // Check if user is logged
  session_start();
  if($_SESSION['jUser']){
    header('Location: home.php');
  }


  $sTitle = 'keabook : : login';
  $sCss = 'login.css';
  require_once './components/top.php';
?>




<div class="container">

  <div class="top">
    keabook
  </div>


  <div class="content">
    <form id="frmLogin">
      <h1>Login</h1>
      


      
      <div class="boxInput">
        <div id="invalidEmail" class="invalid">invalid email</div>
        <input id="txtEmail" name="txtEmail" class="mt10" type="text" value="a@a.com" placeholder="email">
      </div>
      


    
      <div class="boxInput">
      <div id="invalidPassword" class="invalid">invalid password</div>
        <input id="txtPassword" name="txtPassword" class="mt10" type="text" value="A1b2c3" placeholder="password ( 6 to 20 characters )" maxlength="20">
      </div>
      
      
      <button id="btnLogin" type="submit" class="ok mt10">login</button>
    </form>
  </div>


</div>



<?php
  $sScript = 'login.js';
  require_once './components/bottom.php';