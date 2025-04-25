<?
session_start();
$error_message = "";
if(!empty($_SESSION['id'])) {
  //ログインがすでにされているユーザーを他ページに飛ばす
}

// ブラウザ判定
$browser = strtolower($_SERVER['HTTP_USER_AGENT']);
$browserName = "";
if (strstr($browser , 'edge')) {
  $browserName = 'Edge';
} elseif (strstr($browser , 'trident') || strstr($browser , 'msie')) {
  $browserName = 'Internet Explorer';
} elseif (strstr($browser , 'chrome')) {
  $browserName = 'Google Chrome';
} elseif (strstr($browser , 'firefox')) {
  $browserName = 'Firefox';
} elseif (strstr($browser , 'safari')) {
  $browserName = 'Safari';
} elseif (strstr($browser , 'opera')) {
  $browserName = 'Opera';
} else {
  $browserName = '取得不能';
}
// 機種判定
$model = $_SERVER['HTTP_USER_AGENT'];
$modelName = "";
if(preg_match("/^DoCoMo/i", $model)){
	$modelName = "DoCoMo";
}else if(preg_match("/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i", $model)){
	$modelName = "SoftBank";
}else if(preg_match("/^KDDI\-/i", $model) || preg_match("/UP\.Browser/i", $model)){
	$modelName = "au";
}else if(preg_match("/iPad/i", $model)){
	$modelName = "iPad";
}else if(preg_match("/iPhone/i", $model)){
	$modelName = "iPhone";
}else{
	$modelName = "PC";
}
// IP
$ip = $_SERVER["REMOTE_ADDR"];
// HOST
$user_host = gethostbyaddr($ip);
date_default_timezone_set('Asia/Tokyo');
$access_date = date("Y-m-d H:i:s");

if (!empty($_POST)) {
  $id = "";
  $password = "";
  $message = "";
  if (!empty($_POST)) {
      $id = $_POST['id'];
      $password = $_POST['password'];
  }
  require_once('./setting/db.php');
  $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
  $stmt->execute(['id' => $id]);
  $result = $stmt->fetch(PDO::FETCH_BOTH);
  if ($result['process'] == "complete") {
    if(password_verify($password, $result['password'])) {
      $stmt = $pdo->prepare("INSERT access_log SET id = :id, browserName = :browserName, modelName = :modelName, ip = :ip, host = :host, date = :date");
      $stmt->execute([
          'id' => $id,
          'browserName' => $browserName,
          'modelName' => $modelName,
          'ip' => $ip,
          'host' => $user_host,
          'date' => $access_date
      ]);
      $_SESSION['id'] = $id;
      $_SESSION['type'] = $result['type'];
      $redirect_url = !empty($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : null;
      unset($_SESSION['redirect_url']);
      if (!empty($redirect_url)) {
        header('Location: ' . $redirect_url);
        exit();
      }
      ///////////////////////
      // ログイン後のリダイレクト
      ///////////////////////
      exit();
    } else {
      $error_message = "ID、もしくはパスワードが違います";
      $password_reset = "true";
    }
  } else {
    $error_message = "現在このアカウントは有効化されていません";
  }
}
?>
<?php if (isset($_GET["id"])) {
  $getID = htmlspecialchars($_GET["id"]);
} else {
  $getID = "";
} ?>
<!DOCTYPE html>
<html lang="JP">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link rel="stylesheet" href="/css/root.css">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <div class="contents">
    <div class="logo">
      <img src="/img/logo.png" title="Logo" alt="サイトロゴ">
    </div>
    <? if($_GET['location'] == "logout") {print '<div class="logout"><p>正常にログアウトしました</p></div>';}?>
    <? if($_GET['location'] == "pass_reset_done") {print '<div class="logout"><p>パスワードをリセットしました</p></div>';}?>
    <? if($error_message != "") {print '<div class="logout"><p>' . htmlspecialchars($error_message) . '</p></div>';}?>
    <div class="login">
      <form method="post" action="" class="form" onsubmit="return Login()">
        <h2>Login</h2>
        <div class="group">
            <input type="number" max="999999" name="id" id="id" required><span class="highlight"></span><span class="bar"></span>
            <label id="l_id">ID</label>
            <p style="color: red; text-align: left; margin-left: 185px; font-size: 14px;" class="id"></p>
          </div>
          <div class="group">
            <input type="password" name="password" id="password" required><span class="highlight"></span><span class="bar"></span>
            <label id="l_password">Password</label>
            <p style="color: red; text-align: left; margin-left: 185px; font-size: 14px;" class="password"></p>
          </div>
          <button type="submit" class="button buttonBlue">Login
            <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
          </button>
          <? if ($password_reset == "true") {
            echo '
            <div class="pass_reset">
              <a href="/account/forget_password.php">パスワードをお忘れの方はこちら</a>
            </div>';
          }
          ?>
      </form>
    </div>
    <div class="accordion-wrap">
        <div class="accordion-item">
          <p class="accordion-header"><a href="/account/index.html">New registration</a></p>
        </div>
    </div>
  </div>
</body>
</html>
