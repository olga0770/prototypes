<?php
$sTitle = 'Manage reviews';
$sCss = 'main.css';
require_once './components/top.php';
?>

<h2>Manage reviews</h2><hr>
<!-- <form method="post" id="frmReview">
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Customer ID: </label><input name="intCustomerId" type="number"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Hotel ID: </label><input name="intHotelId" type="number"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Evaluation: </label><input name="evaluation" type="number" placeholder="from 1 to 10"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Review: </label><input name="txtReview" type="text"/></p>
<input type="submit" value="Add Review"/>
</form>
<hr> -->

<form action="mongo-review-add.php">
    <input type="text" placeholder="Search..." name="search">
    <button type="submit">Search reviews</button>
</form>
<hr>

<?php

require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");

if(isset($_GET['search'])){
    $search = $_GET['search'];

try{
    $collectionReviews = $client->selectCollection('hotel-reviews', 'reviews');   
    $ajReviews = $collectionReviews->find( ['$text' => ['$search' => $search]] );

    foreach($ajReviews as $jReview){

        echo  "<div id='".$jReview["_id"]."'>
        <span><b>ID:</b> </span><span>".$jReview["_id"]."</span><br>

        <span><b>Customer ID:</b> </span><span>".$jReview["customer_id"]."</span><br>
        <span><b>Hotel ID:</b> </span><span>".$jReview["hotel_id"]."</span><br>
        <span><b>Evaluation:</b> </span><span class='evaluation' contenteditable='false'>".$jReview["evaluation"]."</span><br>
        <span><b>Review:</b> </span><span class='review' contenteditable='false'>".$jReview["text"]."</span><br>
        <span><b>Date:</b> </span><span>".$jReview["date"]->toDateTime()->format("d M Y")."</span><br>  
        <button class='btnDelete'>Delete</button>
        <button class='btnEdit'>Edit</button>                                        
        </div>
        <hr>";        
    }
       
    }catch(MongoException $e){
        echo "error message: ".$e->getMessage()."\n";
        echo "error code: ".$e->getCode()."\n"; 
    }
}

$sScript = 'mongo-review-crud.js';
require_once './components/bottom.php';




