<?php
require_once 'common/auth.php';
requireLogin();
require_once 'model/product.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gửi dữ liệu từ form
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    // Kiểm tra dữ liệu
    $errors = validateProduct($name, $price, $quantity);

    // Nếu không có lỗi
    if (empty($errors)) {
        try {
            addProduct($name, $price, $quantity);
            header("Location: product_list.php");
            exit();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errors[] = "Có lỗi hệ thống, vui lòng thử lại sau!";
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
        <label>Tên sản phẩm:</label>
        <input type="text" name="name" required maxlength="100"
                value="<?= e($_POST['name'] ?? '')?>">
    </div>
    
    <div class="row">
        <label>Giá tiền:</label>
        <input type="number" name="price" required min="0.01" step="0.01"
                value="<?= e($_POST['price'] ?? '')?>">
    </div>
    
    <div class="row">
        <label>Số lượng:</label>
        <input type="number" name="quantity" required min="0" step="1"
                value="<?= e($_POST['quantity'] ?? '')?>">
    </div>
    
    <div class="row buttons">
        <button type="submit" style="margin-right: 50px;">Lưu</button>
        <a href="product_list.php"><button type="button">Quay lại</button></a>
    </div>
</form>

<?php
    require_once 'view/footer.php'
?>