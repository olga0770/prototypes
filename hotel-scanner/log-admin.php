<?php
$sTitle = 'Log admin';
$sCss = 'main.css';
require_once './components/top.php';
?>
<h2>Log admin</h2><hr>
<div class="log">
<h4>ID</h4>
<h4>Message</h4>
<h4>Time</h4>
<h4> Comment</h4>
<h4>Add comment</h4>
<h4>Delete</h4>
</div>
<hr>

<?php
require_once './components/top.php';
require_once 'database-sqlite.php';
try{
    $rows = $db_lite->query( 'SELECT * FROM log' );

    foreach($rows as $row){
        echo 
        "
        <div class='log' id='".$row['id']."'>
        <p>".$row['id']."</p>
        <p>".$row['message']."</p>
        <p>".$row['time']."</p>
        <p class='message' contenteditable='false'>".$row['comment']."</p>
        <button class='btnEdit'>Add comment</button>
        <button class='btnDelete'>Delete</button>
        </div>    
        <hr>";
    }
    
}catch( PDOException $e){
    echo '{"status":0, "message":"error", "code":"001", "line":'.__LINE__.'}';
    exit();
  }

  $sScript = 'log-edit-delete.js';
  require_once './components/bottom.php';








