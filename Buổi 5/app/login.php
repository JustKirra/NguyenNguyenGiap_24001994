<?php
require_once 'common/auth.php';
require_once 'model/user.php';

if (isLoggedIn()) {
    header("Location: product_list.php");
    exit();
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $errors[] = "Vui lòng nhập tên đăng nhập và mật khẩu!";
    } else {
        try {
            $user = getUserByUsername($username);
            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);                  // chống session fixation
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];    // không lưu mật khẩu/hash
                header("Location: product_list.php");
                exit();
            }
            $errors[] = "Sai tên đăng nhập hoặc mật khẩu!";   // cùng một thông báo cho cả 2 trường hợp
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errors[] = "Có lỗi hệ thống, vui lòng thử lại sau!";
        }
    }
}

require_once 'view/header.php';
?>

<?php if (isset($_GET['registered'])): ?>
    <p style="color: green; text-align: center;">Đăng ký thành công, mời bạn đăng nhập!</p>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="row">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required value="<?= e($username) ?>">
    </div>
    <div class="row">
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>
    <div class="row buttons">
        <button type="submit">Đăng nhập</button>
    </div>
    <p>Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
</form>

<?php require_once 'view/footer.php'; ?>