<?php
require_once 'model/product.php';
require_once 'view/header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gửi dữ liệu từ form
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

    // Nếu không có lỗi
    if (empty($errors)) {
        addProduct($name, $price, $quantity);
        header("Location: product_list.php");
        exit();
    }
}
?>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<h2>Thêm sản phẩm mới</h2>
<form method="POST" action="product_add.php">
    <p>
        <label>Tên sản phẩm:</label><br>
        <input type="text" name="name">
    </p>
    <p>
        <label>Giá:</label><br>
        <input type="number" step="0.01" name="price">
    </p>
    <p>
        <label>Số lượng:</label><br>
        <input type="number" name="quantity">
    </p>
    <button type="submit">Thêm mới</button>
    <a href="product_list.php">Hủy bỏ</a>
</form>

<?php
    require_once 'view/footer.php'
?>