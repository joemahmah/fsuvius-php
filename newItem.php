<?php

require_once $_SERVER['DOCUMENT_ROOT']."/php/database.php";

if (isset($_POST['name']) && isset($_POST['quantity']) && isset($_POST['cost']) && isset($_POST['fsu'])) {

	mysqli_select_db($dbconnection, "cosi");

	$sql = $dbconnection->prepare("INSERT INTO `storage` (`uid`, `name`, `quantity`, `unit_cost`, `fsu_cost`) VALUES (NULL, ?, ?, ?, ?)");
	$sql->bind_param("sidd",$_POST['name'],$_POST['quantity'],$_POST['cost'],$_POST['fsu']);
	$sql->execute();
	$dbconnection->close();

	header("Location: http://cosi.derpywriter.com/newItem.php");
	die();
} else{
echo '

<html>

<head>
	<title>phpMyFsu - Add New Item</title>
</head>

<body>

	<form action="newItem.php" method="POST">
		Item Name:<br>
		<input type="text" name="name"></br>
		Quantity:<br>
		<input type="number" name="quantity" min="0"></br>
		Item Price:<br>
		<input type="number" step="0.01" min="0" name="cost"></br>
		Fsu Cost:<br>
		<input type="number" step="0.01" min="0" name="fsu"></br>
		<br>
		<input type="submit" value="Submit"></br>
	</form>

</body>

</html>

';

}

?>
