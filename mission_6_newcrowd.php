<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 新規立ち上げ</title>
</head>
<body>

<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>

<!-- 新規立ち上げフォーム -->
<h4>【クラウドファンディング  新規立ち上げ】</h4>
<form action="" method="post" enctype="multipart/form-data">

<label for="crowdname1">クラウドファンディング名:</label><br>
<input id="crowdname1" type="text" name="crowdname" placeholder="クラウドファンディング名">

<br><br>

<label for="crowdname1">企画提案者:</label><br>
<input id="crowdname1" type="text" name="proposer" value = "<?php 
session_start();
echo htmlspecialchars($_SESSION['logname']); 
?>">

<br><br>

<label for="explanation1">事業概要説明:</label><br>
<input id="explanation1" type="text" name="explanation" placeholder="概要説明">

<br><br>

<label for="target_money1">支援目標額:</label><br>
<input id="target_money1" type="number" name="target_money" placeholder="いくら">円

<br><br>

<label for="image1">イメージ画像:</label><br>
<input id="image1" type="file" name="image" >

<br><br><input type="submit" name="decide" value="決定">


<?php
//投稿処理
	//未記入エラーメッセージ
if($_SERVER["REQUEST_METHOD"] === "POST"){		//何かがPOST送信されたら
	if($_POST["crowdname"]==""){
	echo "【エラー】クラウドファンディング名を入力してください<br>";
	}
	elseif($_POST["proposer"]==""){
	echo "【エラー】企画提案者名を入力してください<br>";
	}
	elseif($_POST["explanation"]==""){
	echo "【エラー】事業概要説明を入力してください<br>";
	}
	elseif($_POST["target_money"]==""){
	echo "【エラー】支援目標額を設定してください<br>";
	}
}

echo "<br>";


if($_SERVER["REQUEST_METHOD"] === "POST"){
	//投稿内容を一旦SESSION中に保管 
	if(!empty($_POST["crowdname"])&&!empty($_POST["proposer"])&&!empty($_POST["explanation"])&&!empty($_POST["target_money"])){  
		$_SESSION['crowdname'] = $_POST["crowdname"];
		$_SESSION['proposer'] = $_POST["proposer"];
		$_SESSION['explanation'] = $_POST["explanation"];
		$_SESSION['target_money'] = $_POST["target_money"];

		//画像のphp処理、croudimadeファイル内に画像を保存
		if(isset($_FILES)&& isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){
			if(!file_exists('corwdimage')){
				mkdir('crowdimage');
    			}
			//SESSION中にファイルの実データを格納(ファイルパスの格納ではないのでそのままSESSIONをmove_には使えない)
			$img = file_get_contents($_FILES['image']['tmp_name']);
			$_SESSION['image'] = $img;
			
			//画像を一時ファイルから通常のファイルに移動
			$a = 'crowdimage/' . basename($_FILES['image']['name']);
			$_SESSION['imagepath'] = $a;
			if(move_uploaded_file($_FILES['image']['tmp_name'], $a)){
        			http_response_code(301);
				header("Location: mission_6_newcrowd_confirm.php");
				exit;
			}else {
			$msg = '画像のアップロードに失敗しました。再試行してください。';
			echo $msg;
			}
		}else{
			$_SESSION['image'] = "";
			$_SESSION['imagepath'] = "";
			http_response_code(301);
			header("Location: mission_6_newcrowd_confirm.php");
			exit;
		}
	}

}
?>

<br><a href = "mission_6_mypage.php">マイページに戻る</a>

</body>
</html>