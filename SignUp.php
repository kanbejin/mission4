<?php

//セッションスタートする
session_start();
//データベース
$db['host'] = "localhost";  // DBサーバのURL
$db['user'] = "tt-186.99sv-coco.com";  // ユーザー名
$db['pass'] = "v7EcBydM";  // ユーザー名のパスワード
$db['dbname'] = "mysql:dbname=tt_186_99sv_coco_com";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
// 1. ユーザIDの入力チェック
        // 値が空のとき
    if (empty($_POST["username"])) {
        $errorMessage = 'ユーザーIDが未入力です。';
    }
        //パスワードがからの時
    else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }
        //確認用パスワードがからの時
    else if (empty($_POST["password2"])) {
        $errorMessage = '確認用パスワードが未入力です。';
    }
}
                    //ユーザーある                           ＋パスワードある                        ＋確認用パスワードある                                 ＋パスワードの一致
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
       
        // 入力したユーザIDとパスワードを格納
        $username = $_POST["username"];
        $password = $_POST["password"];

}
        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=localhost; dbname=tt_186_99sv_coco_com; charset=utf8', 
        $db['host'], 
        $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

        //テーブル作成
            $sql="CREATE TABLE IF NOT EXISTS userData"
. " ("
. "id mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,"
. "PRIMARY KEY(id),"//主キーの設定
. "name char(32),"//名前
. "password TEXT"//パスワード
. ");";
            $stmt=$pdo->query($sql);
            
            //(データベースに保存する時のコード)
            $stmt = $pdo->prepare("INSERT INTO userData(name, password) VALUES (?, ?)");
            
            // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
            $stmt->execute(array($username, crypt($password, PASSWORD_DEFAULT)));



            //↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
            //登録した(DB側でauto_incrementした)IDを$useridに入れる
            $userid = $pdo->lastinsertid();            
            
            //ここの$useridを$usernameにするかどうするかインターンメンバーに聞く
            $signUpMessage = '登録が完了しました。あなたの登録IDは '. $userid. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
            //↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        //方法１→キャッチ文(間違ってる内容と行を教えてくれる)
        }catch (PDOException $e) {
                echo $e->getMessage()." - ".$e->getLine().PHP_EOL;
        
        //方法２
            //$errorMessage = 'データベースエラー';
            // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
            // echo $e->getMessage();
     
        }
        //パスワードと確認パスワードが違ったら
        if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
                   <style>
  body{
  background-image: url("aozora.png");
  animation: AnimationName 10s ease infinite;    
  background-size: cover;
    background-attachment: fixed
}
 body {
    text-align:center;
    }
                    </style>
    </head>
    <body>
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="<?php echo htmlspecialchars($errorMessage, ENT_QUOTES);?>"</font></div>
                <div><font color="<?php echo htmlspecialchars($signUpMessage, ENT_QUOTES);?>"</font></div>
                <label for="username">ユーザー名</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
                <br>名前、パスワード、確認パスワード打ち込んで、新規登録ボタン押したらユーザー名だけ残ってパスワードは消える。
                <br>やけどそれでOK！戻るボタン押してログイン画面でもう一度、同じように打ち込んでください
            </fieldset>
        </form>
        <br>
        <form action="Login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>
