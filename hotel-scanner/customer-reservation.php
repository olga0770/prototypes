<?php
$sTitle = 'Customer reservation';
$sCss = 'main.css';
require_once './components/top.php';
?>
<h2>Customer reservation</h2><hr>
<h3>Search customer reservation by e-mail</h3>
<form action="customer-reservation.php">
    <input type="text" placeholder="Search..." name="search">
    <button type="submit">Search by email</button>
</form>
<hr>

<?php
require_once 'database.php';

if(isset($_GET['search'])){
$search = $_GET['search'];
    try{
        $sQuery = $db->prepare("select c.first_name, c.last_name, c.email, r.check_in, r.check_out, r.code, 
        rm.id, rm.room_type, rm.price, rm.id AS room_id, h.name, h.stars, h.address, r.id as reservation_id, 
        DATEDIFF(r.check_out, r.check_in) as nights, rm.price*DATEDIFF(r.check_out, r.check_in) as total 
        from reservation_room_relation as rrr
        join reservations as r on r.id = rrr.reservation_id_fk
        join customers as c on c.id = r.customer_id_fk
        join rooms as rm on rm.id = rrr.room_id_fk
        join hotels as h on h.id = rm.hotel_id_fk 
        WHERE email LIKE '%$search%' 
        ORDER BY r.id
        
        ");
        $sQuery->execute();
        $aReservations = $sQuery->fetchAll();

        foreach($aReservations as $aReservation){
            echo
            "<h3><span><b>E-mail:</b> </span><span>".$aReservation['email']."</span></h3>

            <span style='display: inline-block; width: 140px;'><b>First Name:</b> </span><span>".$aReservation['first_name']."</span><br>
            <span style='display: inline-block; width: 140px;'><b>Last Name:</b> </span><span>".$aReservation['last_name']."</span><br>


            <span style='display: inline-block; width: 140px;'><b>Check In:</b> </span><span>".$aReservation['check_in']."</span><br>
            <span style='display: inline-block; width: 140px;'><b>Check Out:</b> </span><span>".$aReservation['check_out']."</span><br>
            <span style='display: inline-block; width: 140px;'><b>Nights:</b> </span><span>".$aReservation['nights']."</span><br>
            <span style='display: inline-block; width: 140px;'><b>Room Price:</b> </span><span>".$aReservation['price']."&euro;</span><br>
            <span style='display: inline-block; width: 140px;'><b>Room Type:</b> </span><span>".$aReservation['room_type']."</span><br>
            <span style='display: inline-block; width: 140px;'><b>Hotel:</b> </span><span>".$aReservation['name']."</span><br>
            <span style='display: inline-block; width: 140px;'><b>Hotel Stars:</b> </span><span>".$aReservation['stars']."*</span><br>
            <span style='display: inline-block; width: 140px;'><b>Hotel Address:</b> </span><span>".$aReservation['address']."</span><br>
            <span style='display: inline-block; width: 140px;'><b>Reservation Code:</b> </span><span>".$aReservation['code']."</span><br>

            <h3><span><b>Total amount:</b> </span><span>".$aReservation['total']."&euro;</span></h3>
            <hr>";
        }


            $sQueryIncome = $db->prepare("CALL total_income()");
            $sQueryIncome->execute();
            $iIncome = $sQueryIncome->fetchAll();
        
            foreach($iIncome as $iTotal){
                echo
                "<hr><h3>Total income from all reservations: ".$iTotal['total']."&euro;</h3><hr>";
            }

    }catch(PDOException $ex){
        echo "Sorry, system is updating ...";
    }
}
?>

<hr><h3>Customers' e-mails</h3>
<hr>

<?php
try{
    $sQuery = $db->prepare("CALL p_get_customers() ");
    $sQuery->execute();
    $aCustomers = $sQuery->fetchAll();

        foreach($aCustomers as $aCustomer){
        echo
        "<span><b>E-mail:</b> </span><span class='city' contenteditable='false'>".$aCustomer['email']."</span><br>
        <hr>";
        }
}catch(PDOException $ex){
    echo "Sorry, system is updating ...";
}

require_once './components/bottom.php';