<?php
require_once 'database-sqlite.php';
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");

try{
    $collectionReviews = $client->selectCollection('hotel-reviews', 'reviews'); 
    
    $reviewIdForUpdate = $_POST['iReviewId'];
    $iNewEvaluation = $_POST['iNewEvaluation'];
    $sNewReview = $_POST['sNewReview'];

    // SQLite log
    _loglite("Now going to update review with _id $reviewIdForUpdate new text is $sNewReview");

// https://stackoverflow.com/questions/34474248/mongodb-php7-update-document-by-id

    $updateResult = $collectionReviews->updateOne(['_id'=>new \MongoDB\BSON\ObjectID($reviewIdForUpdate)], ['$set'=>['evaluation'=>$iNewEvaluation, 'text'=>$sNewReview]]);
    
    $matchedCount = $updateResult->getMatchedCount();
    $modifiedCount = $updateResult->getModifiedCount();

    // SQLite log
    _loglite("Updated review with _id $reviewIdForUpdate");
    _loglite("Matched number of documents: $matchedCount");
    _loglite("Modified number of documents: $modifiedCount");

    http_response_code(200);

}catch(MongoException | PDOException $e){
    echo "error message: ".$e->getMessage()."\n";
    echo "error code: ".$e->getCode()."\n"; 
    file_put_contents('log.txt', "ERROR: review is not updated\n", FILE_APPEND );
}