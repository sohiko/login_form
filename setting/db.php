<?
$user = "";
$dbpassword = "";
$dbname = "";
$host = "";
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
$error = 1;

try {
    $pdo = new PDO($dsn, $user, $dbpassword, array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci"
    ));
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    $ErrorMassage = '<span class="error">サーバー上で何らかのエラーが発生しました。お手数ですが、管理者までご連絡ください。</span><br>'.$e->getMessage();
    $error = 1;
    echo $ErrorMassage;
    exit();
}
