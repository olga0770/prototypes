<?php
$sTitle = 'Add hotel';
$sCss = 'main.css';
require_once './components/top.php';
?>
<h2>Add hotel</h2><hr>
<form method="post" action="hotel-add.php"
      enctype="multipart/form-data">
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Hotel Name: </label><input name="txtHotelName" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Hotel Image: </label><input type="file" name="document"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Address: </label><input name="txtAddress" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">City: </label><input name="txtCity" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Country: </label><input name="txtCountry" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Postcode: </label><input name="txtPostcode" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Region: </label><input name="txtRegion" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Stars: </label><input name="txtStars" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Description: </label><input name="txtDescription" type="text"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Check In: </label><input name="timeCheckIn" type="time"/></p>
<p><label style="display: inline-block; text-align: right; width: 140px; padding-right: 10px;">Check Out: </label><input name="timeCheckOut" type="time"/></p>
<input type="submit" value="Add Hotel"/>
</form>

<?php
require_once 'database.php';
require_once 'database-sqlite.php';

  if( !empty($_POST['txtHotelName']) ||
  !empty($_POST['document']) ||
  !empty($_POST['txtAddress']) ||
  !empty($_POST['txtCity']) ||
  !empty($_POST['txtCountry']) ||
  !empty($_POST['txtPostcode']) ||
  !empty($_POST['txtRegion']) ||
  !empty($_POST['txtDescription']) ||
  !empty($_POST['timeCheckIn']) ||
  !empty($_POST['timeCheckOut'])
){

$sHotelName = $_POST['txtHotelName'];
$sAddress = $_POST['txtAddress'];
$sCity = $_POST['txtCity'];
$sCountry = $_POST['txtCountry'];
$sPostcode = $_POST['txtPostcode'];
$sRegion = $_POST['txtRegion'];
$sStars = $_POST['txtStars'];
$sDescription = $_POST['txtDescription'];
$sCheckIn = $_POST['timeCheckIn'];
$sCheckOut = $_POST['timeCheckOut'];

    if (isset($_FILES['document']) &&
    ($_FILES['document']['error'] == UPLOAD_ERR_OK)) {

        $newPath = "/" . basename($_FILES['document']['name']);
        if (move_uploaded_file($_FILES['document']['tmp_name'], $newPath)) {
            print "File saved in $newPath";
            $binaryContent = file_get_contents($newPath);

        $db->beginTransaction();
        try{
            $sQuery = $db->prepare("INSERT INTO hotels 
            (name, hotel_image, address, city, country, postcode, region, stars, description, check_in, check_out) 
            VALUES (:sHotelName, :binData, :sAddress, :sCity, :sCountry, :sPostcode, :sRegion, :sStars, :sDescription, :sCheck_in, :sCheck_out)");    
          
            $sQuery->bindValue(':sHotelName', $sHotelName);
            $sQuery->bindValue(':binData', $binaryContent);
            $sQuery->bindValue(':sAddress', $sAddress);
            $sQuery->bindValue(':sCity', $sCity);
            $sQuery->bindValue(':sCountry', $sCountry);
            $sQuery->bindValue(':sPostcode', $sPostcode);
            $sQuery->bindValue(':sRegion', $sRegion);
            $sQuery->bindValue(':sStars', $sStars);
            $sQuery->bindValue(':sDescription', $sDescription);
            $sQuery->bindValue(':sCheck_in', $sCheckIn);
            $sQuery->bindValue(':sCheck_out', $sCheckOut);

            $sQuery->execute();
            $db->commit();
            $db->lastInsertId();

            if( $sQuery->rowCount() ){
            echo '{"status":1, "message":"success"}';

            // SQLite log
            _loglite('New hotel has been added to the list');

            exit;
            }else{
                echo '{"status":0, "message":"error"}';
            }
            
            }catch( PDOException $e ){
                echo '{"status":0, "message":"error", "code":"001", "line":'.__LINE__.'}';
                $db->rollBack();
            }          
        }else{
            print "Couldn't move file to $newPath";
        }
    }else{
        print "No valid file uploaded.";

        // SQLite log
        _loglite('You have a problem with adding a new hotel to the list');
    }
}













