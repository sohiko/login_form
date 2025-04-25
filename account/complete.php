<?php
session_start();
if(!empty($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
if (!empty($_GET['id'])) {
    $uniqueNumber = $_GET['id'];
} else {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="JP">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>
    <link rel="stylesheet" href="/css/root.css">
    <link rel="stylesheet" href="/account/css/confirm.css">
</head>
<body>
    <div class="logo">
        <img src="/img/logo.png" title="Logo" alt="サイトロゴ">
    </div>
    <div class="main">
        <p>ご登録ありがとうございます。登録が完了しました。</p>
        <p>下のボタンより<span>IDを使って</span>ログインしてください。</p>
        <p class="id">ID：<? echo $uniqueNumber;?></p>
        <p style="font-size: 15px; font-weight: normal; margin-top: 30px;">IDを書き留めておくか、コピーをしてお進みください</p>
        <p style="font-size: 15px; font-weight: normal;">IDは登録済みのメールアドレスにも送信しています</p>
        <? print '<a class="button" href="../index?id=' . $uniqueNumber . '">ログインページへ</a>';?>
        <p>IDは今後のログインで必要です<br>必ず保存してください</p>
    </div>
</body>
</html>
