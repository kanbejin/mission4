<?php
session_start();

//データベースに接続する
try{
	$dsn='mysql:dbname=tt_186_99sv_coco_com;host=localhost';
	$user='tt-186.99sv-coco.com';
	$password='v7EcBydM';
	$pdo=new PDO(
	$dsn,$user,$password,
	array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//エラー投げる
            PDO::ATTR_EMULATE_PREPARES => false,//静的プレースホルダー
            )
            );
            
//それぞれの変数

    $text=$_POST['text'];//名前の変数

        
    			//テーブルを作成する      
 $sql="CREATE TABLE IF NOT EXISTS toukou1"
. " ("
. "id mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,"
. "PRIMARY KEY(id),"//主キーの設定
. "text TEXT"
. ");";

$stmt=$pdo->query($sql);


        //↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓データの入力↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        //テキストあったら
        if(!empty($text)){
        $add_sql = $pdo->prepare("INSERT INTO
        toukou1(text)VALUES(:text)");
        $add_sql->bindParam(':text',$text,PDO::PARAM_STR);
        $add_sql->execute();
        }
        
        //キャッチ
}catch (PDOException $e) {      //エラーあったりしたら内容と行を表示してくれる
    echo $e->getMessage()." - ".$e->getLine().PHP_EOL;
}

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

$file_name = "file";

 if( !file_exists($file_name) ){
    // ファイル作成
    mkdir("$file_name",0755);
      echo "";//ファイル作成した
    }
    else if(file_exists($file_name)){
    echo "";//ファイルあった
    }
    else{
    echo "";//ダメです
    }
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>投稿画面</title>
              <style>
  body{
  background-image: url("aozora.png");
  animation: AnimationName 10s ease infinite;
  background-size: cover;
    background-attachment: fixed;
}
 
@keyframes AnimationName {
    0%{background-position:0% 30%}
    50%{background-position:100% 30%}
    100%{background-position:0% 30%}
}
 body {
    text-align:center;
    }
h1{
color:white;
}
 .alltoukoubotan {
    position: relative;
    display: inline-block;
    font-weight: bold;
    padding: 0.25em 0.5em;
    text-decoration: none;
    color: #FFFFFF;
    background: #000000;
    transition: .4s;
  }

.alltoukoubotan:hover {
    background: #00FF00;
}
 .Logoutbotan {
    position: relative;
    display: inline-block;
    font-weight: bold;
    padding: 0.25em 0.5em;
    text-decoration: none;
    color: #FFFFFF;
    background: #000000;
    transition: .4s;
  }

.Logoutbotan:hover {
    background: #00FF00;
}
 .mainbotan {
    position: relative;
    display: inline-block;
    font-weight: bold;
    padding: 0.25em 0.5em;
    text-decoration: none;
    color: #FFFFFF;
    background: #000000;
    transition: .4s;
  }

.mainbotan:hover {
    background: #00FF00;

</style>

    </head>
    <body>
        <center><h1><p>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん</p></h1></center>
                    <a href="main.php" class="mainbotan"><i class="fa fa-chevron-right"></i>メインページ</a>
                    <a href="alltoukou.php" class="alltoukoubotan"><i class="fa fa-chevron-right"></i>みんなの投稿</a>
                    <a href="Logout.php" class="Logoutbotan"><i class="fa fa-chevron-right"></i>ログアウト</a> 
        <hr size="5" color="##000000" noshade>
        
         <form action="alltoukou.php" method="post" enctype="multipart/form-data">
            <center><p><input type="file" name="upfile" accept="image/*,video/*"  ><input type = "submit"value="画像投稿"></p></center><!--画像投稿ボタン-->
	</form>
	<form action = "toukou.php" method = "POST">
		<center><p><textarea name="text" placeholder="ここに書いてください！"rows="4" cols="40"></textarea></p></center><!--投稿フォーム-->
				 <center><p><input type = "submit"value="投稿"></p></center><!--投稿ボタン-->
		</form>
    </body>
</html>
 