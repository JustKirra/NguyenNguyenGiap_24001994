<?php
require_once 'common/auth.php';
requireLogin();
require_once 'model/product.php';

$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT);

if ($id === false || $id <= 0) {
    header("Location: product_list.php");
    exit();
}

$product = getProductById($id);

if (!$product) {
    require_once 'view/header.php';
    echo "<h3>Sản phẩm không tồn tại!</h3>";
    echo "<a href='product_list.php'>Quay lại danh sách</a>";
    require_once 'view/footer.php';
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');

    // Kiểm tra dữ liệu
    $errors = validateProduct($name, $price, $quantity);


    if (empty($errors)) {
        try{
            updateProduct($id, $name, $price, $quantity);
            header("Location: product_list.php");
            exit();
        } catch (PDOException $e){
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

<form method="POST" action="product_edit.php?id=<?= (int)$product['id'] ?>">
    <div class="row">
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" required maxlength="100"
                value="<?= e($_POST['name'] ?? $product['name']) ?>">
    </div>
    <div class="row">
        <label>Giá:</label><br>
        <input type="number" name="price" required min="0.01" step="0.01"
                value="<?= e($_POST['price'] ?? $product['price']) ?>">
    </div>
    <div class="row">
        <label>Số lượng:</label><br>
        <input type="number" name="quantity" required min="0" step="1"
                value="<?= e($_POST['quantity'] ?? $product['quantity']) ?>">
    </div>
    <div class="row buttons">
        <button type="submit" style="margin-right: 25px;">Cập nhật</button>
        <a href="product_list.php"><button type="button">Quay lại</button></a>
    </div>
</form>

<?php
// Nhúng footer
require_once 'view/footer.php';
?>