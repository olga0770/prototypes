<?php

session_start();

if( !$_SESSION['jUser'] ){
  header('Location: customer-login.php');
  exit;
}else{
  echo "<img src='img/customer-icon.png' alt='admin' height='30' width='30'>
  <span>Welcome ".$_SESSION['jUser']['email']."!</span>
  <a href='customer-logout.php'> Logout</a><hr>";
}






require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");


if(!empty($_POST['evaluation']) || !empty($_POST['txtReview'])){

try{

    $iEvaluation = $_POST['evaluation'];
    $sReview = $_POST['txtReview'];

    $collectionReviews = $client->selectCollection('hotel-reviews', 'reviews');   
    $collectionReviews->insertOne(["customer_id"=>$_SESSION['jUser']['id'], "hotel_id"=>$_SESSION['hotel_id'], "evaluation"=>$iEvaluation, 
    "text"=>$sReview, "date"=>new MongoDB\BSON\UTCDateTime()]);


    }catch(MongoException $e){
        echo "error message: ".$e->getMessage()."\n";
        echo "error code: ".$e->getCode()."\n"; 
    }
}



