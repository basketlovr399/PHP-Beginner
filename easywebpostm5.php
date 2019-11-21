<?php 
//DBに接続とテーブル作成
$dsn = "データベース名";
$user = "ユーザー名";
$password = "パスワード";
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql="CREATE TABLE IF NOT EXISTS mission5"
	."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."name char(32),"
	."comment TEXT,"
	."date DATETIME,"
	."pass TEXT"
	.");";
$stmt = $pdo->query($sql);


//新規投稿
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && empty($_POST["commentNumber"])){
	$dsn = "データベース名";
	$user = "ユーザー名";
	$password = "パスワード";
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = $pdo->prepare("INSERT INTO mission5 (name, comment, date, pass) VALUES(:name, :comment, :date, :pass)");
	$sql->bindParam(":name", $name, PDO::PARAM_STR);
	$sql->bindParam(":comment", $comment, PDO::PARAM_STR);
	$sql->bindParam(":date", $date, PDO::PARAM_STR);
	$sql->bindParam(":pass", $password2, PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$date = date("Y/m/d, H:i:s");
	$password2 = $_POST["password"];
	$sql->execute();
}
//削除機能
if(!empty($_POST["delete"]) && !empty($_POST["deletepass"])){
	$dsn = "データベース名";
	$user = "ユーザー名";
	$password = "パスワード";
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$delnum = "SELECT * FROM mission5";
	$deletepass = $pdo->query($delnum);
	$deleteresult = $deletepass->fetchall();
	foreach($deleteresult as $delete){
		if($_POST["deletepass"] == $delete["pass"]){
			$id = $_POST["delete"];
			$sql = "DELETE FROM mission5 where id=:id";
			$stmt = $pdo->prepare($sql);
			$stmt -> bindParam(":id", $id, PDO::PARAM_INT);
			$stmt -> execute();

		}
	}
}
//編集番号を獲得
if(!empty($_POST["editnumber"])){
	$dsn = "データベース名";
	$user = "ユーザー名";
	$password = "パスワード";
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql = "SELECT * FROM mission5";
	$stmt = $pdo->query($sql);
	$editresult = $stmt->fetchall();
	foreach($editresult as $editpost){
		if($_POST["editnumber"] == $editpost["id"] && $editpost["pass"] == $_POST["editpass"]){
			$edit_number = $editpost["id"];
			$newname = $editpost["name"];
			$newcomment= $editpost["comment"];
		}
	}
}
//編集実行
if(!empty($_POST["commentNumber"]) && !empty($_POST["password"])){
	$dsn = "データベース名";
	$user = "ユーザー名";
	$password = "パスワード";
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql = "SELECT * FROM mission5";
	$stmt = $pdo->query($sql);
	$editdata = $stmt->fetchall();
	foreach($editdata as $edittext){
		if($_POST["commentNumber"] == $edittext["id"]){

			$id = $_POST["commentNumber"]; 
			$name = $_POST["name"];
			$comment = $_POST["comment"]; 
			$date = date("Y/m/d, H:i:s");
			$newpass = $_POST["password"];
			$slq = "update mission5 set name=:name,comment=:comment,date=:date,pass=:pass where id=:id";
			$update = $pdo->prepare($slq);
			$update->bindParam(":name", $name, PDO::PARAM_STR);
			$update->bindParam(":comment", $comment, PDO::PARAM_STR);
			$update->bindParam(":date", $date, PDO::PARAM_STR);
			$update->bindParam(":pass", $newpass, PDO::PARAM_STR);
			$update->bindParam(":id", $id, PDO::PARAM_INT);
			$update->execute();

		}
	}
}
?>
<html>
<head>
	<title> MySQL Practice Internet Forum </title>
	<meta charset="utf-8">
</head>
<body>

<h1>>POSTFORUMS></h1>
<hr>
<form method = "POST" action = "mission_5-1.php">
-----名前-----<br>
<input type = "text" name = "name" placeholder = "名前" value = "<?php if(!empty($_POST["submitedit"])) { echo $newname; }else{} ?>" ><br>
-----コメント-----<br>
<input type = "text" name = "comment" placeholder = "コメント" value = "<?php  if(!empty($_POST["submitedit"])){ echo $newcomment; }else{} ?>"size = "70" ><br>
<input type = "hidden" name = "commentNumber" value = "<?php if(!empty($_POST["submitedit"])) { echo $edit_number; }else{} ?>" >
<input type = "password" name = "password" placeholder = " パスワード">
<input type = "submit" name = "submitcomment" value = "送信"><br>
-----編集-----<br>
<input type = "text" name = "editnumber" placeholder = "編集番号" value = ""><br>
<input type = "password" name = "editpass" placeholder = "パスワード" value = "">
<input type = "submit" name = "submitedit" value = "編集"><br>
-----削除-----<br>
<input type = "text" name = "delete" placeholder = "削除指定番号" value = ""><br>
<input type = "password" name = "deletepass" placeholder = "パスワード" value = "">
<input type = "submit" name = "deletecomment" value = "削除"><br>
<hr><br>
</form>
<?php
//表示機能
	$dsn = "データベース名";
	$user = "ユーザー名";
	$password = "パスワード";
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = "SELECT * FROM mission5";
	$stmt = $pdo->query($sql);
	$result = $stmt->fetchall();
foreach($result as $post){
	echo $post["id"]." ";
	echo $post["name"]." ";
	echo $post["comment"]." ";
	echo $post["date"]."<br>";
}
?>
</body>
</html>
