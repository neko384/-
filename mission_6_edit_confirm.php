<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 編集内容確認画面</title>
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
//クラウドファンディングの投稿内容の確認
session_start();
if($_SESSION['edicrowdname']&&$_SESSION['ediproposer']&&$_SESSION['ediexplanation']&&$_SESSION['editarget_money']){
	echo "クラウドファンディングの新規立ち上げ内容の確認をしてください<br>";
	echo "<br>【変更後のクラウドファンディング内容】";
	echo "<br>投稿番号:".$_SESSION['ediid']."<br><br>クラウドファンディング名:".$_SESSION['edicrowdname']."<br><br>企画提案者:".$_SESSION['ediproposer']."<br><br>事業概要説明:".$_SESSION['ediexplanation']."<br><br>支援目標額:".$_SESSION['editarget_money']."円<br><br>イメージ画像<br>";
	
	//画像そのものをBASE64でエンコードし直接出力
	//BASE64のHTML埋め込みはdata URI schemeを用いる data:[メディアタイプ];[エンコード方式],[データ]
	if($_SESSION['ediimage'] != ""){
		$base64 = base64_encode($_SESSION['ediimage']);
		print "<img src = data:image/jpeg;base64,$base64 width='350' height='350'>";
	}else{
		echo "本クラウドファンディングの画像イメージはありません。";
	}
}
?>

<br><br>
この内容でクラウドファンディング内容を編集しますか？
<br><br>

<!--最終確認ボタン-->
<form action="mission_6_edit_complete.php" method="post">
<input type="submit" name="edit_decide" value="決定">

<br><br><a href = "mission_6_edit.php">戻る</a>


</body>
</html>