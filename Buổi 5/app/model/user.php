<?php
require_once 'common/dbConnect.php';

function getUserByUsername($username) {
    $conn = getPDOConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch();          // mảng 1 chiều, hoặc false nếu không có
}

function addUser($username, $password) {
    $conn = getPDOConnection();
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    return $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
}
?>