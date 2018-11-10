<?php
session_start(); 
header("Content-type: text/html; charset=utf-8");
$token = $_SESSION['token'];
//クリックジャッキング対策
header('X-FRAME-OPTIONS: SAMEORIGIN');
?>
<!DOCTYPE html>
<html>
<head>
<title>メール登録画面</title>
<meta charset="utf-8">
</head>
<body>
<p><a href="http://tt-458b.99sv-coco.com/toppage.php">TOPページ</a>
   <a href="http://tt-458b.99sv-coco.com/question.php">質問・相談</a>
<h1>メール登録画面</h1>
<form action="registration_mail_check.php" method="post">
<p>メールアドレス：<input type="text" name="mail" size="50"></p>
qandatouroku@eay.jpからメールが届きます<br>
<input type="hidden" name="token" value="<?=$token?>">
<input type="submit" value="登録する">
</form>
</body>
</html>
