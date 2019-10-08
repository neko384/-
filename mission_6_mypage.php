<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER マイページ</title>

<style>
body	{
		background-color: #fffafa; 
		font-family: arial;
	}

div	{
		background-color: #ffffff;
		width: 400px;
		padding: 20px;
		text-align: center;
		border: 7px ridge #B0E0E6; 
		margin: 65px 50px 100px 0px;
	}

p	{
		font-size:25px;
		margin: 0px 100px 0px 125px;
		color: #9932CC;
	}







</style>
</head>
<body>

<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));



session_start();
echo $_SESSION['logname']."さん。こんにちは。最終ログイン日時：".$_SESSION['logtime']."<br><br>";
?>


<br>
<br>
<p>【マイページ】</p>
<div>
<h4>メニュー</h4>

<a href = "mission_6_nowholding.php">・現在開催中のクラウドファンディング</a>

<br><a href = "mission_6_yourcrowd.php">・あなたのクラウドファンディング</a>

<br><a href = "mission_6_yoursupport.php">・過去の入金一覧</a>

<br><a href = "mission_6_newcrowd.php">・クラウドファンディングの新規立ち上げ</a>
</div>


<br><br><br><br><br><a href = "mission_6_login.php">ログアウト</a>

</body>
</html>