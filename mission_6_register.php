<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>クラファンM@STER 新規会員登録</title>
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

//テーブル一覧の表示
//$sql ='SHOW TABLES';
//        $result = $pdo -> query($sql);
//        foreach ($result as $row){
//                 echo $row[0];
//                 echo '<br>';
//        }
//        echo "<hr>"


?>


<!-- 新規登録フォーム -->
<h4>【新規会員登録】</h4>
<form action="" method="post">

<label for="name1">名前:</label>
<input id="name1" type="text" name="name" placeholder="ユーザー名">

<br><label for="pass-word1">パスワード：</label>
<input id="pass-word1" type="password" name="pass1" placeholder="パスワード">

<br><label for="email1">Eメール：</label>
<input id="email1" type="text" name="email" placeholder="E-mailアドレス">

<br><input type="submit" name="touroku" value="登録">
</form>


<?php
//新規会員登録の情報送信
	//フォーム内の空欄によるエラー表示
if(!empty($_POST["touroku"])){
	if($_POST["name"]==""){
	echo "【エラー】ユーザー名を入力してください<br>";
	}
	elseif($_POST["pass1"]==""){
	echo "【エラー】パスワードを入力してください<br>";
	}
	elseif($_POST["email"]==""){
	echo "【エラー】Eメールアドレスを入力してください<br>";
	}
}
echo "<br>";

if(!empty($_POST["name"])&&!empty($_POST["pass1"])&&!empty($_POST["email"])&&!empty($_POST["touroku"])){  
	session_start();
	$_SESSION['username'] = $_POST["name"];
	$_SESSION['password'] = $_POST["pass1"];
	$_SESSION['email'] = $_POST["email"];

        //メールの送信処理かつページ遷移
	require 'src/Exception.php';
	require 'src/PHPMailer.php';
	require 'src/SMTP.php';
	require 'mission_6_setting.php';

		// PHPMailerのインスタンス生成
    	$mail = new PHPMailer\PHPMailer\PHPMailer();

    	$mail->isSMTP(); // SMTPを使うようにメーラーを設定する
    	$mail->SMTPAuth = true;
    	$mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
    	$mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
    	$mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
    	$mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
    	$mail->Port = SMTP_PORT; // 接続するTCPポート

    		// メール内容設定
    	$mail->CharSet = "UTF-8";
    	$mail->Encoding = "base64";
    	$mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
    	$mail->addAddress($_SESSION['email'], $_SESSION['username']."様"); //受信者（送信先）を追加する
	//    $mail->addReplyTo('xxxxxxxxxx@xxxxxxxxxx','返信先');
	//    $mail->addCC('xxxxxxxxxx@xxxxxxxxxx'); // CCで追加
	//    $mail->addBcc('xxxxxxxxxx@xxxxxxxxxx'); // BCCで追加
    	$mail->Subject = MAIL_SUBJECT; // メールタイトル
    	$mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します
    	$body = $_SESSION['username']."様<br><br>この度はクラウドファンディングM@STERをご利用頂きありがとうございます。<br><br>以下のURLをクリックして本登録を完了してください。<br><br><a href = 'https://tb-210262.tech-base.net/mission_6_complete.php'>本登録をする</a>";

    	$mail->Body  = $body; // メール本文
    	// メール送信の実行
    	if(!$mail->send()) {
    		echo "<br>メッセージは送られませんでした。再度やり直してください。";
    		echo 'Mailer Error: ' . $mail->ErrorInfo;
    	} else {
    		echo "<br>送信完了が完了しました。送信したメール内URLから本登録を行ってください。";
    		}
}

?>

<br><a href = 'mission_6_login.php'>ログイン画面</a>

</body>
</html>
