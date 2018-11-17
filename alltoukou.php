<?php
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

}catch (PDOException $e) {      //エラーあったりしたら内容と行を表示してくれる
    echo $e->getMessage()." - ".$e->getLine().PHP_EOL;
}
?>
<!DOCTYPE html>
<html lang = "ja">
<head>
<meta charset = UTF-8>
<title>みんなの投稿</title>
</head>
        <style>
  body{
  background-image: url("aozora.png");
  animation: AnimationName 10s ease infinite;
  background-size: cover;
    background-attachment: fixed;
}
 body {
    text-align:center;
    }
 
@keyframes AnimationName {
    0%{background-position:0% 30%}
    50%{background-position:100% 30%}
    100%{background-position:0% 30%}
}
div{
color:white;
}
h1{
color:white;
}
 .toukoubotan {
    position: relative;
    display: inline-block;
    font-weight: bold;
    padding: 0.25em 0.5em;
    text-decoration: none;
    color: #FFFFFF;
    background: #000000;
    transition: .4s;
  }

.toukoubotan:hover {
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
	<body>
	             <center><h1>~みんなの投稿~</h1></center>
                <a href="main.php" class="mainbotan"><i class="fa fa-chevron-right"></i>メインページ</a>
                <a href="toukou.php" class="toukoubotan"><i class="fa fa-chevron-right"></i>投稿ページ</a>
                <a href="Logout.php" class="Logoutbotan"><i class="fa fa-chevron-right"></i>ログアウト</a>
        <hr size="5" color="#000000" noshade>

<div>
	 <?php 
 session_start();
    //↓↓↓↓↓↓入力したデータを表示(コメント)↓↓↓↓↓↓↓↓
        
        //idでグループ化して読み出している.toukouテーブルから。
        $select_sql ='SELECT * FROM toukou1 ORDER BY id';//toukou1テーブルの呼び出し
        $results = $pdo->query($select_sql);
       
        //foreachで回して投稿番号とテキスト表示
        foreach($results as $row){
            echo '<br>';//投稿と投稿の間を改行
            echo $row['id'].',';
            echo $row['text'].'<br>';
        }
        
  //この下からファイル使ってアップロード用
    $img=$_FILES["upfile"]["tmp_name"];//file関数使用
    print_r($img);
    echo "<br>";//改行のecho
    //ファイルにアップロードする(is_uploaded_file()←アップロード関数)
    if (is_uploaded_file($img)) {
  if (move_uploaded_file($img, "file/".$_FILES["upfile"]["name"])){//move_uploaded_file(写真,ファイル名)の書き方の関数
    echo $_FILES["upfile"]["name"]."をアップロードしました。";
  } else {
    echo "ファイルをアップロードできません。";
  }
}else if(is_uploaded_file($img)&&empty($img)){
        echo "ファイルが選択されていません。";
    }
    
    //以下ファイル内閲覧
    $filepass="file/";
    $array=scandir($filepass,1);
    $num=count($array);
    print("<table border=1><tr>");
 
//横に並べる画像の最大数を設定
$max = 2;
//カウント数の初期化
$cnt = 0;
//配列の数だけ繰り返す
for ($i=0;$i<$num;$i++){
    //$filenameにファイル名を設定
   $filename ="file/" . $array[$i];
    
    //ファイル名の拡張子が｢gif｣または｢GIF｣、｢jpg｣または｢JPG｣、｢JPEG｣、｢png｣または｢PNG｣、の場合は実寸表示のリンク付きで画像を表示する
    if  (Eregi('gif$', $filename) OR 
         Eregi('jpg$', $filename) OR 
         Eregi('jpeg$',$filename) OR 
         Eregi('png$', $filename)) {
        print("<td width=\"200\">" . "$filename" . "</td>");

        //ブラウザ上に画像を表示している
        print("<td><a href=" ."$filename" . "><img src =".$filename." width=\"200\"></a></td>");

        //カウント数の初期化
        $cnt = $cnt + 1;
         
        //カウント数の判定 最大数以上の場合は改行し、カウントを初期化する
        if ($cnt >= $max) {
            print("</tr><tr>");
            $cnt = 0;
        }
    }
}
exit;
?>
</div>
</center>
</body>
</html>