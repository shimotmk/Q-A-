<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<p><a href="http://tt-458b.99sv-coco.com/toppage.php">TOPページ</a>&nbsp;
   <a href="http://tt-458b.99sv-coco.com/question.php">質問</a>&nbsp;
   <a href="http://tt-458b.99sv-coco.com/mypage.php">マイページへ</a>&nbsp;
   <a href="http://tt-458b.99sv-coco.com/logout.php">ログアウトする</a>&nbsp;
   <a href="http://tt-458b.99sv-coco.com/login.php">ログイン</a>&nbsp;
   <a href="http://tt-458b.99sv-coco.com/registration_mail_form.php">新規登録</a></p>
    <?php 
    session_start();
    if(!isset($_SESSION["name"])) {
    ?>
<?php	
}
?>
<div>
	<?php
	if(isset($_SESSION["name"])) {
		echo "ログインしました。".$_SESSION["name"]."さん";
	?>
	<?php	
	}
	?>
</div>
<h2>TOPページ</h2>
<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=tt_458b_99sv_coco_com;charset=utf8','ユーザー名','パスワード',
array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}
$sql='SELECT * FROM qtable ORDER BY num';
$results=$pdo->query($sql);
?>
    <?php foreach ($results as $row): ?>
       <a href="question_detail.php?id=<?php echo $row['num']; ?>"><?php echo mb_substr($row['question'], 0, 40); ?></a>
        <br>
    <?php endforeach; ?>
</p>
</body>
</html>
