<?php
$sTitle = 'Room booking';
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
<h2>Room booking</h2><hr>
<a href="index.php">Back to search</a>
<hr>

<?php
require_once 'database.php';

if (!empty($_POST['roomId']) ||
    !empty($_POST['checkIn']) ||
    !empty($_POST['checkOut']) ||
    !empty($_POST['customerId'])){


    // generates random 6-digit code
    function generateReservationCode($length){
    $random = '';
        for ($i = 0; $i < $length; $i++) {
        $random .= chr(rand(ord('A'), ord('Z')));
        }
        return $random;    
    }      
    $reservationCode = generateReservationCode(6);



    $db->beginTransaction();
    try{
        $sQuery = $db->prepare("INSERT INTO reservations 
        (customer_id_fk, check_in, check_out, code) 
        VALUES (:iCustomerIdFk, :dCheckIn, :dCheckOut, :sCode)");

        $sQuery->bindValue(':iCustomerIdFk', $_SESSION['jUser']['id']);
        $sQuery->bindValue(':dCheckIn', $_POST['checkIn']);
        $sQuery->bindValue(':dCheckOut', $_POST['checkOut']);
        $sQuery->bindValue(':sCode', $reservationCode);
        
        $sQuery->execute();
        $lastInsertIdReservations = $db->lastInsertId();

        $_SESSION['reservations'] = $lastInsertIdReservations;
        
        if( $sQuery->rowCount() ){

            $sQueryRelation = $db->prepare("INSERT INTO reservation_room_relation 
            (reservation_id_fk, room_id_fk) 
            VALUES (:iReservationIdFk, :iRoomIdFk)");    
        
            $sQueryRelation->bindValue(':iReservationIdFk', $lastInsertIdReservations);
            $sQueryRelation->bindValue(':iRoomIdFk', $_POST['roomId']);

            $sQueryRelation->execute();
            $db->commit();
            $db->lastInsertId();

            header('Location: room-reservation-code.php');   
            exit;
        }else{
            echo '{"status":0, "message":"error"}';
        }

    }catch(PDOException $exc){
    echo '{"status":0, "message":"reservation exception"}';
    $db->rollBack();
    }
}

else {

    try{
        $sQuery = $db->prepare("SELECT rm.image, rm.room_type, rm.price, h.id AS hotel_id, h.name, h.hotel_image, h.city, h.country, h.region, h.stars, 
        rm.id AS available_room_id
        FROM rooms AS rm 
        JOIN hotels as h on h.id = rm.hotel_id_fk
        WHERE rm.id = :iRoomId"
        );
           
        $sQuery->bindValue(':iRoomId', $_GET['roomId']);
        $sQuery->execute();
        $aReservations = $sQuery->fetchAll();
    
        foreach($aReservations as $aReservation){
    
            echo  "<div id='".$aReservation['available_room_id']."' class='post'>
            
            <span><b>Room ID:</b> </span><span>".$aReservation['available_room_id']."</span><br>
            <img src='data:image/jpeg;base64,". base64_encode($aReservation['image']) ."' height='120' width='120' />
            <img src='data:image/jpeg;base64,". base64_encode($aReservation['hotel_image']) ."' height='120' width='120' /><br>
            <span><b>Hotel name:</b> </span><span>".$aReservation['name']."</span><br>
            <span><b>Stars:</b> </span><span>".$aReservation['stars']."*</span><br>
            <span><b>City:</b> </span><span>".$aReservation['city']."</span><br>
            <span><b>Room type:</b> </span><span>".$aReservation['room_type']."</span><br>
            <span><b>Check In:</b> </span><span>".$_GET['checkIn']."</span><br>
            <span><b>Check Out:</b> </span><span>".$_GET['checkOut']."</span><br>
            <span><b>Price:</b> </span><span>".$aReservation['price']."&euro;</span><br>        
            </div><br>
            ";
    
    
            echo "<form action='room-booking.php' method='post'>
                <input name='roomId' type='hidden' value='".$aReservation['available_room_id']."'>
                <input name='checkIn' type='hidden' value='".$_GET['checkIn']."'>
                <input name='checkOut' type='hidden' value='".$_GET['checkOut']."'>
                <input name='customerId' type='hidden' value='".$_SESSION['jUser']['id']."'>


                <input type='submit' value='Submit booking'>
                </form>";
          }


    }catch(PDOException $ex){
        echo '{"status":0, "message":"exception"}';
    }
    
}











