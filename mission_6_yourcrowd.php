<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER あなたのクラウドファンディング企画</title>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>


<h4>【あなたが開催中のクラウドファンディング一覧】</h4>


<?php
session_start();
$name = $_SESSION['logname'];
$pass = $_SESSION['logpass'];


//テーブル内の自分が開催している企画一覧表示
$sql = "SELECT * FROM crowdfunding_data WHERE proposer = \"$name\" AND password = \"$pass\"";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
//$row['カラム(フィールド)名']とし、各行(レコード)を一つずつ表示
	echo "投稿番号:".$row['id']."<br>";
	echo "企画名:".$row['crowdname']."<br>";
	echo "主催者:".$row['proposer']."<br>";
	echo "企画概要説明:".$row['explanation']."<br>";
	echo "現在の支援額:".$row['get_money']."円<br>";
	echo "目標支援額:".$row['target_money']."円<br>";
	echo "企画開始時間:".$row['time']."<br>";

	$id = $row['id'];
	echo "<br><button onclick='location.href=\"mission_6_delete.php?id=$id\"'>削除する</button>";
	echo "<br><br><button onclick='location.href=\"mission_6_edit.php?id=$id\"'>編集する</button>";

	echo "<br><br>";


	//各レコード中の画面のファイルパスを一度変数に格納しimgで出力
	if($row['image'] != ""){
		$image = $row['image'];
		print "<img src = $image width='250' height='250'>";
		echo"<br>";
	}else{
		echo "イメージ画像なし<br>";
	}
	echo "<hr>";

}
?>







<br><a href = 'mission_6_mypage.php'>マイページ</a>
</body>
</html> 