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
			$options .= "<option>$val</option>\n";
                }
        }

        //disconnect
        $db = null;

} catch (PDOException $e) {
        echo $e->getMessage();
        exit;
}
?>

<form action="archive.php" method="post" >
1位
<select name='1st'>
<?php print $options; ?>
</select>
スコア
<input type="number" name="score1" size="4" value="0" required><br><br>

2位
<select name='2nd'>
<?php print $options; ?>
</select>
スコア
<input type="number" name="score2" size="4" value="0" required><br><br>

3位
<select name='3rd'>
<?php print $options; ?>
</select>
スコア
<input type="number" name="score3" size="4" value="0" required><br><br>

4位
<select name='4th'>
<?php print $options; ?>
</select>
スコア
<input type="number" name="score4" size="4" value="0" required><br><br>

<input type="submit">

</form>

</body>

</html>
