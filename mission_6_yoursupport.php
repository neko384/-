<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 過去の支援履歴</title>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>


<h4>【過去の入金一覧】</h4>


<?php
session_start();
$name = $_SESSION['logname'];
$pass = $_SESSION['logpass'];


//過去の支援履歴
$sql = "SELECT * FROM funding_history1 WHERE username = \"$name\" AND password = \"$pass\"";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
//$row['カラム(フィールド)名']とし、各行(レコード)を一つずつ表示していく
	echo "支援金額:".$row['fundmoney']."円<br>";
	echo "企画の投稿番号:".$row['toukouid']."<br>";
	echo "企画名:".$row['fundname']."<br>";
	echo "企画提案者:".$row['proposer']."<br>";
	echo "支援した日:".$row['time']."<br>";
	echo "<hr>";
}


		//削除、編集の機能実装

?>



<br><a href = 'mission_6_mypage.php'>マイページ</a>
</body>
</html> 
