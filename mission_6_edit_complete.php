<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 編集確定</title>
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
if($_SERVER["REQUEST_METHOD"] === "POST"){
	//投稿内容をデータベースに加える。
	$complete = "";
	$sql = $pdo->prepare("update crowdfunding_data set crowdname=:crowdname, proposer=:proposer, explanation=:explanation, target_money=:target_money, image=:image, time=:time, password=:password where id=:id");
	$sql -> bindParam(':crowdname', $crowdname, PDO::PARAM_STR);
	$sql -> bindParam(':proposer', $proposer, PDO::PARAM_STR);
	$sql -> bindParam(':explanation', $explanation, PDO::PARAM_STR);
	$sql -> bindParam(':target_money', $target_money, PDO::PARAM_STR);
	$sql -> bindParam(':image', $image, PDO::PARAM_STR);
	$sql -> bindParam(':time', $date, PDO::PARAM_STR);
	$sql -> bindParam(':password', $password, PDO::PARAM_STR);
	$sql -> bindParam(':id', $editid, PDO::PARAM_STR);

	session_start();
	$crowdname = $_SESSION['edicrowdname'];
	$proposer = $_SESSION['ediproposer'];
	$explanation = $_SESSION['ediexplanation'];
	$target_money = $_SESSION['editarget_money'];
	$image = $_SESSION['ediimagepath'];
	$date = date("Y-m-d H:i:s");
	$password = $_SESSION['logpass'];
	$editid = $_SESSION['ediid'];
	$sql -> execute();


	//本当に登録されたかの確認をセッションの中身とデータベースで比較
	$sql = 'SELECT * FROM crowdfunding_data';
	$stmt = $pdo->query($sql);
	foreach ($stmt as $row){
		if(($row['crowdname']==$_SESSION['edicrowdname'])&&($row['proposer']==$_SESSION['ediproposer'])&&($row['explanation']==$_SESSION['ediexplanation'])&&($row['target_money']==$_SESSION['editarget_money'])&&($row['password']==$_SESSION['logpass'])){
			echo "投稿番号:".$_SESSION['ediid'].'クラウドファンディング企画:'.$_SESSION['edicrowdname']."の編集が完了しました。<br>";
			$complete = "完了";
		}
	}

	//エラーメッセージの表記
	if($complete != "完了"){
		echo "<br>クラウドファンディングの編集に失敗しました。始めから行ってください<br>";
		echo "<br><a href = 'mission_6_edit.php'>クラウドファンディング編集</a>";
	}

	//セッションの中身を空白化
	$_SESSION['edicrowdname'] = "";
	$_SESSION['ediproposer'] = "";
	$_SESSION['ediexplanation'] = "";
	$_SESSION['editarget_money'] = "";
	$_SESSION['ediimagepath'] = "";
	$_SESSION['ediid'] = "";
	$_SESSION['ediimage'] = "";
}
?>

<br><a href = 'mission_6_yourcrowd.php'>あなたのクラウドファンディング</a>
<br><a href = 'mission_6_mypage.php'>マイページ</a>


</body>
</html>