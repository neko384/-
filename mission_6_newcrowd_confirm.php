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
//クラウドファンディングの投稿内容の確認
session_start();
if($_SESSION['crowdname']&&$_SESSION['proposer']&&$_SESSION['explanation']&&$_SESSION['target_money']){
	echo "クラウドファンディングの新規立ち上げ内容の確認をしてください<br>";
	echo "<br>クラウドファンディング名:".$_SESSION['crowdname']."<br><br>企画提案者:".$_SESSION['proposer']."<br><br>事業概要説明:".$_SESSION['explanation']."<br><br>支援目標額:".$_SESSION['target_money']."円<br><br>イメージ画像<br>";
	
	//画像そのものをBASE64でエンコードし直接出力
	//BASE64のHTML埋め込みはdata URI schemeを用いる data:[メディアタイプ];[エンコード方式],[データ]
	if($_SESSION['image'] != ""){
		$base64 = base64_encode($_SESSION['image']);
		print "<img src = data:image/jpeg;base64,$base64 width='350' height='350'>";
	}else{
		echo "本クラウドファンディングの画像イメージはありません。";
	}
}
?>

<br><br>
この内容でクラウドファンディングを立ち上げますか？
<br><br>

<!--最終確認ボタン-->
<form action="mission_6_newcrowd_complete.php" method="post">
<input type="submit" name="final_decide" value="決定">

<br><br><a href = "mission_6_newcrowd.php">戻る</a>


</body>
</html>