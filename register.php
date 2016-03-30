<!DOCTYPE html>

<html lang="ja">

<head>
<meta charset="UTF-8">
<style TYPE="text/css">
body{font-size: 4rem;}
</style>
</head>

<body>
<?php

$host = $_SERVER['HTTP_REFERER'];
$str = parse_url($host);
if(stristr($str['host'], "meirin.dip.jp")){
$check = "ok";
}
if($check=="ok"){//restrict access

define('DB_DATABASE', 'mahjong_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', 'dbuser');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);

try {
        //connect
        $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	//acquire data from report.php
	$pn = htmlspecialchars($_POST['name']);

	//insert into table
	$db->exec("insert into player (player, rate) values ('$pn', 1500)");

	//create new table
	$dt = date('Y-m-d');
	$db->exec("create table $pn (id int primary key auto_increment, rate int, date date)");
	$db->exec("insert into $pn (rate, date) values (1500, '$dt')");

	//disconnect
	$db = null;
	header("Location:./comp.html");

} catch (PDOException $e) {
        echo $e->getMessage();
        exit;
}



} else {//restrict access
	echo "<center>不正なアクセスです。</center>";
}

?>

</body>

</html>

