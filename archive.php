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
	$fi = htmlspecialchars($_POST['1st']);
        $se = htmlspecialchars($_POST['2nd']);
        $th = htmlspecialchars($_POST['3rd']);
        $fo = htmlspecialchars($_POST['4th']);
	$sf = intval($_POST['score1']);
	$ss = intval($_POST['score2']);
	$st = intval($_POST['score3']);
	$so = intval($_POST['score4']);

	//decision value
	$expression1 = ($sf+$ss+$st+$so == 0);
	$expression2 = ( !($fi == $se) and !($fi == $th) and !($fi == $fo) and !($se == $th) and !($se == $fo) and !($th == $fo) );
	$expression3 = ($sf >= 30);
	$expression4 = (($sf > $ss) and ($ss >= $st) and ($st > $so));
	if ($expression1 and $expression2 and $expression3 and $expression4) {

	//backup
	$fp = fopen('backup.txt', 'a');
	fputs($fp, "$fi\n");
        fputs($fp, "$se\n");
        fputs($fp, "$th\n");
        fputs($fp, "$fo\n");
        fputs($fp, "$sf\n");
        fputs($fp, "$ss\n");
        fputs($fp, "$st\n");
        fputs($fp, "$so\n");
	fclose($fp);

	//insert into table
	$dt = date('Y-m-d');
	$db->exec("insert into result (1st, 2nd, 3rd, 4th, score1, score2, score3, score4, date ) values ('$fi', '$se', '$th', '$fo', $sf, $ss, $st, $so, '$dt' ) ");


	//following is rate culcuration-------------------------------
	//average
        $stmt = $db->query("select rate from $fi order by id desc limit 1");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       	foreach ($result as $rcd) {
		foreach ($rcd as $data) {
			$rate1 = intval($data);
		}
	}

        $stmt = $db->query("select rate from $se order by id desc limit 1");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $rcd) {
                foreach ($rcd as $data) {
                        $rate2 = intval($data);
                }
        }

        $stmt = $db->query("select rate from $th order by id desc limit 1");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $rcd) {
                foreach ($rcd as $data) {
                        $rate3 = intval($data);
                }
        }

        $stmt = $db->query("select rate from $fo order by id desc limit 1");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $rcd) {
                foreach ($rcd as $data) {
                        $rate4 = intval($data);
                }
        }

	//deviation
	$ave = floor(($rate1+$rate2+$rate3+$rate4) / 4);
	if ($ave-$rate4 >= 0) {
		$devi4 = floor( ($ave-$rate4)/40 );
	} else {
		$devi4 = ceil( ($ave-$rate4)/40 );
	}
        if ($ave-$rate2 >= 0) {
                $devi2 = floor( ($ave-$rate2)/40 );
        } else {
                $devi2 = ceil( ($ave-$rate2)/40 );
        }
        if ($ave-$rate3 >= 0) {
                $devi3 = floor( ($ave-$rate3)/40 );
        } else {
                $devi3 = ceil( ($ave-$rate3)/40 );
        }
	$devi1 = -$devi4-$devi2-$devi3;

	//insert rate
	$rate1 = $rate1+$devi1+$sf;
	$rate2 = $rate2+$devi2+$ss;
	$rate3 = $rate3+$devi3+$st;
	$rate4 = $rate4+$devi4+$so;

        $db->exec("insert into $fi (rate, date) values ('$rate1', '$dt')");
        $db->exec("insert into $se (rate, date) values ('$rate2', '$dt')");
        $db->exec("insert into $th (rate, date) values ('$rate3', '$dt')");
        $db->exec("insert into $fo (rate, date) values ('$rate4', '$dt')");

	$db->exec("update player set rate = '$rate1' where player='$fi'");
        $db->exec("update player set rate = '$rate2' where player='$se'");
        $db->exec("update player set rate = '$rate3' where player='$th'");
        $db->exec("update player set rate = '$rate4' where player='$fo'");


	//preceding code is calculate---------------------------------


	//disconnect
	$db = null;
	header("Location:./comp.html");

	} else {

	//disconnect
        $db = null;

	header("Location:./fail.html");

	}

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

