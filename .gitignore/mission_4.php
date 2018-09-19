<?php
header('Content-Type: text/html; charaset=utf-8');
$name = ($_POST['name']);
$comment = ($_POST['comment']);
$delnum = ($_POST['delnum']);
$editnum = ($_POST['editnum']);
$editdo_num = ($_POST['editdo_num']);
$pass = ($_POST['pass']);
$editpass = ($_POST['editpass']);
$delpass = ($_POST['delpass']);

$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);

$sql="CREATE TABLE m4"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."jikan TEXT,"
."pass TEXT"
.");";
$stmt=$pdo->query($sql);

/*
//table delete
$sql='DROP TABLE dataTB';
$result=$pdo->query($sql);

$sql='SHOW TABLES';
$result=$pdo->query($sql);
foreach($result as $row){
 echo $row[0];
 echo '<br>';
 }
 echo "<hr>";

$sql='SHOW CREATE TABLE m4';
$result=$pdo->query($sql);
foreach($result as $row){
 print_r($row);
echo "<br />";
}
echo "<hr>";
*/




$jikan.=date("Y/m/d H:i:s");

//delnum（削除対象番号）が数字であった時の処理
if(is_numeric($delnum)){
 $sql="SELECT * FROM m4 WHERE id=$delnum";
$results=$pdo->query($sql);
foreach($results as $row){
$dopass=$row['pass'];
   }
  if($delpass==$dopass){
$id=$delnum;
$sql="delete from m4 where id=$id";
$result=$pdo->query($sql);
}
else{
echo "Password Error!!"."<br>";
}
}


//editnum(編集対象番号)が数字であった時の処理
elseif(is_numeric($editnum)){
 $sql="SELECT * FROM m4 WHERE id=$editnum";
$results=$pdo->query($sql);
foreach($results as $row){
$dopass=$row['pass'];
   }
  if($editpass==$dopass){

$sql="SELECT * FROM m4 WHERE id=$editnum";
$results=$pdo->query($sql);

foreach($results as $row){
$editdo_number=$row['id'];
$edit_name=$row['name'];
$edit_com= $row['comment'];
   }
}
else{
echo "Password Error!!"."<br>";
}

}

//編集実行
elseif(is_numeric($editdo_num)){
$id=$editdo_num;

$sql="update m4 set name='$name',comment='$comment',pass='$pass' where id=$id";
$result=$pdo->query($sql);


}
else{
    if(!empty($name)&&!empty($comment)&&!empty($pass)){

	$sql=$pdo->prepare("INSERT INTO m4 (name,comment,jikan,pass) VALUES (:name,:comment,:jikan,:pass)");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':jikan',$jikan,PDO::PARAM_STR);
	$sql->bindParam(':pass',$pass,PDO::PARAM_STR);

	$sql->execute();
	}
	else{}

 }
//debug データ表示
/*
echo "データは" ."<br>";
echo $name ."<br>";
echo $comment ."<br>";
echo $pass ."<br>";
echo $jikan ."<br>";
*/

?>

<!DOCTYPE html>
<html lang = "ja">
<head>
<meta Charaset="utf-8">
</head>
<body>
<form action = "mission_4.php" method = "post">
名前
<input type = "text" name = "name" value = "<?php echo $edit_name; ?>">
<br />
コメント
<input type = "text" name = "comment" value = "<?php echo $edit_com; ?>">
<br />
パスワード
<input type = "text" name = "pass">
<input type = "submit" value = "送信">
<br />
<input type = "hidden" name = "editdo_num" value = "<?php echo $editdo_number; ?>">
<br />
編集対象番号
<input type = "text" name = "editnum">
<br />
パスワード
<input type = "text" name = "editpass">
<input type = "submit" value = "編集">
<br />
<br />
削除対象番号
<input type = "text" name = "delnum">
<br />
パスワード
<input type = "text" name = "delpass">
<input type = "submit" value = "削除">
<br />

<?php
$sql='SELECT*FROM m4';
$results=$pdo->query($sql);
foreach($results as $row){
   echo $row['id'].',';
   echo $row['name'].',';
   echo $row['comment'].',';
   echo $row['jikan'].'<br>';

}
?>

</form>

