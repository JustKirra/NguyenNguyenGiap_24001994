<?php
if (!function_exists('e')) {
    function e($value) {
        return htmlspecialchars((string)$value, ENT_QUOTES , 'UTF-8');
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid;
            padding: 8px;
        }
        button {
            padding: 6px 20px;
            border: 1px solid;
            cursor: pointer;
        }
        form {
            width: 320px;
            margin: 40px auto;
        }
        .row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .row label {
            width: 120px; 
        }

        .row input {
            padding: 6px 10px;
            border: 1px solid;
            width: 200px;
        }
        .buttons {
            width: 320px;
            justify-content: flex-end;
        }
    </style>
</head>
<body>
    <h1>Hệ thống quản lý sản phẩm</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <p style="text-align: right;">
            Xin chào, <b><?= e($_SESSION['username']) ?></b> |
            <a href="logout.php">Đăng xuất</a>
        </p>
    <?php endif; ?>