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
        $stmt = $db->query("select player from player ");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$options = "";
        foreach ($result as $rcd) {
                foreach($rcd as $val){
			echo "<br><a href=\"status.php?name=$val\">$val</a><br>";
                }
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
