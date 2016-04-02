<!DOCTYPE html>

<html lang="ja">

<head>
<meta charset="UTF-8">
<style TYPE="text/css">
body{font-size: 3rem;}
</style>

</head>

<body>
<?php

define('DB_DATABASE', 'mahjong_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'dbuser');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);

try {
	//connect
	$db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$name = $_GET['name'];

	echo "<br>" . $name . "の成績<br><br>";

	//show the number of games
	$n1 = 0;  $n2 = 0;  $n3 = 0;  $n4 = 0;
	$stmt = $db->query("select id from result where 1st = '$name'");
	$n1 = $stmt->rowCount();
        $stmt = $db->query("select id from result where 2nd = '$name'");
        $n2 = $stmt->rowCount();
        $stmt = $db->query("select id from result where 3rd = '$name'");
        $n3 = $stmt->rowCount();
        $stmt = $db->query("select id from result where 4th = '$name'");
        $n4 = $stmt->rowCount();
	$ng = $n1 + $n2 + $n3 + $n4;
	if ($ng != 0) {
		$nav = ( $n1 + ($n2 * 2) + ($n3 * 3) + ($n4 * 4) ) / $ng;
	}

	echo "対戦回数　" . $ng . "回<br>" ;
	echo "１位　" . $n1 . "回<br>";
        echo "２位　" . $n2 . "回<br>";
        echo "３位　" . $n3 . "回<br>";
        echo "４位　" . $n4 . "回<br>";
	echo "平均順位　" . $nav ."位<br>";

	//show rate transition
	$stmt = $db->query("select rate, date from $name order by id desc");
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo "<br><br>レート推移";
	echo "<table border='1'>";
	echo "<tr>";
	echo "<td>RATE" . "</td>";
	echo "<td>DATE" . "</td>";
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
