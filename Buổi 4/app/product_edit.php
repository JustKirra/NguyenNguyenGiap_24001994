<?php
require_once 'model/product.php';
require_once 'view/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: product_list.php");
    exit();
}

$product = getProductById($id);

if (!$product) {
    echo "<h3>Sản phẩm không tồn tại!</h3>";
    echo "<a href='product_list.php'>Quay lại danh sách</a>";
    require_once 'view/footer.php';
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Kiểm tra dữ liệu
    if (empty($name)) {
        $errors[] = "Tên sản phẩm không được để rỗng!";
    }
    if ($price <= 0) {
        $errors[] = "Giá sản phẩm phải lớn hơn 0!";
    }
    if ($quantity < 0) {
        $errors[] = "Số lượng phải lớn hơn hoặc bằng 0!";
    }

    if (empty($errors)) {
        updateProduct($id, $name, $price, $quantity);
        header("Location: product_list.php");
        exit();
    }
}
?>

<h2>Sửa thông tin sản phẩm</h2>
<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="product_edit.php?id=<?= $product['id'] ?>">
    <p>
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name" value="<?= $_POST['name'] ?? $product['name'] ?>">
    </p>
    <p>
        <label>Giá:</label><br>
        <input type="number" step="0.01" name="price" value="<?= $_POST['price'] ?? $product['price'] ?>">
    </p>
    <p>
        <label>Số lượng:</label><br>
        <input type="number" name="quantity" value="<?= $_POST['quantity'] ?? $product['quantity'] ?>">
    </p>
    
    <button type="submit">Cập nhật sản phẩm</button>
    <a href="product_list.php">Hủy bỏ</a>
</form>

<?php
// Nhúng footer
require_once 'view/footer.php';
?>