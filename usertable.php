<?php
try {
$pdo = new PDO('mysql:host=localhost;dbname=データベース名;charset=utf8','ユーザー名','パスワード',
array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
 exit('データベース接続失敗。'.$e->getMessage());
}
$sql="CREATE TABLE usertable"
."("."num int(5),"
."name char(32),"
."pass char(34)"
.");";
$stmt = $pdo->query($sql);
$name = $_POST['name'];
$pass = $_POST['pass'];
$delname = $_POST['delname'];
$delpass = $_POST['delpass'];
$namel = $_POST['namel'];
$passl = $_POST['passl'];
//新規登録
if(empty($wanteditnum) and   !empty($pass) and !empty($name)){
	//投稿番号の取得
	$sql = 'SELECT MAX(num) AS num_max FROM usertable';
        $result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        $num = $result['num_max']+1;
	$sql = $pdo-> prepare("INSERT INTO usertable(num,name,pass)VALUES(:num,:name,:pass)");
	$sql->bindParam(':num',$num,PDO::PARAM_INT);
     	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	// ここで、$hash 変数に代入
        $hash = crypt($pass);
	$sql->bindParam(':pass',$hash,PDO::PARAM_STR);
	$sql->execute();
	$sql="SELECT * FROM login ORDER BY num";
     	$result=$pdo->query($sql);
}
//削除機能
if(!empty($delname) and  !empty($delpass)){
	$value = $delname;
	$sql='SELECT * FROM usertable where name = :delname';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':delname', $value, PDO::PARAM_INT);
	$stmt -> execute();
	$row = $stmt->fetch();
	$pass = $row['pass'];
	$delpass = crypt($delpass,$pass);
	if ($delpass == $pass){
		$value = $delname;
		$sql = 'DELETE FROM usertable where name = :delname';
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(':delname', $value, PDO::PARAM_INT);
		$stmt -> execute();
	}
}
//ログイン機能
if(!empty($namel) and  !empty($passl)){
	$value = $namel;
	$sql='SELECT * FROM usertable where name = :namel';
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':namel', $value, PDO::PARAM_INT);
	$stmt -> execute();
	$row = $stmt->fetch();
	$pass = $row['pass'];
	$passl = crypt($passl,$pass);
	if ($passl == $pass){
		//セッションスタート
		session_start();
		$_SESSION['namel'] = $namel;
		$_SESSION['passl'] = $passl;
		header('Location: toppage.php');
		exit();
	}
}
?>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
<font  size="5"color="red">ユーザー登録・ログイン！</font><br>
<body>
<form method="POST" action="usertable.php"><br />
	ログイン<br />
	ユーザー名：
	<input type="text"  name="namel" /><br />
	パスワード:
	<input type="text"  name="passl" />
	<input type="submit" name="login" value="ログイン" /><br />
</form>			
</body>	
<form method="POST" action="usertable.php">
	新規登録<br />
	ユーザー名：
	<input type="text" value = "<?php echo $namae; ?>" name="name" /><br />
	パスワード:
	<input type="text"  name="pass" />
	<input type="submit" value="送信" /><br />
</form>
</body>
<body>
<form method="POST" action="usertable.php">
	ユーザー登録削除<br />
	<input type="text" placeholder = "ユーザー名" name="delname" /><br />
	<input type="text"  placeholder = "パスワード "name="delpass"/>
	<input type="submit" value="削除" /><br />
</form>
</body>	
<?php
//非公開予定部分
$sql='SELECT * FROM usertable ORDER BY num';
$results=$pdo->query($sql);
foreach($results as $row){
	echo "ユーザー名：{$row['name']} パスワード：{$row['pass']} "."<br>";
}
?>
