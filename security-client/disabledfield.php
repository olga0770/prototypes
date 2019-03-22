<?php
   if($_POST){
	   $price = $_POST['price'];
	   if(isset($_POST['discount'])){
		   $price = $_POST['price'] * $_POST['discount'] / 100;
	   }
	   echo "<h1>Your order will be send!!</h1>";
	   echo "<p> You will receive a new iPhone and will be charged " . $price . " USD";
   }
?>

<form method="post">
	Product: iPhone<br>
	Price: 799 USD<br>
	Discount: <input type="text" name="discount" value="0" disabled><br>
	<input type="hidden" name="price" value="799">
	<button type="submit">Buy</button>
</form>

