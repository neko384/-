<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 開催中のクラウドファンディング一覧</title>

<style>
body	{
		background-color: #fffafa; 
		font-family: arial;
	}

div	{
		background-color: #ffffff;
		width: 500px;
		padding: 20px;
		text-align: center;
		border: 7px ridge #B0E0E6; 
		margin: 65px 50px 50px 0px;
	}

p	{
		color: #FF0000;
		font-size:10px;
	}

h	{
		font-size:25px;
		margin: 50px 100px 0px 50px;
		color: #9932CC;
	}

a	#comp	{
			font-size:10px;
			color: #FF0000;
		}

</style>

</head>
<body>

<h>【開催中のクラウドファンディング】</h>

<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>

<div>
<?php
//データベース内の一覧表示
$sql = 'SELECT * FROM crowdfunding_data';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
//$row['カラム(フィールド)名']とし、各行(レコード)を一つずつ表示していく
	echo "投稿番号:".$row['id']."<br>";
	echo "企画名:".$row['crowdname']."<br>";
	echo "主催者:".$row['proposer']."<br>";
	echo "企画概要説明:".$row['explanation']."<br>";
	echo "現在の支援額:".$row['get_money']."円<br>";
	echo "目標支援額:".$row['target_money']."円<br>";
	echo "企画開始時間:".$row['time']."<br>";

	if($row['get_money'] >= $row['target_money']){
		echo "<br><a id=comp>達成！！！</a><br><br>";
	}

	$id = $row['id'];
	echo "<button onclick='location.href=\"mission_6_support.php?id=$id\"'>支援する</button>";
	echo "<br><br>";


	//各レコード中の画面のファイルパスを一度変数に格納しimgで出力
	if($row['image'] != ""){
		$image = $row['image'];
		print "<img src = $image width='250' height='250'>";
		echo"<br><br>";
	}else{
		echo "イメージ画像なし<br>";
	}
	echo "<hr>";

}
?>
</div>

<br><a href = 'mission_6_mypage.php'>マイページ</a>


</body>
</html>