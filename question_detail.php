<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
</head>
<body>
<p><a href="http://tt-458b.99sv-coco.com/toppage.php">TOPページ</a>
<a href="http://tt-458b.99sv-coco.com/question.php">質問・相談をする</a></p>
<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=tt_458b_99sv_coco_com;charset=utf8','tt-458b.99sv-coc','V7jBdbJN',
array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}
$id = $_GET['id'];
//テーブル名を$tablenameとする
$tablename = $id."table";
$sql='SELECT * FROM qtable ORDER BY num';
$results=$pdo->query($sql);
foreach($results as $row){
	if($row['num'] == $id){
		echo "{$row['name']}さん {$row['time']} "."<br>"."<br>";
		echo "{$row['question']} "."<br>"."<br>";
     	}
}
$sql='SELECT * FROM  atable ORDER BY num';
$ansresult=$pdo->query($sql);
echo "アンサー"."<br>";
foreach($ansresult as $ansrow){
	if($ansrow['num'] == $id){
		echo "{$ansrow['name']}さん {$ansrow['time']} "."<br>"."<br>";
		echo "{$ansrow['answer']} "."<br>"."<br>";
     	}
}
//テーブル作成
$sql="CREATE TABLE atable"
."("."num int(5),"
."name char(32),"
."answer TEXT,"
."time char(50)"
.");";
$stmt = $pdo->query($sql);
$name = $_POST['name'];
$answer = $_POST['answer'];
//回答投稿
if(!empty($answer) and !empty($name)){
		$sql = 'SELECT MAX(num) AS num_max FROM atable ';
	        $result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
	        $num = $id;
		$time=date("Y/m/d H:i:s");
		$sql = $pdo-> prepare("INSERT INTO atable(num,name,answer,time)VALUES(:num,:name,:answer,:time)");
		$sql->bindParam(':num',$num,PDO::PARAM_INT);
	     	$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->bindParam(':answer',$answer,PDO::PARAM_STR);
		$sql->bindParam(':time',$time,PDO::PARAM_STR);
		$sql->execute();
		$sql="SELECT * FROM atable ORDER BY num";
	     	$result=$pdo->query($sql);		
}
?>
<form method="POST" action="" enctype="multipart/form-data">
<h2>回答する</h2>
名前：
<input type="text"  name="name" /><br />
回答：
<input type="text"  name="answer" style="width:200px;height:50px;"/><br />
画像ファイル<br>
<input type="file" name="pic">
<br>
<input type="submit" name="botan" value="送信">
</form>
