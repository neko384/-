<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 企画編集</title>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
?>


<!-- 編集フォーム -->
<h4>【クラウドファンディング  編集】</h4>
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
		$_SESSION['edicrowdname'] = $_POST["crowdname"];
		$_SESSION['ediproposer'] = $_POST["proposer"];
		$_SESSION['ediexplanation'] = $_POST["explanation"];
		$_SESSION['editarget_money'] = $_POST["target_money"];

		//画像のphp処理、croudimadeファイル内に画像を保存
		if(isset($_FILES)&& isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){
			if(!file_exists('corwdimage')){
				mkdir('crowdimage');
    			}
			//SESSION中にファイルの実データを格納(ファイルパスの格納ではないのでそのままSESSIONをmove_には使えない)
			$img = file_get_contents($_FILES['image']['tmp_name']);
			$_SESSION['ediimage'] = $img;
			
			//画像を一時ファイルから通常のファイルに移動
			$a = 'crowdimage/' . basename($_FILES['image']['name']);
			$_SESSION['ediimagepath'] = $a;
			if(move_uploaded_file($_FILES['image']['tmp_name'], $a)){
        			http_response_code(301);
				header("Location: mission_6_edit_confirm.php");
				exit;
			}else {
			$msg = '画像のアップロードに失敗しました。再試行してください。';
			echo $msg;
			}
		}else{
			$_SESSION['ediimage'] = "";
			$_SESSION['ediimagepath'] = "";
			http_response_code(301);
			header("Location: mission_6_edit_confirm.php");
			exit;
		}
	}

}
?>



<h4>【編集する企画の概要】</h4>

<?php
//該当する企画の表示
	if(!empty($_GET["id"])){
		$id = $_GET["id"];
	}
$_SESSION['ediid'] = $id;

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

?>





<br><a href = 'mission_6_yourcrowd.php'>戻る</a>
<br><a href = 'mission_6_mypage.php'>マイページ</a>
</body>
</html> 
