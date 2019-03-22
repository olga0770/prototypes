<?php
session_start();

$sTitle = 'My reservations';
$sCss = 'main.css';
require_once './components/top.php';

if( !$_SESSION['jUser'] ){
  header('Location: customer-login.php');
  exit;
}else{
  echo "<img src='img/customer-icon.png' alt='admin' height='30' width='30'><span>Welcome ".$_SESSION['jUser']['first_name']."! </span><a href='customer-logout.php'> Logout</a><hr>";
}
?>

<h2>My reservations</h2><hr>


<?php
require_once 'database.php';
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
    try{
        // $sQuery = $db->prepare("SELECT * FROM v_booking");

        $sQuery = $db->prepare("select c.email, r.check_in, r.check_out, r.code, 
        rm.room_type, rm.price, rm.id AS room_id, h.name, h.stars, h.address, 
        DATEDIFF(r.check_out, r.check_in) as nights, rm.price*DATEDIFF(r.check_out, r.check_in) as total 
        from reservation_room_relation as rrr
        join reservations as r on r.id = rrr.reservation_id_fk
        join customers as c on c.id = r.customer_id_fk
        join rooms as rm on rm.id = rrr.room_id_fk
        join hotels as h on h.id = rm.hotel_id_fk
        ");

        $sQuery->execute();
        $aReservations = $sQuery->fetchAll();
        foreach($aReservations as $aReservation){
          if($_SESSION['jUser']['email'] == $aReservation['email']){
            echo
            "<h3><span><b>Reservation Code:</b> </span><span>".$aReservation['code']."</span></h3>
            <span style='display: inline-block; width: 115px;'><b>Check In:</b> </span><span>".$aReservation['check_in']."</span><br>
            <span style='display: inline-block; width: 115px;'><b>Check Out:</b> </span><span>".$aReservation['check_out']."</span><br>
            <span style='display: inline-block; width: 115px;'><b>Nights:</b> </span><span>".$aReservation['nights']."</span><br>
            <span style='display: inline-block; width: 115px;'><b>Room ID:</b> </span><span>".$aReservation['room_id']."</span><br>
            <span style='display: inline-block; width: 115px;'><b>Room Type:</b> </span><span>".$aReservation['room_type']."</span><br>
            <span style='display: inline-block; width: 115px;'><b>Room Price:</b> </span><span>".$aReservation['price']."&euro;</span><br>
            <span style='display: inline-block; width: 115px;'><b>Hotel:</b> </span><span>".$aReservation['name']."</span><br>
            <span style='display: inline-block; width: 115px;'><b>Hotel Stars:</b> </span><span>".$aReservation['stars']."*</span><br>
            <span style='display: inline-block; width: 115px;'><b>Hotel Address:</b> </span><span>".$aReservation['address']."</span><br>
            <h3><span><b>Total amount:</b> </span><span>".$aReservation['total']."&euro;</span></h3>
            <hr>
            ";
        }
      }
    }catch(PDOException $ex){
        echo "Sorry, system is updating ...";
      }
  ?>

<hr>
<form action="index.php">
<input type="submit" value="Back to hotel search">
</form>
<!-- <h2>My reviews</h2><hr> -->

<?php
// Mongo DB
// try{
//   $collectionReviews = $client->selectCollection('hotel-reviews', 'reviews');    
//   $ajReviews = $collectionReviews->find();
//   foreach($ajReviews as $jReview){
//       if($_SESSION['jUser']['id'] == $jReview["customer_id"]){
//         echo  "<div id='".$jReview["_id"]."'>
//         <span><b>Evaluation:</b> </span><span class='evaluation' contenteditable='false'>".$jReview["evaluation"]."</span><br>
//         <span><b>Review:</b> </span><span class='review' contenteditable='false'>".$jReview["text"]."</span><br>
//         <span><b>Date:</b> </span><span>".$jReview["date"]->toDateTime()->format("d M Y")."</span><br>  
//         <button class='btnDelete'>Delete</button>
//         <button class='btnEdit'>Edit</button>                                        
//         </div>
//         <hr>"; 
//       }
//   }    
//   }catch(MongoException $e){
//       echo "error message: ".$e->getMessage()."\n";
//       echo "error code: ".$e->getCode()."\n"; 
//   }

$sScript = 'mongo-review-crud.js';
require_once './components/bottom.php';


