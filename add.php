<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['user_id'])) {
    die('Chưa đăng nhập');
}

if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])) {
    $stmt = $pdo->prepare('INSERT INTO profile (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );
    $_SESSION['success'] = 'Thêm hồ sơ thành công';
    header('Location: index.php');
    return;
}
?>

<html>
<head>
    <title>Thêm hồ sơ</title>
</head>
<body>
    <h1>Thêm hồ sơ</h1>
    <form method="post">
        <p>Tên: <input type="text" name="first_name"></p>
        <p>Họ: <input type="text" name="last_name"></p>
        <p>Email: <input type="text" name="email"></p>
        <p>Tiêu đề: <input type="text" name="headline"></p>
        <p>Tóm tắt: <textarea name="summary"></textarea></p>
        <p><input type="submit" value="Thêm"></p>
    </form>
</body>
</html>
