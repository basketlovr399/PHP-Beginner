<?php
session_start();

$errmsg1 = "";
$errmsg2 = "";

if(!empty($_POST["username"]) && !empty($_POST["password"])){

	$dsn = "database info";
	$user = "username";
	$password = "password";
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql = "SELECT * FROM register";
	$stmt = $pdo->query($sql);
	$result = $stmt->fetchall();
	foreach($result as $password){
		if($password["username"] == $_POST["username"] && password_verify($_POST["password"],$password["password"])){

			$_SESSION["userid"]=$password["name"];

			header("Location:https://tb-210614.tech-base.net/mission_6citation.php");
			exit;
		}else{
			$errmsg2 = "パスワードまたはユーザーネームが間違っています!!";
		}
	}

}

if(empty ($_POST["username"])){
	$errmsg1 =  "ユーザーネームを入力してください";
}
if(empty($_POST["password"])){
	$errmsg2 =  "パスワードを入力してください";
}

?>


<html>
<head>
	<title> みんなの資料！！ログイン </title>
	<meta charset = "UTF-8">
</head>
<body>
<center>
<h1>ようこそ！！</h1>
<h3>ログインしてください</h3>
<table border ="1">
	<form method = "POST" action = "mission_6login.php">
<tr>
<th>
	Username:<br>
	<input type = "text" name = "username" placeholder = "ユーザーネーム" value = ""><br><p style = "color:red;"><?php echo $errmsg1; ?></p><br>
	Password:<br>
	<input type = "password" name = "password" placeholder = "パスワード" value = ""><p style  ="color:red;"><?php echo $errmsg2; ?></p><br>
	<input type = "submit" name = "login" value = "ログイン"><br>
</th>
</tr>
</form>
</table>
	<a href="https://tb-210614.tech-base.net/mission_6 verify.php">新規登録はこちらへ</a>
</center>
</body>
</html>