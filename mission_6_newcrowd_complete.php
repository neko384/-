<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 新規立ち上げ確認画面</title>
</head>
<body>

<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブルの作成
$sql = "CREATE TABLE IF NOT EXISTS crowdfunding_data"
." ("
."id INT AUTO_INCREMENT PRIMARY KEY, "  
."crowdname varchar(1000),"
."proposer varchar(1000),"
."explanation TEXT,"
."target_money INT,"
."get_money INT,"
."image varchar(1000),"
."time DATETIME,"
."password varchar(1000)"
.");";
$stmt = $pdo->query($sql);
?>

<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
	//投稿内容をデータベースに加える。
	$complete = "";
	$sql = $pdo->prepare("INSERT INTO crowdfunding_data (crowdname, proposer, explanation, target_money, get_money, image, time, password) VALUES (:crowdname, :proposer, :explanation, :target_money, :get_money, :image, :time, :password)");
	$sql -> bindParam(':crowdname', $crowdname, PDO::PARAM_STR);
	$sql -> bindParam(':proposer', $proposer, PDO::PARAM_STR);
	$sql -> bindParam(':explanation', $explanation, PDO::PARAM_STR);
	$sql -> bindParam(':target_money', $target_money, PDO::PARAM_STR);
	$sql -> bindParam(':get_money', $get_money, PDO::PARAM_STR);
	$sql -> bindParam(':image', $image, PDO::PARAM_STR);
	$sql -> bindParam(':time', $date, PDO::PARAM_STR);
	$sql -> bindParam(':password', $password, PDO::PARAM_STR);

	session_start();
	$crowdname = $_SESSION['crowdname'];
	$proposer = $_SESSION['proposer'];
	$explanation = $_SESSION['explanation'];
	$target_money = $_SESSION['target_money'];
	$get_money = 0;
	$image = $_SESSION['imagepath'];
	$date = date("Y-m-d H:i:s");
	$password = $_SESSION['logpass'];
	$sql -> execute();


	//本当に登録されたかの確認をセッションの中身とデータベースで比較
	$sql = 'SELECT * FROM crowdfunding_data';
	$stmt = $pdo->query($sql);
	foreach ($stmt as $row){
		if(($row['crowdname']==$_SESSION['crowdname'])&&($row['proposer']==$_SESSION['proposer'])&&($row['explanation']==$_SESSION['explanation'])&&($row['target_money']==$_SESSION['target_money'])&&($row['password']==$_SESSION['logpass'])){
			echo 'クラウドファンディング企画:'.$_SESSION['crowdname']."の新規立ち上げが完了しました。<br>";
			$complete = "完了";
		}
	}

	//エラーメッセージの表記
	if($complete != "完了"){
		echo "<br>クラウドファンディングの新規立ち上げに失敗しました。始めから行ってください<br>";
		echo "<br><a href = 'mission_6_newcrowd.php'>クラウドファンディング新規立ち上げ</a>";
	}

	//セッションの中身を空白化
	$_SESSION['crowdname'] = "";
	$_SESSION['proposer'] = "";
	$_SESSION['explanation'] = "";
	$_SESSION['target_money'] = "";
	$_SESSION['imagepath'] = "";
	
}
?>

<br><a href = 'mission_6_nowholding.php'>開催中のクラウドファンディング</a>
<br><a href = 'mission_6_mypage.php'>マイページ</a>


</body>
</html>