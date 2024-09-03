<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['user_id'])) {
    die('Chưa đăng nhập');
}

if (isset($_POST['delete']) && isset($_POST['profile_id'])) {
    $stmt = $pdo->prepare('DELETE FROM profile WHERE profile_id = :pid AND user_id = :uid');
    $stmt->execute(array(':pid' => $_POST['profile_id'], ':uid' => $_SESSION['user_id']));
    $_SESSION['success'] = 'Xóa hồ sơ thành công';
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare('SELECT profile_id, first_name, last_name FROM profile WHERE profile_id = :pid AND user_id = :uid');
$stmt->execute(array(':pid' => $_GET['profile_id'], ':uid' => $_SESSION['user_id']));
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
if ($profile === false) {
    $_SESSION['error'] = 'Không tìm thấy hồ sơ';
    header('Location: index.php');
    return;
}
?>

<html>
<head>
    <title>Xóa hồ sơ</title>
</head>
<body>
    <h1>Bạn có chắc chắn muốn xóa hồ sơ của <?= htmlentities($profile['first_name'].' '.$profile['last_name']) ?>?</h1>
    <form method="post">
        <input type="hidden" name="profile_id" value="<?= $profile['profile_id'] ?>">
        <input type="submit" name="delete" value="Xóa">
        <a href="index.php">Hủy</a>
    </form>
</body>
</html>
