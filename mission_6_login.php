<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER ログイン画面</title>

<style>
body	{
		background-color: #fffafa; 
		font-family: arial;
	}

div	{
		background-color: #ffffff;
		width: 400px;
		padding: 20px;
		text-align: center;
		border: 7px ridge #B0E0E6; 
		margin: 65px 450px 100px 450px;
	}

a	{
		color: #f75065;
	}

p	{
		font-size:40px;
		color:#4169E1;
		text-align: center;
	}

</style>
</head>
<body>


<?php
//MySQL内のデータベースへの接続(pdoの構築)
$dsn='mysql:dbname=データベース名; host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


//ユーザー情報のテーブルを作成 （SHOW TABLEで確認すべし）
$sql = "CREATE TABLE IF NOT EXISTS user_information1"
." ("
."id INT AUTO_INCREMENT PRIMARY KEY,"  
."name varchar(50),"
."password TEXT,"
."email varchar(50)"
.");";
$stmt = $pdo->query($sql);
?>


<!-- ログインフォーム -->
<p>クラウドファンディングHP<p>
<div>
<h4>【ログイン】</h4>
<form action="" method="post">

<label for="name1">ユーザー名:</label>
<input id="name1" type="text" name="name" placeholder="ユーザー名">

<br><br><label for="pass-word1">パスワード：</label>
<input id="pass-word1" type="password" name="pass1" placeholder="パスワード">

<br><br><input type="submit" name="login" value="ログイン">

<br><br>新規登録の方は<a href = "mission_6_register.php">こちら</a>

<p><p><h4>【管理者ログイン】</h4>
管理者名：<input type="TEXT" name="master" placeholder="管理者名">

<br>パスワード：
<input type="password" name="pass4" placeholder="パスワード">

<p><input type="submit" name="mastersubmit" value="管理者ログイン">
<p><p>

</form>
</div>

<?php
//新規会員登録の情報送信
	//フォーム内の空欄によるエラー表示
if(!empty($_POST["login"])){
	if($_POST["name"]==""){
	echo "【エラー】ユーザー名を入力してください<br>";
	}
	elseif($_POST["pass1"]==""){
	echo "【エラー】パスワードを入力してください<br>";
	}
}

//プリペアドステートメントSQL文の準備
if(!empty($_POST["name"])&&!empty($_POST["pass1"])&&!empty($_POST["login"])){  
	$username = $_POST["name"];  //
	$pass = $_POST["pass1"];
	$login = "";

	//POST内容とデータベースの情報の比較
	$sql = 'SELECT * FROM user_information1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		if(($username == $row['name'])&&($pass == $row['password'])){
			$login = "ログイン完了";
			
			session_start();
			$_SESSION['logname'] = $_POST["name"];
			$_SESSION['logpass'] = $_POST["pass1"];
			$_SESSION['logtime'] = date("Y-m-d H:i:s");
			http_response_code(301);		//ステータスコードの指定 301はページ遷移
			header("Location: mission_6_mypage.php");
			exit;					//exit処理しないとこのphpの処理が継続になる
		}
	}
	//ユーザー名・パスワードの不一致によるエラー
	if($login != "ログイン完了"){
		echo  "【エラー】ユーザー名とパスワードが一致していません。<br>再度入力してください。";
	}
}

//管理者ページへの遷移を用意することでデータベース内のテーブルの内容管理
$masterpass = "neko";
$mastername = "三橋";
if(!empty($_POST["master"])&&!empty($_POST["mastersubmit"])&&!empty($_POST["pass4"])){
	if(($masterpass == $_POST["pass4"])&&($mastername == $_POST["master"])){
		http_response_code(301);	
		header("Location: mission_6_masterpage.php");
		exit;
	}else{
		echo "管理者名もしくはパスワードが間違っています。";
	}
}

//管理者ログイン用のエラーメッセージ
if(!empty($_POST["mastersubmit"])){
	if(($_POST["master"]=="")){
	echo "【エラー】管理者名を入力してください<br>";
	}
	elseif($_POST["pass4"]==""){
	echo "<br>【エラー】管理者パスワードを入力してください<br>";
	}
}


?>

</body>
</html>
