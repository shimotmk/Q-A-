<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名','パスワード',
array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}
//質問テーブル作成
$sql="CREATE TABLE qtable"
."("."num int(5),"
."name char(32),"
."question TEXT,"
."time char(50)"
.");";
$stmt = $pdo->query($sql);
//送信されるもの質問
$name = $_POST['name'];
$question = $_POST['question'];
//質問投稿
if(!empty($question) and !empty($name)){
	//投稿番号の取得画像なし
	$sql = 'SELECT MAX(num) AS num_max FROM qtable';
        $result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        $num = $result['num_max']+1;
	$time=date("Y/m/d H:i:s");
	$sql = $pdo-> prepare("INSERT INTO qtable(num,name,question,time)VALUES(:num,:name,:question,:time)");
	$sql->bindParam(':num',$num,PDO::PARAM_INT);
     	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':question',$question,PDO::PARAM_STR);
	$sql->bindParam(':time',$time,PDO::PARAM_STR);
	$sql->execute();
	$sql="SELECT * FROM qtable ORDER BY num";
     	$result=$pdo->query($sql);		
}
?>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<p><a href="http://tt-458b.99sv-coco.com/toppage.php">TOPページ</a>
<a href="http://tt-458b.99sv-coco.com/question.php">Q質問・相談をする</a></p>
<form method="POST" action="question.php" enctype="multipart/form-data">
<h2>Q質問・相談</h2>
名前：
<input type="text"  name="name" /><br />
質問：
<input type="text"  name="question" style="width:200px;height:50px;"/><br />
<input type="submit" value="送信" /><br />
画像送信:<input type="file" name="pic">
<br>
</form>
</body>
