<?php
require_once 'common/dbConnect.php';

function getAllProducts() {
    //Gọi kết nối từ file dbConnect.php
    $conn = getPDOConnection();
    // Viết câu lệnh SQL
    $sql = "SELECT * FROM products";
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    // Thực thi câu lệnh
    $stmt->execute();
    // Lấy tất cả kết quả và trả về mảng 2 chiều
    return $stmt->fetchAll();
}

function getProductById($id) {
    //Gọi kết nối từ file dbConnect.php
    $conn = getPDOConnection();
    // Viết câu lệnh SQL
    $sql = "SELECT * FROM products WHERE id = ?";
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    // Thực thi câu lệnh
    $stmt->execute([$id]);
    // Lấy tất cả kết quả và trả về mảng 1 chiều
    return $stmt->fetch();
}

function addProduct($name, $price, $quantity) {
    //Gọi kết nối từ file dbConnect.php
    $conn = getPDOConnection();
    // Viết câu lệnh SQL
    $sql = "INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)";
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    // Thực thi và trả về T hoặc F
    return $stmt->execute([$name, $price, $quantity]);
}

function updateProduct($id, $name, $price, $quantity){
    //Gọi kết nối từ file dbConnect.php
    $conn = getPDOConnection();
    // Viết câu lệnh SQL
    $sql = "UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ?";
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    // Thực thi và trả về T hoặc F
    return $stmt->execute([$name, $price, $quantity, $id]);
}

function deleteProduct($id){
    //Gọi kết nối từ file dbConnect.php
    $conn = getPDOConnection();
    // Viết câu lệnh SQL
    $sql = "DELETE FROM products WHERE id = ?";
    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);
    // Thực thi và trả về T hoặc F
    return $stmt->execute([$id]);
}

function validateProduct($name, $price, $quantity){
    $errors = [];

    if ($name === '') {
        $errors[] = "Tên sản phẩm không được để rỗng!";
    } elseif (mb_strlen($name) > 100) {
        $errors[] = "Tên sản phẩm tối đa 100 ký tự!";
    }

    if (!preg_match('/^\d+(\.\d{1,2})?$/', $price)) {
        $errors[] = "Giá phải là số, tối đa 2 chữ số thập phân!";
    } elseif ((float)$price <= 0 || (float)$price > 99999999.99) {
        $errors[] = "Giá phải lớn hơn 0 và không vượt quá 99.999.999,99!";
    }

    $qtyNum = filter_var($quantity, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0, 'max_range' => 2147483647]
    ]);
    if ($qtyNum === false) {
        $errors[] = "Số lượng phải là số nguyên từ 0 đến 2.147.483.647!";
    }

    return $errors;
}
?>