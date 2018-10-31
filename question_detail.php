<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
</head>
<body>
<p><a href="http://tt-458b.99sv-coco.com/toppage.php">TOPページ</a>
<a href="http://tt-458b.99sv-coco.com/question.php">Q質問・相談をする</a></p>
<p> 
<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名','パスワード',
array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}
$id = $_GET['id'];
$sql='SELECT * FROM qtable ORDER BY num';
$results=$pdo->query($sql);
foreach($results as $row){
	if($row['num'] == $id){
		echo "{$row['name']}さん {$row['time']} "."<br>"."<br>";
		echo "{$row['question']} "."<br>";
     	}
}
?>
</p>
</body>
<form method="POST" action="" enctype="multipart/form-data">
<h2>回答する</h2>
名前：
<input type="text"  name="name" /><br />
回答：
<input type="text"  name="comment" style="width:200px;height:50px;"/><br />
画像ファイル<br>
<input type="file" name="pic">
<br>
<input type="submit" name="botan" value="送信">
</form>
</html>
