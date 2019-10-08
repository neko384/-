<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 管理者ページ</title>
</head>
<body>

<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>


<h3>【管理者ページ】</h3>

<form action="" method="post">
<br>ユーザー登録情報の全消去：
<input type="radio" name="userdelete">

<p><input type="submit" name="usersub" value="ユーザー情報消去">
<p><p>

<br>クラウドファンディング情報の全消去：
<input type="radio" name="crowddelete">

<p><input type="submit" name="crowdsub" value="クラウドファンディング情報消去">
<p><p>

<br>全ユーザーの入金履歴の消去：
<input type="radio" name="funddelete">

<p><input type="submit" name="fundsub" value="入金履歴の消去">
<p><p>
</form>

<br><br><br>

<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
	if(!empty($_POST["userdelete"])&&!empty($_POST["usersub"])){
		$sql = 'TRUNCATE TABLE user_information1';
		$stmt = $pdo->query($sql);
		echo "【報告】ユーザー情報を削除しました<br>";
	}

	if(!empty($_POST["crowddelete"])&&!empty($_POST["crowdsub"])){
		$sql = 'TRUNCATE TABLE crowdfunding_data';
		$stmt = $pdo->query($sql);
		echo "【報告】クラウドファンディング情報を削除しました<br>";
	}

	if(!empty($_POST["funddelete"])&&!empty($_POST["fundsub"])){
		$sql = 'TRUNCATE TABLE funding_history';
		$stmt = $pdo->query($sql);
		echo "【報告】全ユーザーの入金履歴を削除しました<br>";
	}

}

?>
</body>
</html>