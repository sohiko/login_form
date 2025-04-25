<?php
session_start();
if(!empty($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}
if (!empty($_POST)) {
    $id = "";
    $company = "";
    $name = "";
    $email = "";
    $phone = "";
    $password = "";
    $check01 = "";
    $check02 = "";
    $message = "";
    $date = "";

    $company = $_POST['company'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $check01 = $_POST['check01'];
    $check02 = $_POST['check02'];
    date_default_timezone_set('Asia/Tokyo');
    $date = date("Y-m-d H:i:s");

    require_once('../setting/db.php');



    function generateUniqueNumber($pdo) {
        $min = 100000;
        $max = 999999;
        $id = mt_rand($min, $max);
    
        // 生成した数値がすでにデータベースに存在するか確認
        $stmt = $pdo->prepare("SELECT id FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return generateUniqueNumber($pdo);
        }
    
        return $id;
    }

    $uniqueNumber = generateUniqueNumber($pdo);

    $sql = 'INSERT INTO user(id, company, name, email, phone, password, check01, check02, date) VALUES(:id, :company, :name, :email, :phone, :password, :check01, :check02, :date)';

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $uniqueNumber, \PDO::PARAM_STR);
        $stmt->bindValue(':company', $company, \PDO::PARAM_STR);
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->bindValue(':phone', $phone, \PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, \PDO::PARAM_STR);
        $stmt->bindValue(':check01', $check01, \PDO::PARAM_STR);
        $stmt->bindValue(':check02', $check02, \PDO::PARAM_STR);
        $stmt->bindValue(':date', $date, \PDO::PARAM_STR);
        $stmt->execute();

        $pdo->commit();
    } catch (\PDOException $e) {
        $pdo->rollback();
        echo "エラーが発生しました：" . $e->getMessage();
    }
    header("Location: ./complete.php?code=" . $uniqueNumber);
    exit();

} else {
    header("Location: ./index.html");
    exit();
}
?>
