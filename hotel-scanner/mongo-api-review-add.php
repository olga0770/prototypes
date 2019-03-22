<?php
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");

$iCustomerId = $_POST['intCustomerId'];
$iHotelId = $_POST['intHotelId'];
$iEvaluation = $_POST['evaluation'];
$sReview = $_POST['txtReview'];

if(!empty($iCustomerId) || !empty($iHotelId) || !empty($sReview)){

try{
    $collectionReviews = $client->selectCollection('hotel-reviews', 'reviews');   
    $collectionReviews->insertOne(["customer_id"=>$iCustomerId, "hotel_id"=>$iHotelId, "evaluation"=>$iEvaluation, "text"=>$sReview, "date"=>new MongoDB\BSON\UTCDateTime()]);
       
    }catch(MongoException $e){
        echo "error message: ".$e->getMessage()."\n";
        echo "error code: ".$e->getCode()."\n"; 
    }
}