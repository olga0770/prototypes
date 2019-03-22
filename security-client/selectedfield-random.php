<?php

session_start();

   if($_POST){
	   $products = explode("_", $_POST['products']);
	   $min = $products[0];
	   $price = $products[1];

	   $token = $products[2];

	   $digest = md5($_SESSION['key'].$min."_".$price);


	   if($digest !== $token){
		   echo 'security error';
		   exit();
	   }
	   
	   echo "<h1>Success!!</h1>";
	   echo "<p> You will be connected for " . $min . " minutes and will be charged " . $price . " USD";
   }

   $_SESSION['key'] = rand();

 ?>

<form method="post">
 	Select number of minutes to be connected:
 	<select name="products">
 		<option value="30_30">30 min - 30 USD</option>
 		<option value="60_45">60 min - 45 USD</option>
 		<option value="120_55_<?php echo md5($_SESSION['key']."120_55") ?>" >120 min - 55 USD</option>
 	</select>
 	<button type="submit">Buy</button>
 </form>

