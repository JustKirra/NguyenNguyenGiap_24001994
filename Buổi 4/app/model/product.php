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
?>