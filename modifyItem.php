<?php

require_once $_SERVER['DOCUMENT_ROOT']."/php/database.php";
mysqli_select_db($dbconnection, "cosi");

if (isset($_POST['uid'])){

	if(isset($_POST['name'])){
		$sql = $dbconnection->prepare("UPDATE `storage` SET `name` = ? WHERE `storage`.`uid` = ?");
		$sql->bind_param("si",$_POST['name'],$_POST['uid']);
		$sql->execute();
		$dbconnection->close();
	}
	if(isset($_POST['quantity'])){
		$sql = $dbconnection->prepare("UPDATE `storage` SET `quantity` = ? WHERE `storage`.`uid` = ?");
		$sql->bind_param("ii",$_POST['quantity'],$_POST['uid']);
		$sql->execute();
		$dbconnection->close();
	}
	if(isset($_POST['cost'])){
		$sql = $dbconnection->prepare("UPDATE `storage` SET `unit_cost` = ? WHERE `storage`.`uid` = ?");
		$sql->bind_param("di",$_POST['cost'],$_POST['uid']);
		$sql->execute();
		$dbconnection->close();
	}
	if(isset($_POST['fsu'])){
		$sql = $dbconnection->prepare("UPDATE `storage` SET `fsu_cost` = ? WHERE `storage`.`uid` = ?");
		$sql->bind_param("di",$_POST['fsu'],$_POST['uid']);
		$sql->execute();
		$dbconnection->close();
	}

	header("Location: http://cosi.derpywriter.com/modifyItem.php");
	die();
} else{
echo '

<html>

<head>
	<title>phpMyFsuvius - View and Modify Items</title>
</head>

<body>

';

$sql = "SELECT * FROM `storage`";
$result = $dbconnection->query($sql);

if($result->num_rows > 0){
	echo '<table style="width:100%">
		<tr>
			<th>Name</th>
			<th>Quantity</th>
			<th>Cost (USD)</th>
			<th>Cost (FSU)</th>
		</tr>';
	while($row = $result->fetch_assoc()){
		echo '
		<tr align="center">
			<td><form action="modifyItem.php" method="POST"><input type="hidden" name="uid" value="'.$row['uid'].'"><input type="text" name="name" value="'.$row['name'].'"><input type="submit" value="Modify"></form></td>
			<td><form action="modifyItem.php" method="POST"><input type="hidden" name="uid" value="'.$row['uid'].'"><input type="number" min="0" name="quantity" value="'.$row['quantity'].'"><input type="submit" value="Modify"></form></td>
			<td><form action="modifyItem.php" method="POST"><input type="hidden" name="uid" value="'.$row['uid'].'"><input type="number" min="0" step="0.01" name="cost" value="'.$row['unit_cost'].'"><input type="submit" value="Modify"></form></td>
			<td><form action="modifyItem.php" method="POST"><input type="hidden" name="uid" value="'.$row['uid'].'"><input type="number" min="0" step="0.01" name="fsu" value="'.$row['fsu_cost'].'"><input type="submit" value="Modify"></form></td>
		</tr>
		';
	}
}

echo '

</body>

</html>

';

}

?>
