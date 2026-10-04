CREATE DATABASE IF NOT EXISTS shopping_cart;
USE shopping_cart;

CREATE TABLE IF NOT EXISTS cart_items (
	id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL
);

# Thêm 5 sản phẩm vào bảng
INSERT INTO cart_items (name, price, quantity) VALUES
('Iphone 18 pro max', 37000000, 1),
('Áo phông', 150000, 3),
('Móc khóa', 20000, 10),
('Giày', 600000, 2),
('Quần', 200000, 5);

# Hiển thị toàn bộ sản phẩm
SELECT * 
FROM cart_items;

# Hiển thị sản phẩm có giá lớn hơn 100000
SELECT * 
FROM cart_items
WHERE price > 100000;

# Hiển thị sản phẩm có số lượng lớn hơn 5
SELECT *
FROM cart_items
WHERE quantity > 5;

# Sắp xếp sản phẩm theo giá giảm dần
SELECT *
FROM cart_items
ORDER BY price DESC;

# Cập nhật giá của một sản phẩm
UPDATE cart_items
SET price = 56000000
WHERE name = 'Iphone 18 pro max';

# Cập nhật số lượng của một sản phẩm
UPDATE cart_items
SET quantity = 12
WHERE name = 'Móc khóa';

# Xóa một sản phẩm
DELETE FROM cart_items
WHERE name = 'Giày';

# Hiển thị tên sản phẩm , giá , số lượng và thành tiền (price x quantity)
SELECT name as TênSP , price as Giá , quantity as SL , (price * quantity) as ThanhTien
FROM cart_items;

# Tính tổng tiền của toàn bộ giỏ hàng
SELECT SUM(price * quantity) as tong_tien_gio_hang
FROM cart_items;
