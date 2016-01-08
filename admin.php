<?php

require_once $_SERVER['DOCUMENT_ROOT']."/php/database.php";
mysqli_select_db($dbconnection, "cosi");

$cash = 0;
$store = 0;

$sql = "SELECT * FROM `users`";
$fsu_result = $dbconnection->query($sql);

$sql2 = "SELECT * FROM `storage`";
$store_result = $dbconnection->query($sql2);

$dbconnection->close();

while($result = $fsu_result->fetch_assoc()){
	$cash += $result['fsu'] / 2.0;
}

while($result = $store_result->fetch_assoc()){
	$store += $result['unit_cost'] * $result['quantity'];
}

echo '

<html>
<head>
	<title>phpFsuviusAdmin</title>
	<script language="javascript" type="text/javascript">
		function setIframe(url){
			document.getElementById('."'iframe'".').src = url;
		}
	</script>
</head>

<body>
	<a href="index.php"><button>Home</button></a>
	<input type="button" onclick="setIframe(\'modifyItem.php\')" value="View Stock">
	<input type="button" onclick="setIframe(\'newItem.php\')" value="Add New Stock">
	Fsuvius Assets: $'.$cash.' || Estimated Storage Value: $'.$store.'
	<iframe id="iframe" src="" style="width: 100%; height:95%;">
</body>
</html>

';

?>
