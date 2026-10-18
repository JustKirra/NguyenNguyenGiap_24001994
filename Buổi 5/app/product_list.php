<?php
    require_once 'common/auth.php';
    requireLogin();
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
        <td><?= (int)$item['id'] ?></td>
        <td><?= e($item['name']) ?></td>
        <td><?= number_format($item['price'], 2, ',', '.') ?></td>
        <td><?= (int)$item['quantity'] ?></td>
        <td>
            <a href="product_edit.php?id=<?=  (int)$item['id'] ?>">Sửa</a> |
            <form method="POST" action="product_delete.php"
                    style="display:inline; margin:0; width:auto;"
                    onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                <button type="submit">Xóa</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
    require_once 'view/footer.php';
?>