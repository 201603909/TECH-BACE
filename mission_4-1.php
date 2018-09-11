<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>WEB掲示板</title>
</head>

<?php

//データベース接続
$dsn = 'データーベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//テーブル作成
$sql = "CREATE TABLE tb4_1"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."pass char(32)"
.");";
$stmt = $pdo->query($sql);


//書き込み
if(!empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['pass'])){
	
	//編集の場合
	if(!empty($_POST['edit_num'])){
	$id = $_POST['edit_num'];
	$nm = $_POST['name'];
	$kome = $_POST['comment'];
	$ps = $_POST['pass'];
	$sql = "update tb4_1 set name='$nm',comment='$kome',pass='$ps' where id=$id";
	$result = $pdo->query($sql);
	
	
	//通常の場合
	}else{
	
	$sql = $pdo->prepare("INSERT INTO tb4_1 (name,comment,date,pass) VALUES(:name,:comment,:date,:pass)");
	$sql -> bindParam(':name',$name,PDO::PARAM_STR);
	$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql -> bindParam(':date',$date,PDO::PARAM_STR);
	$sql -> bindParam(':pass',$pass,PDO::PARAM_STR);
	$name = $_POST['name'];
	$comment = $_POST['comment'];
	$date = date( "Y/m/d H:i:s" );
	$pass = $_POST['pass'];
	$sql -> execute();
	}
}


//編集番号が一致したデータの受け取り
if(!empty($_POST['edit'])){

	//パスワード取得
	if(!empty($_POST['pass_e'])){
	$id = $_POST['edit'];
	$sql = "SELECT * FROM tb4_1 where id=$id";
	$stmt = $pdo -> query($sql);
	$result = $stmt -> fetch();
	$pass = $result['pass'];

		//パスワード一致
		if($_POST['pass_e'] == $pass){
		$id = $_POST['edit'];
		$sql = "SELECT * FROM tb4_1 where id=$id";
		$stmt = $pdo -> query($sql);
		$result = $stmt -> fetch();
		$date_id = $result['id'];
		$date_nm = $result['name'];
		$date_kome = $result['comment'];
		$date_ps = $result['pass'];

		//パスワード不一致
		}else{
		echo '<FONT COLOR="RED">正しいパスワードを入力してください。</FONT>';
		}

	//パスワード未入力
	}else{
	echo '<FONT COLOR="RED">パスワードを入力してください。</FONT>';
	}
}



//削除
if(!empty($_POST['del'])){
	
	//パスワード取得
	if(!empty($_POST['pass_d'])){
	$id = $_POST['del'];
	$sql = "SELECT * FROM tb4_1 where id=$id";
	$stmt = $pdo -> query($sql);
	$result = $stmt -> fetch();
	$pass = $result['pass'];
	echo $pass_d;

		//パスワード一致
		if($_POST['pass_d'] == $pass){
		$id = $_POST['del'];
		$sql = "delete from tb4_1 where id=$id";
		$result = $pdo->query($sql);
		
		//パスワード不一致
		}else{
		echo '<FONT COLOR="RED">正しいパスワードを入力してください。</FONT>';
		}

	//パスワード未入力
	}else{
	echo '<FONT COLOR="RED">パスワードを入力してください。</FONT>';
	}
}

?>

<form method="post" action="mission_4-1.php">
<label>名前:<input type="text"name="name"placeholder="名前を入力"value="<?php echo $date_nm;?>"></label><br>
<label>コメント:<input type="text"name="comment"placeholder="コメントを入力"value="<?php echo $date_kome;?>"></label><br>
<label>パスワード:<input type="text"name="pass"placeholder="パスワードを入力"value="<?php echo $date_ps;?>"></label><br>
<input type="hidden"name="edit_num"value="<?php echo $date_id;?>">
<input type="submit" value="送信"><br>
<br>
<br>
<label>編集:<input type="text"name="edit"placeholder="編集対象番号を入力"></label><br>
<label>パスワード:<input type="text"name="pass_e"placeholder="パスワードを入力"></label><br>
<input type="submit" value="編集"><br>
<br>
<label>削除:<input type="text"name="del"placeholder="削除対象番号を入力"></label><br>
<label>パスワード:<input type="text"name="pass_d"placeholder="パスワードを入力"></label><br>
<input type="submit" value="削除"><br>
<br>
</form>
</HTML>


<?php
//データ表示
$sql = 'SELECT * FROM tb4_1';
$results = $pdo -> query($sql);
foreach($results as $row){
echo $row['id'].' ';
echo $row['name'].' ';
echo $row['comment'].' ';
echo $row['date'].'<br>';
}
?>
