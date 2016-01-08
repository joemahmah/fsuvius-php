<?php

require_once $_SERVER['DOCUMENT_ROOT']."/php/database.php";
mysqli_select_db($dbconnection, "cosi");

if (isset($_POST['uid'])){

	if(isset($_POST['name'])){
		$sql = $dbconnection->prepare("UPDATE `users` SET `name` = ? WHERE `users`.`uid` = ?");
		$sql->bind_param("si",$_POST['name'],$_POST['uid']);
		$sql->execute();
		$dbconnection->close();
	}
	if(isset($_POST['fsu'])){
		if(isset($_POST['set'])){
			$sql = $dbconnection->prepare("UPDATE `users` SET `fsu` = ? WHERE `users`.`uid` = ?");
			$sql->bind_param("di",$_POST['fsu'],$_POST['uid']);
			$sql->execute();
			$dbconnection->close();
		} else if(isset($_POST['add'])){
			$sql = $dbconnection->prepare("UPDATE `users` SET `fsu` = ? WHERE `users`.`uid` = ?");
			$addValue = $_POST['orig_fsu'] + $_POST['fsu'];
			$sql->bind_param("di",$addValue,$_POST['uid']);
			$sql->execute();
			$dbconnection->close();
		} else if(isset($_POST['remove'])){
			$sql = $dbconnection->prepare("UPDATE `users` SET `fsu` = ? WHERE `users`.`uid` = ?");
			$subValue = $_POST['orig_fsu'] - $_POST['fsu'];
			$sql->bind_param("di",$subValue,$_POST['uid']);
			$sql->execute();
			$dbconnection->close();
		} else if(isset($_POST['take'])){
			$sql = $dbconnection->prepare("UPDATE `users` SET `fsu` = ? WHERE `users`.`uid` = ?");
			$item_data = explode('|', $_POST['fsu']);
			$subValue = $_POST['orig_fsu'] - $item_data[0];
			$sql->bind_param("di",$subValue,$_POST['uid']);
			$sql->execute();

			$sql2 = $dbconnection->prepare("SELECT `quantity` FROM `storage` WHERE `storage`.`uid` = ?");
			$sql2->bind_param("i",$item_data[1]);
			$sql2->execute();
			$res = $sql2->get_result();
			$quantity = $res->fetch_assoc();
			$new_quantity = $quantity['quantity'] - 1;

			$sql = $dbconnection->prepare("UPDATE `storage` SET `quantity` = ? WHERE `storage`.`uid` = ?");
			$sql->bind_param("ii",$new_quantity,$item_data[1]);
			$sql->execute();
			$dbconnection->close();
		}
	}

	header("Location: http://cosi.derpywriter.com");
	die();
} else{
echo '

<html>

<head>
	<title>Fsuvius2</title>
</head>

<body>

<h1 align="center">Fsuvius PHP</h1>
<h3 align="center">The Open Source Bank - Now With PHP</h3>
<a href="admin.php" style="position:absolute; top: 10px; left: 10px;">Admin</a>
';

$sql = "SELECT * FROM `users`";
$result = $dbconnection->query($sql);

$sql2 = "SELECT * FROM `storage`";
$store_result = $dbconnection->query($sql2);
$options = array();
$options_index = 0;
while($option = $store_result->fetch_assoc()){
	$options[$options_index] = $option;
	$options_index++;
}

if($result->num_rows > 0){
	echo '<table style="width:100%">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>FSU</th>
		</tr>';

	while($row = $result->fetch_assoc()){
		echo '
		<tr align="center">
			<td>'.$row['uid'].'</td>
			<td><form action="index.php" method="POST"><input type="hidden" name="uid" value="'.$row['uid'].'"><input type="text" name="name" value="'.$row['name'].'"><input type="submit" value="Modify"></form></td>
			<td>
				'.$row['fsu'].'
				<form action="index.php" method="POST">
					<input type="hidden" name="uid" value="'.$row['uid'].'">
					<input type="hidden" name="orig_fsu" value="'.$row['fsu'].'">
					<input type="number" step="0.01" name="fsu" value="1">
					<input type="submit" name="set" value="Set">
					<input type="submit" name="add" value="Add">
					<input type="submit" name="remove" value="Remove">
				</form>
				<form action="index.php" method="POST">
					<input type="hidden" name="uid" value="'.$row['uid'].'">
					<input type="hidden" name="orig_fsu" value="'.$row['fsu'].'">
					<select name="fsu">
						';
						foreach($options as $opt){
							if($opt[quantity] > 0){
								echo '<option value="'.$opt[fsu_cost].'|'.$opt[uid].'">'.$opt[name].'</option>';
							}
						}
					echo '
					</select>
					<input type="submit" name="take" value="Take">
				</form>
			</td>
		</tr>
		';
	}

	echo '</table>';
}

echo '

</body>

</html>

';

}

?>
