<?php
$sTitle = 'Hotel info';
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
<h2>Hotel info</h2><hr>
<a href="index.php">Back to search</a>
<hr>

<?php
require_once 'database.php';
try{
    $sQuery = $db->prepare('SELECT * FROM hotels WHERE id = :iHotelId');
    $sQuery->bindValue(':iHotelId', $_GET['hotelId']);
    $sQuery->execute();
    $aHotels = $sQuery->fetchAll();

    foreach($aHotels as $aHotel){
        echo  "<div id='".$aHotel['id']."' class='post'>
        <img src='data:image/jpeg;base64,". base64_encode($aHotel['hotel_image']) ."' height='120' width='120' /><br>
        <h3 class='hotelName' contenteditable='false'>".$aHotel['name']."</h3>
        <span><b>Address:</b> </span><span class='address' contenteditable='false'>".$aHotel['address']."</span><br>
        <span><b>City:</b> </span><span class='city' contenteditable='false'>".$aHotel['city']."</span><br>
        <span><b>Country:</b> </span><span class='country' contenteditable='false'>".$aHotel['country']."</span><br>
        <span><b>Postcode:</b> </span><span class='postcode' contenteditable='false'>".$aHotel['postcode']."</span><br>
        <span><b>Region:</b> </span><span class='region' contenteditable='false'>".$aHotel['region']."</span><br>
        <span><b>Description:</b> </span><span class='region' contenteditable='false'>".$aHotel['description']."</span><br>
        <span><b>Stars:</b> </span><span class='stars' contenteditable='false'>".$aHotel['stars']."*</span><br>
        <span><b>Check In:</b> </span><span class='checkIn' contenteditable='false'>".$aHotel['check_in']."</span><br>
        <span><b>Check Out:</b> </span><span class='checkOut' contenteditable='false'>".$aHotel['check_out']."</span><br>
        </div>
        <hr><hr>
        <h2>Hotel reviews</h2>
        <hr>
        ";
      }
}catch(PDOException $ex){
    echo '{"status":0, "message":"exception"}';
}


// Mongo DB
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
try{
    $collectionReviews = $client->selectCollection('hotel-reviews', 'reviews');
    $ajReviews = $collectionReviews->find();
    foreach($ajReviews as $jReview){

        $sEditAndDelete = '';
        $sCustomerEmail = '';
        if( $jReview["customer_id"] == $_SESSION['jUser']['id'] ){
          $sEditAndDelete = "<button class='btnDelete'>Delete</button><button class='btnEdit'>Edit</button>";
          $sCustomerEmail = $_SESSION['jUser']['email'];
        }

        if($_GET['hotelId'] == $jReview["hotel_id"]){

            echo  "<div id='".$jReview["_id"]."'>
            <img src='img/customer-icon.png' alt='admin' height='30' width='30'>
            <span><b>".$sCustomerEmail."</b></span><br>
            <span><b>Evaluation:</b> </span><span class='evaluation' contenteditable='false'>".$jReview["evaluation"]."</span><br>
            <span class='review' contenteditable='false'>".$jReview["text"]."</span><br>
            <span>".$jReview["date"]->toDateTime()->format("d M Y")."</span><br>  
            ".$sEditAndDelete."                                        
            </div>
            <hr>";        
        }

        $iHotelId = $_GET['hotelId'];
        $jReview["hotel_id"] = $iHotelId;
        $_SESSION['hotel_id'] = $iHotelId;
        
    }    


    // if($jReview["customer_id"] == $_SESSION['jUser']['id']){
        echo "<h2>Add review</h2><hr>
        <form method='post' id='frmInsertReview'>
        <p><label style='display: inline-block; text-align: right; width: 140px; padding-right: 10px;'>Evaluation: </label><input name='evaluation' type='number' placeholder='from 1 to 10'/></p>
        <p><label style='display: inline-block; text-align: right; width: 140px; padding-right: 10px;'>Review: </label><input name='txtReview' type='text'/></p>
        <input type='submit' value='Add Review'/>
        </form>
        <hr>";
    


    }catch(MongoException $e){
        echo "error message: ".$e->getMessage()."\n";
        echo "error code: ".$e->getCode()."\n"; 
    }


    $sScript = 'mongo-review-crud.js';
require_once './components/bottom.php';


