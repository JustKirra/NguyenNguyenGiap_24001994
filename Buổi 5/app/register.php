<?php
require_once 'common/auth.php';
require_once 'model/user.php';

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';          // không trim mật khẩu

    if ($username === '') {
        $errors[] = "Tên đăng nhập không được để trống!";
    } elseif (mb_strlen($username) > 50) {
        $errors[] = "Tên đăng nhập tối đa 50 ký tự!";
    }
    if ($password === '') {
        $errors[] = "Mật khẩu không được để trống!";
    }

    if (empty($errors)) {
        try {
            if (getUserByUsername($username)) {
                $errors[] = "Tên đăng nhập đã tồn tại!";
            } else {
                addUser($username, $password);
                header("Location: login.php?registered=1");
                exit();
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {           // vi phạm UNIQUE
                $errors[] = "Tên đăng nhập đã tồn tại!";
            } else {
                error_log($e->getMessage());
                $errors[] = "Có lỗi hệ thống, vui lòng thử lại sau!";
            }
        }
    }
}

require_once 'view/header.php';
?>

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
        <input type="text" name="username" required maxlength="50" value="<?= e($username) ?>">
    </div>
    <div class="row">
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
    </div>
    <div class="row buttons">
        <button type="submit">Đăng ký</button>
    </div>
    <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
</form>

<?php require_once 'view/footer.php'; ?>