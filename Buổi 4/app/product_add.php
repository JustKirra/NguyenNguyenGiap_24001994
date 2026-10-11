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

<form method="POST">
    <div class="row">
        <label>Tên sản phẩm:</label>
        <input type="text" name="name" required>
    </div>
    
    <div class="row">
        <label>Giá tiền:</label>
        <input type="number" name="price" min="1" required>
    </div>
    
    <div class="row">
        <label>Số lượng:</label>
        <input type="number" name="quantity" min="0" required>
    </div>
    
    <div class="row buttons">
        <button type="submit" style="margin-right: 50px;">Lưu</button>
        <a href="product_list.php"><button type="button">Quay lại</button></a>
    </div>
</form>

<?php
    require_once 'view/footer.php'
?>