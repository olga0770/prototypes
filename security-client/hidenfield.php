<?php
   if($_POST){
	   echo "<h1>Your order will be send!!</h1>";
	   echo "<p> You will recive " . $_POST['quantity'] . 
		" new iPhone and will be charged " . ($_POST['quantity'] * $_POST['price']) . " USD";
   }
?>

<form method="post">
	Product: iPhone<br>
	Price: 799 USD<br>
	Quantity: <input type="text" name="quantity"><br>
	<input type="hidden" name="price" value="799">
	<button type="submit">Buy</button>
</form>