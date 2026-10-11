<?php
    require_once 'model/product.php';
    require_once 'view/header.php';
    
    $products = getAllProducts();
?>
<div style="text-align: center; margin-bottom: 15px;">
    <a href="product_add.php"><button>Thêm sản phẩm</button></a>
</div>
<table border="1" style="text-align: center; margin-top: 15px;">
    <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Chức năng</th>
    </tr>

    <?php foreach ($products as $item): ?>
    <tr>
        <td><?= $item['id'] ?></td>
        <td><?= $item['name'] ?></td>
        <td><?= number_format($item['price']) ?></td>
        <td><?= $item['quantity'] ?></td>
        <td>
            <a href="product_edit.php?id=<?=  $item['id'] ?>">Sửa</a> |
            <a href="product_delete.php?id=<?= $item['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
    require_once 'view/footer.php';
?>