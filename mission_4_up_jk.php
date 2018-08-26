<?php
//データベースに接続する
try{
	$dsn='データベース名';
	$user='ユーザー名';
	$password='パスワード';
	$pdo=new PDO(
	$dsn,$user,$password,
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//エラー投げる
            PDO::ATTR_EMULATE_PREPARES => false,//静的プレースホルダー
            )
            );
		
//それぞれの変数

    $name=$_POST['name'];//名前の変数
    $comment=$_POST['comment'];//コメントの変数
    $to_editing=$_POST['to_editing'];//編集対象番号先の変数
    $password1_post=$_POST['password1'];//パスワード１

    $delete = $_POST['delete'];//削除投稿番号の変数
    $password2_post=$_POST['password2'];//パスワード２

    $editing=$_POST['editing'];//編集投稿番号の変数
    $password3_post=$_POST['password3'];//パスワード３

    $date=date('Y-m-d H:i:s');//送信日時の変数

	//テーブルを作成する      
      $sql="CREATE TABLE IF NOT EXISTS table1"
. " ("
. "id mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,"
. "PRIMARY KEY(id),"//主キーの設定
. "name char(32),"
. "comment TEXT,"//文が入る(無限)
. "date TEXT,"
. "password TEXT"
. ");";
$stmt=$pdo->query($sql);

     
    //テーブルが作成できたか確認する。
     /*$is_table = $pdo -> query 'SHOW TABLES';
    foreach($is_table as $rows){
        print_r($rows) ."<br>";
    }
    */
    //意図したテーブルが作成できたか確認（中身まで見れる）
    /*$showcre_sql ='SHOW CREATE TABLE table1';
    $showcre_result = $pdo -> query($showcre_sql);
    foreach ($showcre_result as $row_1){ 
        print_r($row_1);
    }
    echo "<hr>";
    */

        //↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓データの入力↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        //コメントがあったら、パスワードがあったら、編集投稿先に入ってなかったら
        if(!empty($comment) && !empty($password1_post) && empty($to_editing)){
        $add_sql = $pdo->prepare("INSERT INTO table1(name,comment,date,password)VALUES(:name,:comment,:date,:password)");
        $add_sql->bindParam(':name',$name,PDO::PARAM_STR);
        $add_sql->bindParam(':comment',$comment,PDO::PARAM_STR);
        $add_sql->bindParam(':date',$date,PDO::PARAM_STR);
        $add_sql->bindParam(':password',$password1_post,PDO::PARAM_STR);
        $add_sql->execute();
        }
        
        
        //↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓削除機能↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
$dnum=false;
if(!empty($delete)&&(!empty($password2_post))){
    $sql2='SELECT*FROM table1';
    $result=$pdo->query($sql2);

    foreach ($result as $row){
        //echo $row['id']."<br>";
        //echo $delete."<br>";
                    if($row[0]==$delete){//削除番号を見つけたら
                        //echo "68Check";
                        if($password2_post==$row['password']){//パスワードを照合して
                            //echo "70Check";
                           $dnum=true;//合ってたら、下のif文(削除処理)が動くようにする
                        }
                    }
                }
        unset($row);
    
    if($dnum){
    echo '<br>'."$delete".'番を削除しました。';
    $sql_delete="DELETE FROM table1 WHERE id=$delete";
    $result=$pdo->query($sql_delete);
    }else{
        echo "パスワードが違います"."<br>";
    }
}
//↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓編集機能↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

    $enum=false;
    if(!empty($to_editing)){
        $sql_edit='SELECT*FROM table1';
        $result1=$pdo->query($sql_edit);
        foreach($result1 as $row){
                if($row[0]==$to_editing){
                    $enum=true;
                }
            }
        if($enum){
                echo '<br>'."$to_editing".'番を編集しました。';
                $sql_edit2=" UPDATE table1 set name='$name',comment='$comment' where id='$to_editing' ";
                $result1=$pdo->query($sql_edit2);
        }
        else{
        }
    }
    
    //編集するためにデータを持ってくる
    if(!empty($editing) && !empty($password3_post)){
        $sql_edit3='SELECT*FROM table1';
        $result=$pdo->query($sql_edit3);
        foreach($result as $row){
            if($password3_post==$row[4]){
                echo '<br>'.'上にデータを持っていくよ';
                $data1=$row['id'];
                $data2=$row['name'];
                $data3=$row['comment'];
            }
        }
    }
//キャッチ
}catch (PDOException $e) {      //エラーあったりしたら内容と行を表示してくれる
    echo $e->getMessage()." - ".$e->getLine().PHP_EOL;
}
?>
<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = UTF-8>
<title> ミッション4</title>
</head>
	<body>
	<form action = "mission_4_kanbe.php" method = "POST">
		<p><input type = "text"name = "name" maxlength="" placeholder="名前" value="<?php echo $data2;?>" ></p><!--名前の入力フォーム-->
		<p><input type = "text"name = "comment" maxlength="" placeholder="コメント" value="<?php echo $data3;?>" ></p><!--コメントの入力フォーム-->
		<p><input type = "text" name="to_editing" maxlength="" placeholder="編集対象番号先"value="<?php echo $data1;?>" ></p>
		<p><input type = "text"name="password1"maxlength=""value=""placeholder="パスワード"></p>
		<p><input type = "submit"value="送信"></p><!--送信ボタン--></p>
	</form>
<br>
	<form action = "mission_4_kanbe.php" method = "POST">
			<p><input type = "text"name = "delete" value = "" placeholder="削除投稿番号"></p><!--削除投稿番号の入力フォーム-->
			<p><input type = "text"name="password2"maxlength=""value=""placeholder="パスワード"></p>
			<p><input type = "submit"value="削除"</p><!--削除ボタン--></p>
	</form>
<br>
	<form action = "mission_4_kanbe.php" method = "POST">
			<p><input type = "text"name = "editing" value = "" placeholder="編集対象番号"></p><!--編集対象番号の入力フォーム-->
			<p><input type = "text"name="password3"maxlength=""value=""placeholder="パスワード"></p>
			<p><input type = "submit"value="編集"></p><!--編集ボタン-->
	</form>  
</body>
</html>
 <?php 
    //↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓入力したデータを表示↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $select_sql ='SELECT * FROM table1 ORDER BY id';
        $results = $pdo->query($select_sql);
        //方法１
        foreach($results as $row){
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].',';
            echo $row['date'].'<br>';
        }
?>
