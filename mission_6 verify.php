<?php 

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'setting.php';


	$dsn = "database info";
	$user = "username";
	$password = "password";
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS preregister"
	."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."name char(32),"
	."mail char(128)"
	.");";
	$stmt = $pdo->query($sql);



if(empty($_POST["submit"])){
	$errmsg = "メールアドレスを入力してください";
}


//変数を定義
$submit="";
$email="";
$errmsg ="";
$message="";

if(!empty($_POST["submit"])){

// PHPMailerのインスタンス生成
		    	$mail = new PHPMailer\PHPMailer\PHPMailer();
		
	    		$mail->isSMTP(); 
	    		$mail->SMTPAuth = true;
	    		$mail->Host = MAIL_HOST; 
	    		$mail->Username = MAIL_USERNAME; 
	    		$mail->Password = MAIL_PASSWORD; 
	   	 	$mail->SMTPSecure = MAIL_ENCRPT; 
	   	 	$mail->Port = SMTP_PORT; 

// メール内容設定
	    		$mail->CharSet = "UTF-8";
	    		$mail->Encoding = "base64";
	    		$mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
	    		$mail->addAddress($_POST["email"], $_POST["name"]); 
	    		$mail->Subject = MAIL_SUBJECT; 
	    		$mail->isHTML(true);    
	    		$body = "仮登録は完了しました。以下のリンクから本登録を本登録を行ってください。"."<br>"."URL here";
	
	    		$mail->Body  = $body; // メール本文
    // メール送信の実行
	    	    if(!$mail->send()) {
		    	$errmsg='メッセージは送られませんでした！';
		    	echo 'Mailer Error: ' . $mail->ErrorInfo;
	   	    } else {
			       $message="送信完了！メールを確認してください";

			//データベースに入力、保存(仮登録)
			$dsn = "database info";
			$user = "username";
			$password = "password";
			$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

			$prereg = $pdo -> prepare("INSERT INTO preregister (name, mail) VALUES (:name, :mail)");
			$prereg ->bindParam(":name", $name, PDO::PARAM_STR);
			$prereg ->bindParam(":mail", $email, PDO::PARAM_STR);
			$name = $_POST["name"];
			$email = $_POST["email"];
			$prereg -> execute();
		    }
}


?>

<html>
<head>
	<title> 仮登録</title>
	<meta charset = "UTF-8">
</head>
<body>
<center>
<h2>認証メールを送ります</h2>
<p>以下の項目を埋めて、確認、本登録のほうをお願いします！！</p>
<table border="1">
<form method = "POST" action = "mission_6 verify.php">
<tr>
	<th>名前</th>
	<th><input type = "text" name = "name" placeholder = "名前" value = "">
</tr>
<tr>
	<th>メールアドレス</th>
	<th><input type = "text" name = "email" placeholder = "メールアドレス" value = "" size = "80">
</tr>
</table>
<br><input type = "submit" name = "submit" value = "送信"><br>
</form>
<hr><br>

<?php echo $errmsg; 
      echo $message;
?>
</center>
</body>
</html>
