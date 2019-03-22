<?php
   if($_POST){
	   echo "<h1>Your order will be send!!</h1>";
	   echo "<p> You will receive " . $_POST['quantity'] . 
		" new iPhone and will be charged " . ($_POST['quantity'] * $_POST['price']) . " USD </p>";
   }
?>

<form method="post" onsubmit="return validateForm()">
	Product: iPhone<br>
	Price: 799 USD<br>
	Quantity: <input type="text" name="quantity" id="quantity"><br>
	<input type="hidden" name="price" value="799">
	<input type="submit">
</form>

<script>
	function validateForm(){
		var q = document.getElementById('quantity').value;
		if(isNaN(q) || !q){
			alert("Quantity must be a number");
			return false;
		} else {
			q = parseInt(q);
			if (q < 1 || q > 100){
				alert("Quantity must be between 1 and 100");
				return false;
			}
		}
		return true;
	}
</script>
