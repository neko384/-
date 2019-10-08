<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER データベース確認用</title>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

echo "<br>登録ユーザーの情報<br><hr>";
//入力したデータをselectによって表示する。*マークは要素の全指定
$sql = 'SELECT * FROM user_information1';
$stmt = $pdo->query($sql);
//PDOStatementsを配列に変換している
$results = $stmt->fetchAll();
foreach ($results as $row){
//$row['カラム(フィールド)名']とし、各行(レコード)を一つずつ表示していく
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['password'].',';
	echo $row['email'].'<br>';
echo "<hr>";
}


echo "<br><br>クラウドファンディング内容<br><hr>";
$sql = 'SELECT * FROM crowdfunding_data';
$stmt = $pdo->query($sql);
//PDOStatementsを配列に変換している
$results = $stmt->fetchAll();
foreach ($results as $row){
//$row['カラム(フィールド)名']とし、各行(レコード)を一つずつ表示していく
	echo $row['id'].',';
	echo $row['crowdname'].',';
	echo $row['proposer'].',';
	echo $row['explanation'].',';
	echo $row['target_money'].',';
	echo $row['get_money'].',';
	echo $row['image'].',';
	echo $row['time'].',';
	echo $row['password'].'<br>';
echo "<hr>";
}

echo "<br><br>入金履歴<br><hr>";
$sql = 'SELECT * FROM funding_history1';
$stmt = $pdo->query($sql);
//PDOStatementsを配列に変換している
$results = $stmt->fetchAll();
foreach ($results as $row){
//$row['カラム(フィールド)名']とし、各行(レコード)を一つずつ表示していく
	echo $row['id'].',';
	echo $row['username'].',';
	echo $row['fundmoney'].',';
	echo $row['toukouid'].',';
	echo $row['fundname'].',';
	echo $row['proposer'].',';
	echo $row['time'].',';
	echo $row['password'].'<br>';
echo "<hr>";
}



?>
</body>
</html>