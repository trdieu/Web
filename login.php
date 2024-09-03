<?php
session_start();
require_once "pdo.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $salt = 'XyZzy12*_';
    $check = hash('md5', $salt . $_POST['password']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header("Location: index.php");
        return;
    } else {
        $_SESSION['error'] = 'Sai email hoặc mật khẩu';
        header("Location: login.php");
        return;
    }
}
?>

<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>
    <h1>Đăng nhập</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">'.$_SESSION['error'].'</p>';
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        <label>Email:</label>
        <input type="text" name="email"><br/>
        <label>Mật khẩu:</label>
        <input type="password" name="password" id="id_1723"><br/>
        <input type="submit" onclick="return doValidate();" value="Đăng nhập">
    </form>
    <script>
        function doValidate() {
            console.log('Validating...');
            try {
                pw = document.getElementById('id_1723').value;
                if (pw == null || pw == "") {
                    alert("Phải nhập mật khẩu");
                    return false;
                }
                return true;
            } catch (e) {
                return false;
            }
        }
    </script>
</body>
</html>
