<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 企画削除画面</title>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>


<h4>本企画を削除しますか？</h4>
<form action="" method="post">

企画削除：
<input type="radio" name="funddelete">
<br><br><label for="password1">パスワード：</label>
<input id="password1" type="password" name="pass" placeholder="パスワード">

<br><br><input type="submit" name="delete" value="削除">


<?php
session_start();
//削除処理
if($_SERVER["REQUEST_METHOD"] === "POST"){
	//未記入エラーメッセージの表記
	if(empty($_POST["funddelete"])){
		echo "<br>【エラー】削除確認のチェックを入れてください<br>";
	}
	elseif($_POST["pass"]==""){
		echo "<br>【エラー】パスワードを入力してください<br>";
	}

	if(!empty($_POST["funddelete"])&&!empty($_POST["pass"])){
		$id = $_SESSION['deleteid'];  //削除投稿番号・パスワード
		$pass = $_POST["pass"];
		$user = $_SESSION['logname'];
		$delete = "";
		//テーブル内のレコードをfetchAllで配列化。pass,idの一致確認。
		$sql = 'SELECT * FROM crowdfunding_data';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if(($user == $row['proposer'])&&($id == $row['id'])&&($pass == $row['password'])){
				echo "【報告】投稿番号 ".$id." が削除されました。<br>";
				$delete = "完了";
			}
		}

		if($delete != "完了"){
			echo  "【エラー】パスワードが正しくありません<br>";
		}
			

		//プリペアドステートメントSQL文の準備
		//SQL文を実行し削除処理
		$sql = 'delete from crowdfunding_data where id = :id and password = :pass and proposer = :user';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
		$stmt->bindParam(':user', $user, PDO::PARAM_STR);
		$stmt->execute();    
		$_SESSION['deleteid'] = "";
	}
}
?>


<h4>【企画概要】</h4>
<?php
//該当する企画の表示
	if(!empty($_GET["id"])){
		$id = $_GET["id"];
	}

$sql = "SELECT * FROM crowdfunding_data WHERE id = $id";
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
	$nowmoney = $row['get_money'];
	$funding = $row['crowdname'];
	$toukou = $row['id'];
	$propose = $row['proposer'];
	$_SESSION['deleteid'] = $id;

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




<br><a href = 'mission_6_yourcrowd.php'>戻る</a>
<br><a href = 'mission_6_mypage.php'>マイページ</a>
</body>
</html> 
