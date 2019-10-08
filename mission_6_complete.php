<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 本登録</title>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


//このURL踏んだ瞬間にデータベースにセッションの内容を送信
	//データが送信された際にプリペアド文を実行しデータベースにデータを送る
session_start();

$complete = "";
if(($_SESSION['username'])&&($_SESSION['password'])&&($_SESSION['email'])){
	$sql = $pdo->prepare("INSERT INTO user_information1 (name, password, email) VALUES (:name, :password, :email)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':password', $password, PDO::PARAM_STR);
	$sql -> bindParam(':email', $email, PDO::PARAM_STR);
	$name = $_SESSION['username'];
	$password = $_SESSION['password'];
	$email = $_SESSION['email'];
	$sql -> execute();

//本当に登録されたかの確認をセッションの中身とデータベースで比較
	$sql = 'SELECT * FROM user_information1';
	$stmt = $pdo->query($sql);
	foreach ($stmt as $row){
		if(($row['name']==$_SESSION['username'])&&($row['password']==$_SESSION['password'])&&($row['email']==$_SESSION['email'])){
			echo $_SESSION['username']."さんの会員登録が完了しました。<br>お疲れ様でした。ログイン画面からログインしてください";
			$complete = "完了";


		}
	}
}

//エラーメッセージの表記
if($complete != "完了"){
	echo "<br>新規登録に失敗しました。再度新規登録画面から登録を行ってください。<br>";
}

//セッションの中身のリセット
if(($_SESSION['username'])&&($_SESSION['password'])&&($_SESSION['email'])){
	$_SESSION['username']="";
	$_SESSION['password']="";
	$_SESSION['email']="";
}

?>
<br><a href = 'mission_6_login.php'>ログイン画面</a>
<br><br><a href = 'mission_6_register.php'>新規登録</a>


</html>