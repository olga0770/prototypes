<?php
require 'vendor/autoload.php';
// connect to the server
$client = new MongoDB\Client("mongodb://localhost:27017");

try{
// connect to the hotel-reviews database
// use reviews collection
$collectionReviews = $client->selectCollection('hotel-reviews', 'reviews');

$ajReviews = $collectionReviews->find();
foreach($ajReviews as $jReview){
    echo '<div>ID: ' .$jReview["_id"]. '</div>';
    echo '<div>CUSTOMER ID: ' .$jReview["customer_id"]. '</div>';
    echo '<div>HOTEL ID: ' .$jReview["hotel_id"]. '</div>';
    echo '<div>MESSAGE: ' .$jReview["text"]. '</div>';
    $dt = $jReview["date"]->toDateTime(); // convert $jReview["date"] which is of class MongoDB\BSON\UTCDateTime to PHP DateTime object
    echo '<div>DATE: ' .$dt->format("d M Y") . '</div><hr>';
// 
}
// $collectionReviews->insertOne(["name"=>"b", "city"=>"b", "address"=>"b"]);

}catch(MongoException $e){
    echo "error message: ".$e->getMessage()."\n";
    echo "error code: ".$e->getCode()."\n"; 
}