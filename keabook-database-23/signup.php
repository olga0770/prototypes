<?php
  $sTitle = 'keabook : : signup';
  $sCss = 'signup.css';
  require_once './components/top.php';
?>


<div class="container">

  <div class="top">
    keabook
  </div>


  <div class="content">
    <form id="frmSignup">
      <h1>Signup</h1>
      <input name="txtName" class="mt20" type="text" value="aa" placeholder="name ( 2 to 20 characters )">
      <input name="txtLastName" class="mt10" type="text" value="bb" placeholder="last name ( 2 to 20 characters )">
      <input name="txtEmail" class="mt10" type="text" value="a@a.com" placeholder="email">
      <input name="txtPassword" class="mt10" type="password" value="123456" placeholder="password ( 6 to 20 characters )">
      <input name="txtPasswordConfirm" class="mt10" type="password" value="123456" placeholder="confirm password">
      <button id="btnSignup" type="submit" class="ok mt10">signup</button>
    </form>
  </div>


</div>




<?php
  $sScript = 'signup.js';
  require_once './components/bottom.php';