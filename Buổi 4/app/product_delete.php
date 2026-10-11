<?php
require_once 'model/product.php';

// Kiểm tra xem có tham số id không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kiểm tra sản phẩm trong CSDL
    $product = getProductById($id);

    if (!$product) {
        echo "Sản phẩm không tồn tại!";
        exit();
    }

    // Xóa nếu có
    deleteProduct($id);

    //Chuyển về lại danh sách sau khi xóa
    header("Location: product_list.php");
    exit();
} else {
    echo "ID không hợp lệ!";
}
?>