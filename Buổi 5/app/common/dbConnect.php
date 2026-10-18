<?php
function getPDOConnection() {
    $host = 'localhost';
    $dbname = 'shopping_cart';
    $username = 'root';
    $password = '';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    } catch (PDOException $e) {
        error_log($e->getMessage());
        die("Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau.");
    }
}
?>