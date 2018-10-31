<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<p><a href="http://tt-458b.99sv-coco.com/toppage.php">TOPページ</a>
<a href="http://tt-458b.99sv-coco.com/question.php">Q質問・相談をする</a></p>
<h2>TOPページ</h2>
<p>
<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名','パスワード',
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
