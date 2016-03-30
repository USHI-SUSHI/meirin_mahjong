<!DOCTYPE html>

<html lang="ja">

<head>
<meta charset="UTF-8">
<style TYPE="text/css">
body{font-size: 3rem;}
</style>

</head>

<body>
<center><br><a href="index.html">ホームに戻る</a><br><br></center>

<?php

define('DB_DATABASE', 'mahjong_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'dbuser');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);

try {
	//connect
	$db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//select table
	$stmt = $db->query("select player, rate from player order by rate desc");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo "<table border='1'>";
	echo "<tr>";
	echo "<td>RANK" . "</td>";
	echo "<td>NAME" . "</td>";
	echo "<td>RATE" . "</td>";
        echo "</tr>";

	$rk = 0;

	foreach ($result as $rcd) {
		$rk = $rk+1;
		echo "<tr>";
		echo "<td>" . "$rk" . "</td>";
		foreach($rcd as $val){
			echo "<td>" . "$val" . "</td>";
		}
		echo "</tr>";
	}

	//disconnect
	$db = null;

} catch (PDOException $e) {
	echo $e->getMessage();
	exit;
}
?>

</body>

</html>
