<?php
$sTitle = 'Room reservation code';
$sCss = 'main.css';
require_once './components/top.php';


session_start();
if( !$_SESSION['jUser'] ){
  header('Location: customer-login.php');
  exit;
}else{
  echo "<img src='img/customer-icon.png' alt='admin' height='30' width='30'>
  <span>Welcome ".$_SESSION['jUser']['first_name']."!</span>
  <a href='customer-logout.php'> Logout</a><hr>";
}



?>
<h2>Room reservation code</h2><hr>
<a href="index.php">Back to search</a>
<hr>

<?php
require_once 'database.php';



try{
    $sQuery = $db->prepare("SELECT id , code FROM reservations WHERE id = :reservationId");
    $sQuery->bindValue(':reservationId', $_SESSION['reservations']);

    $sQuery->execute();
    $aReservations = $sQuery->fetchAll();

        foreach($aReservations as $aReservation){
            echo   "<h2>Congratulations! You successfully reserved the room!</h2><br>
                    <h3>Your reservation code:</h3><h1>".$aReservation['code']."</h1>";
        }

}catch(PDOException $exc){
    echo '{"status":0, "message":"reservation exception"}';
    }