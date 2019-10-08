<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 支援画面</title>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>

<?php
//支援金の管理用テーブルの作成
$sql = "CREATE TABLE IF NOT EXISTS funding_history1"
." ("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."username varchar(1000),"
."fundmoney INT,"
."toukouid INT,"
."fundname varchar(1000),"
."proposer varchar(1000),"
."time DATETIME,"
."password varchar(1000)"
.");";
$stmt = $pdo->query($sql);
?>


<!-- 入金フォーム -->
<h4>【入金フォーム】</h4>
<form action="" method="post">

<label for="name">ユーザー名:</label>
<input id="name" type="text" name="supname" placeholder="ユーザー名">

<br><br><label for="password">パスワード：</label>
<input id="password" type="password" name="suppass" placeholder="パスワード">

<br><br><label for="money">支援額：</label>
<input id="money" type="number" name="supmoney" placeholder="支援額">円


<br><br><input type="submit" name="support" value="支援"><br><br>
</form>


<h4>【企画概要】</h4>


<?php
//該当する企画の表示
	if(!empty($_GET["id"])){
		$id = $_GET["id"];
	}
session_start();
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


//ユーザー認証
	//フォーム内の空欄によるエラー表示
if($_SERVER["REQUEST_METHOD"] === "POST"){
	if($_POST["supname"]==""){
	echo "【エラー】ユーザー名を入力してください<br>";
	}
	elseif($_POST["suppass"]==""){
	echo "【エラー】パスワードを入力してください<br>";
	}
	elseif($_POST["supmoney"]==""){
	echo "【エラー】支援金額を入力してください<br>";
	}
}

if(!empty($_POST["supname"])&&!empty($_POST["suppass"])&&!empty($_POST["supmoney"])){  
	$username = $_POST["supname"];  //
	$pass = $_POST["suppass"];
	$fundmoney = $_POST["supmoney"];
	$money = $fundmoney + $nowmoney;
	$sup = "";
	$toukouid = $toukou;
	//ログイン中のユーザーか確認
	if(($_SESSION['logname'] == $username)&&($_SESSION['logpass'] == $_POST["suppass"])){
		//ここに支援金を足したうえで上書き
		$sql = 'update crowdfunding_data set get_money=:get_money where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':get_money', $money, PDO::PARAM_INT);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$mes = "支援金".$fundmoney."円の入金が完了しました。<br>";

		//支援金テーブル内にデータ送信
		$sql = $pdo->prepare("INSERT INTO funding_history1 (username, fundmoney, toukouid, fundname, proposer, time, password) VALUES (:username, :fundmoney, :toukouid, :fundname, :proposer, :time, :password)");
		$sql -> bindParam(':username', $username, PDO::PARAM_STR);
		$sql -> bindValue(':fundmoney', $fundmoney, PDO::PARAM_INT);
		$sql -> bindValue(':toukouid', $toukouid, PDO::PARAM_INT);
		$sql -> bindParam(':fundname', $fundname, PDO::PARAM_STR);
		$sql -> bindParam(':proposer', $proposer, PDO::PARAM_STR);
		$sql -> bindParam(':time', $date, PDO::PARAM_STR);
		$sql -> bindParam(':password', $password, PDO::PARAM_STR);

		$username = $_SESSION['logname'];
		$fundname = $funding;
		$proposer = $propose;
		$date = date("Y-m-d H:i:s");
		$password = $_SESSION['logpass'];
		$sql -> execute();
	
	}else{  
		$mes = "<br>【エラー】ユーザー名とパスワードがログイン中のアカウントと一致していません。<br>再度入力してください。<br>";
	}
	echo $mes;
}



?>




<br><a href = 'mission_6_nowholding.php'>一覧に戻る</a>
<br><a href = 'mission_6_mypage.php'>マイページ</a>


</body>
</html>