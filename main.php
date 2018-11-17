<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    //ログアウト画面に飛ぶようにheader関数を使用する
    header("Location: Logout.php");
    exit;
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>メイン画面</title>
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
h1{
    color:white;
    text-align: center;
    font-size:  80px; 
}
h2{
    color:white;
    text-align: center;
    font-size:  35px; 
}

 p{
  background: white;
  width: 500px;
  padding: 10px;
  text-align: center;
  border: 1px solid #000000;
  margin: 30px auto;
  }
  body {
    text-align:center;
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

 </style>
    </head>
    <body>
        <h1>メイン画面</h1>
        <h2>ようこそ<u><?php echo htmlspecialchars($_SESSION["NAME"], ENT_QUOTES); ?></u>さん!</h2>
        <center><p class="img-wrap">こちらはなんでも好きなことを<strong>投稿できる</strong>ものになっています<br>さっそく投稿ページの方にいきましょう</p></center>
        
                <a href="toukou.php" class="toukoubotan">
                <i class="fa fa-chevron-right"></i>投稿ページ
                </a>
                <br>
                <br>
                <a href="alltoukou.php" class="alltoukoubotan">
                <i class="fa fa-chevron-right"></i>みんなの投稿
                </a>
                <br>
                <br>
                <a href=" Logout.php" class="Logoutbotan">
                <i class="fa fa-chevron-right"></i>ログアウト
                </a>
    </body>
</html>
