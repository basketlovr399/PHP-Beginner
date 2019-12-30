
<?php
session_start();

if(empty($_SESSION["userid"])){
	header("Location:https://tb-210614.tech-base.net/mission_6login.php");
	exit;
}
$errmsg="";

	$dsn = "database info";
	$user = "username";
	$password = "password";
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql="CREATE TABLE IF NOT EXISTS citation"
		."("
		."id INT AUTO_INCREMENT PRIMARY KEY,"
		."name char(16),"
		."title TEXT,"
		."author char(100),"
		."publication_date char(25),"
		."date DATETIME"
		.");";
	$stmt=$pdo->query($sql);

if(empty($_POST["registerbook"])){

	$errmsg="空欄を埋めてください";

}elseif(!empty($_POST["registerbook"])){

	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql=$pdo->prepare("INSERT INTO citation (name, title, author, publication_date, date) VALUES (:name, :title, :author, :publication_date, :date)");
		$sql->bindParam(":name",$name, PDO::PARAM_STR);
		$sql->bindParam(":title", $title, PDO::PARAM_STR);
		$sql->bindParam(":author", $author, PDO::PARAM_STR);
		$sql->bindParam(":publication_date", $publication, PDO::PARAM_STR);
		$sql->bindParam(":date", $date, PDO::PARAM_STR);
		
		$name=$_POST["name"];
		$title=$_POST["title"];
		$author=$_POST["author"];
		$publication=$_POST["publication_date"];
		$date=date("Y/m/d, H:i:s");
	if($sql->execute () == true){
		header("Location:https://tb-210614.tech-base.net/mission_6showlist.php");
		exit;
	}
}

?>
<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset = "UTF-8">
	<title>資料入力</title>
</head>
<body>
<center><h1>資料登録<h1>
<h4>使用した資料を入力してください：）</h4>
<hr>
<table border= "2">
<form method="POST" action="mission_6citation.php">

<tr>
	<th>名前</th>
	<th><input type="text" name="name" value="" placeholder="">
</tr>
<tr>
	<th>タイトル</th>
	<th><textarea name="title" style ="width:200px; height:50px;"  cols="40" rows="3" value=""></textarea></th>
</tr>
<tr>
	<th>著者</th>
	<th><input type="text" name="author" value="" placeholder="">
</tr>
<tr>	
	<th>発行日</th>
	<th><input type="text" name="publication_date" value="" placeholder="ex. 01/01/2019">
</tr>
</table>
	<input type ="submit" name="registerbook" value="登録"></center>
</form>

<center><?php echo $errmsg."<br>"; ?>
<a href="https://tb-210614.tech-base.net/mission_6showlist.php">登録済みのリストへ</a>
</center>
      
</body>
</html>