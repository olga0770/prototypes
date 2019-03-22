<?php
$sTitle = 'Search hotels';
$sCss = 'main.css';
require_once './components/top.php';

?>
<form action="index.php">
<section>
    <h2>Search hotel</h2><hr>

    <p>
      <label for="Search">
        <span>Search:</span>
      </label>
      <input type="text" placeholder="Hotel search..." name="search">
    </p>

    <p>
      <label for="filterByPrice">
        <span>Sort by Price:</span>
      </label>
      <select id="filterByPrice" name="filterByPrice">
        <option value="ASC">Low to High</option>
        <option value="DESC">High to Low</option>
      </select>
    </p>

    <p>
      <label for="checkIn">
        <span>Check In:</span>
      </label>
      <input type="date" id="checkIn" name="checkIn" value="<?php echo $_GET['checkIn']; ?>"> | 
    
    
      <label for="checkOut">
        <span>Check Out:</span>
      </label>
      <input type="date" id="checkOut" name="checkOut" value="<?php echo $_GET['checkOut']; ?>"> 
    </p>
</section>

    <button type="submit">Search</button>   
</form>
<hr>


<?php
require_once 'database.php';
require_once 'database-sqlite.php';

if(isset($_GET['search']) || isset($_GET['filterByPrice']) || isset($_GET['checkIn']) || isset($_GET['checkOut'])){
$search = $_GET['search'];
$sFilterByPrice = $_GET['filterByPrice'];
$sCheckIn = $_GET['checkIn'];
$sCheckOut = $_GET['checkOut'];

try{
  $sQuery = $db->prepare("SELECT rm.image, rm.room_type, rm.price, h.id, h.name, h.hotel_image, h.city, h.country, h.region, h.stars, rm.id AS available_room_id 
  FROM rooms AS rm 
  JOIN hotels as h on h.id = rm.hotel_id_fk 
  WHERE rm.id NOT IN
  (SELECT rm_2.id FROM reservation_room_relation AS rrr
  JOIN rooms AS rm_2 ON rm_2.id = rrr.room_id_fk
  JOIN reservations AS res ON res.id = rrr.reservation_id_fk
  WHERE res.check_in <= '$sCheckOut' AND res.check_out >= '$sCheckIn')
  AND (h.city LIKE '%$search%' OR h.country LIKE '%$search%' OR h.region LIKE '%$search%') 
  ORDER BY rm.price $sFilterByPrice ");

    $sQuery->execute();
    $aHotels = $sQuery->fetchAll();
    foreach($aHotels as $aHotel){
    
      echo  "<div id='".$aHotel['id']."' class='post'>
      <span><b>Room ID:</b> </span><span>".$aHotel['available_room_id']."</span><br>
      <h3>".$aHotel['name']."</h3>
      <img src='data:image/jpeg;base64,". base64_encode($aHotel['image']) ."' height='120' width='120' />
      <img src='data:image/jpeg;base64,". base64_encode($aHotel['hotel_image']) ."' height='120' width='180' /><br>
      <span><b>City:</b> </span><span>".$aHotel['city']."</span><br>
      <span><b>Country:</b> </span><span>".$aHotel['country']."</span><br>
      <span><b>Stars:</b> </span><span>".$aHotel['stars']."*</span><br>
      <span><b>Room type:</b> </span><span>".$aHotel['room_type']."</span><br>
      <span><b>Price:</b> </span><span>".$aHotel['price']."&euro;</span><br>
      <h4><a href='hotel-info.php?hotelId=".$aHotel['id']."'>Hotel info and reviews</a> | 
      <a href='room-booking.php?checkIn=".$sCheckIn."&checkOut=".$sCheckOut."&roomId=".$aHotel['available_room_id']."'>Book room</a>
      </h4>  
      </div>
      <hr>";
    }
      // SQLite log
      _loglite('Potential customer has found some variations');

    }catch(PDOException $exc){
        echo "Sorry, system is updating ...";

      // SQLite log
      _loglite('Potential customer has got a problem with searchings');
    }
}

require_once './components/bottom.php';

