<?php
session_start();
require_once "pdo.php";

// Hiển thị danh sách hồ sơ
$stmt = $pdo->query("SELECT * FROM profile");
$profiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
<head>
    <title>Your Name - Profile Management</title>
</head>
<body>
    <h1>Danh sách hồ sơ</h1>
    <?php if (!isset($_SESSION['user_id'])): ?>
        <a href="login.php">Đăng nhập</a>
    <?php else: ?>
        <a href="add.php">Thêm hồ sơ mới</a>
        <a href="logout.php">Đăng xuất</a>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Tiêu đề</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($profiles as $profile): ?>
                <tr>
                    <td><?= htmlentities($profile['first_name'] . " " . $profile['last_name']) ?></td>
                    <td><?= htmlentities($profile['headline']) ?></td>
                    <td>
                        <a href="view.php?profile_id=<?= $profile['profile_id'] ?>">Xem</a>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $profile['user_id']): ?>
                            <a href="edit.php?profile_id=<?= $profile['profile_id'] ?>">Sửa</a>
                            <a href="delete.php?profile_id=<?= $profile['profile_id'] ?>">Xóa</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
