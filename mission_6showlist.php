<?php
session_start();

if(empty($_SESSION["userid"])){
	header("Location:https://tb-210614.tech-base.net/mission_6login.php");
	exit;
}

?>

<!DOCTYPE html>
<html lang = "ja">
<head>
	<meta charset = "UTF-8">
	<title>資料リスト</title>
</head>
<body>

<center><h1>資料リスト</h1></center>
<center>
<table border="1">
<tr>
<th>
<?php 

$message=" ";

$dsn = "database info";
$user = "username";
$password = "password";
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql="SELECT * FROM citation";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();

foreach($results as $show){
	echo $show["id"]." | ";
	echo $show["name"]." | ";
	echo $show["title"]." | ";
	echo $show["author"]." | ";
	echo $show["publication_date"]." | ";
	echo $show["date"]."<br>";
	echo "<hr>";
}

if(!empty($_POST["delete"])){

	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
		$id = $_POST["deletenumber"];
		$sql="DELETE FROM citation where id=:id";
		$stmt=$pdo->prepare($sql);
		$stmt->bindParam(":id",$id, PDO::PARAM_INT);
		
		if($stmt->execute() == true){
			$message="正常に削除されました";
		}
}
?>
</th>
</tr>
</table>
<form method="POST" action="mission_6showlist.php">
<input type="text" name="deletenumber" value="" placeholder="削除したい番号">
<input type ="submit" name="delete" value="削除"><?php echo $message; ?><br>
</form>
	<a href="https://tb-210614.tech-base.net/mission_6citation.php">入力画面に戻る</a>
</center>
</body>
</html>
