<?php
require_once 'common/auth.php';
requireLogin();
require_once 'model/product.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: product_list.php");
    exit;
}

$id = filter_var($_POST['id'] ?? '', FILTER_VALIDATE_INT);

if ($id === false || $id <= 0) {
    echo "ID không hợp lệ!";
    exit();
}

try {
    $product = getProductById($id);

    if (!$product) {
        echo "Sản phẩm không tồn tại!";
        exit();
    }

    deleteProduct($id);
    header("Location: product_list.php");
    exit();
} catch (PDOException $e){
    error_log($e->getMessage());
    echo "Có lỗi hệ thống, vui lòng thử lại sau!";
    exit();
}
?>