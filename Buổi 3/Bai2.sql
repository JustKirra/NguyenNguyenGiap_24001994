CREATE DATABASE IF NOT EXISTS movies_ticket;
USE movies_ticket;

CREATE TABLE IF NOT EXISTS movies (
	id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
    total_seats INT NOT NULL CHECK (total_seats >= 0),
    available_seats INT NOT NULL CHECK (available_seats >= 0)
);

INSERT INTO movies (title, price, total_seats, available_seats) VALUES
('Mai', 120000, 200, 80),
('Lật Mặt 7', 110000, 150, 40),
('Doraemon', 90000, 100, 60),
('Kung Fu Panda 4', 85000, 120, 30),
('Godzilla x Kong', 130000, 180, 50);

# Hiển thị toàn bộ danh sách phim
SELECT *
FROM movies;

# Hiển thị phim có giá vé lớn hơn 100000
SELECT * 
FROM movies
WHERE price > 100000;

# Hiển thị phim còn nhiều hơn 50 ghế
SELECT * 
FROM movies
WHERE available_seats > 50;

# Sắp xếp phim theo giá vé giảm dần
SELECT * 
FROM movies 
ORDER BY price DESC;

# Cập nhật số ghế còn lại của một phim
UPDATE movies 
SET available_seats = 75 
WHERE title = 'Mai';

# Xóa một phim 
DELETE FROM movies 
WHERE title = 'Doraemon';

# Hiển thị số vé đã bán của từng phim: total_seats - available_seats
SELECT id, title, (total_seats - available_seats) AS sold_seats 
FROM movies;

# Tính doanh thu của từng phim: (total_seats - available_seats) * price 
SELECT id, title, ((total_seats - available_seats) * price) AS revenue 
FROM movies;

# Tính tổng doanh thu của tất cả các phim
SELECT SUM((total_seats - available_seats) * price) AS total_revenue 
FROM movies;

# Tìm phim có số vé bán ra nhiều nhất
SELECT title, price, total_seats, available_seats, (total_seats - available_seats) AS sold_seats 
FROM movies 
GROUP BY id, title, price, total_seats, available_seats
HAVING sold_seats = (
    SELECT MAX(total_seats - available_seats) 
    FROM movies
);
