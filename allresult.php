<!DOCTYPE html>

<html lang="ja">

<head>
<meta charset="UTF-8">
<style TYPE="text/css">
body{font-size: 1.6rem;}
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
	$stmt = $db->query("select 1st, score1, 2nd, score2, 3rd, score3, 4th, score4, date from result order by id desc");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	echo "<table border='1'>";
	echo "<tr>";
	echo "<td>１位" . "</td>";
	echo "<td>スコア" . "</td>";
	echo "<td>２位" . "</td>";
        echo "<td>スコア" . "</td>";
        echo "<td>３位" . "</td>";
        echo "<td>スコア" . "</td>";
        echo "<td>４位" . "</td>";
        echo "<td>スコア" . "</td>";
	echo "<td>日付" . "</td>";
        echo "</tr>";

	foreach ($result as $rcd) {
		echo "<tr>";
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
