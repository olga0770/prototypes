<?php
require_once 'database-sqlite.php';
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");

try{
    $collectionReviews = $client->selectCollection('hotel-reviews', 'reviews'); 
    $iReviewId = $_GET['iReviewId'];
    $collectionReviews->deleteOne(["_id" => new \MongoDB\BSON\ObjectID($iReviewId)]);

    // SQLite log
    _loglite("Deleted review with _id $iReviewId");

    }catch(MongoException $e){
        echo "error message: ".$e->getMessage()."\n";
        echo "error code: ".$e->getCode()."\n"; 
        file_put_contents('log.txt', "ERROR: review is not deleted\n", FILE_APPEND );
    }
