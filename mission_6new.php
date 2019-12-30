<?php
//DB接続
$dsn = "database info";
$user = "username";
$password = "password";
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//テーブル作成
	$sql="CREATE TABLE IF NOT EXISTS register"
		."("
		."id INT AUTO_INCREMENT PRIMARY KEY,"
		."name char(16),"
		."username char(128),"
		."password char(200)"
		.");";
	$stmt=$pdo->query($sql);
//変数を定義
$errmsg ="";
$errmsg1 ="";
$errmsg2 = "";
$message = "";

if(empty($_POST["mail"])){
	$errmsg1 = "仮登録で使ったメールアドレスを入れてください";
}
if(empty($_POST["password"])){
	$errmsg2 = "パスワードを決めてください";
}
if(empty($_POST["submit"])){
	$errmsg = "空欄を埋めてください！！";
}
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


if(!empty($_POST["name"]) and !empty($_POST["mail"]) and !empty($_POST["password"])){

		//本登録のテーブルに保存
		$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
	
		$sql = $pdo->prepare("INSERT INTO register (name, username, password) VALUES(:name, :username, :password)");
			$sql -> bindParam(":name", $name, PDO::PARAM_STR);
			$sql -> bindParam(":username", $username, PDO::PARAM_STR);
			$sql -> bindParam(":password", $pass, PDO::PARAM_STR);
			$name = $_POST["name"];
			$username = $_POST["mail"];
			$pass =password_hash($_POST["password"], PASSWORD_DEFAULT);
		
			if($sql -> execute() == true){	
			
				$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
					$mail = $_POST["mail"];
					$sql = "delete from preregister where mail=:mail";
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
					$stmt->execute();

				$message = "登録が完了しました!!以下のリンクでログイン画面に戻ってください!!";

			}else{
				$message = "もう一度入力してください";
			}
}	
?>

<html>
<head>
	<title> 新規登録 </title>
	<meta charset = "UTF-8">
</head>
<body>
<center>
<h2>以下の項目を埋めてください</h2>
<table border ="1">
<form method = "POST" action = "mission_6new.php">
<tr>
	<th>名前：</th>
	<th><input type "text" name = "name" value = "" >
</tr>
<tr>
	<th>登録用メールアドレス(ユーザーネーム):</th>
	<th><input type = "text" name = "mail" value = ""><br><?php echo $errmsg1; ?>
</tr>
<tr>
	<th>パスワード:<br></th>
	<th><input type = "password" name = "password" value = ""><br><?php echo $errmsg2; ?>
</tr>
</table>
	<input type = "submit" name = "submit" value = "登録">
</form>
<?php echo $message."<br>" ; 
      echo $errmsg;
?><br>
<a href="https://tb-210614.tech-base.net/mission_6login.php">ログイン画面に戻る</a></center>
</body>
</html>
