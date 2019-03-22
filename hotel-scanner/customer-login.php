<?php
  // session_start();
  // if($_SESSION['jUser']){
  //   header('Location: home.php');
  // }
  $sTitle = 'Account';
  $sCss = 'login.css';
  require_once './components/top.php';
?>

  <div class="content">
    <form id="frmLogin">
      <h2>Login</h2>
      <input id="txtEmail" name="txtEmail" class="mt10" type="text" value="a@a.com" placeholder="email">
      <input id="txtPassword" name="txtPassword" class="mt10" type="text" value="123456" placeholder="password ( 6 to 20 characters )" maxlength="20">
      <button id="btnLogin" type="submit" class="ok mt10">login</button>
    </form>
  </div>

<?php
  $sScript = 'customer-login.js';
  require_once './components/bottom.php';