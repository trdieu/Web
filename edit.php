<?php
require_once 'db.php'; // Kết nối cơ sở dữ liệu
$profile_id = $_GET['profile_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cập nhật thông tin hồ sơ
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $headline = $_POST['headline'];
    $summary = $_POST['summary'];

    $sql = "UPDATE profile SET first_name = ?, last_name = ?, email = ?, headline = ?, summary = ? WHERE profile_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$first_name, $last_name, $email, $headline, $summary, $profile_id]);
    header("Location: index.php");
} else {
    // Lấy thông tin hiện tại của hồ sơ
    $stmt = $pdo->prepare("SELECT * FROM profile WHERE profile_id = ?");
    $stmt->execute([$profile_id]);
    $profile = $stmt->fetch();
}
?>
