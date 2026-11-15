<?php
header('Content-Type: application/json; charset=utf-8');

const DB_HOST = 'localhost';
const DB_NAME = 'product_api';
const DB_USER = 'root';
const DB_PASS = '';

// ---------- Hàm tiện ích ----------
function respond(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE);
    exit;
}

function fail(int $status, string $message): void
{
    respond($status, ['success' => false, 'message' => $message]);
}

// Chuyển giá trị thành số nguyên; trả về null nếu không phải số nguyên
function toInt($value): ?int
{
    if (is_int($value)) {
        return $value;
    }
    if (is_string($value) && preg_match('/^-?\d+$/', trim($value))) {
        $n = filter_var(trim($value), FILTER_VALIDATE_INT);
        return $n === false ? null : $n;
    }
    return null; // float, bool, null, mảng... đều bị từ chối
}

// Kiểm tra dữ liệu JSON gửi lên; trả về [dữ liệu sạch, thông báo lỗi]
function validateProduct(): array
{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (!is_array($data)) {
        return [null, 'Dữ liệu gửi lên phải là JSON hợp lệ.'];
    }

    // Tên: sau khi bỏ khoảng trắng hai đầu phải có 1-100 ký tự
    $name = $data['name'] ?? null;
    if (!is_string($name)) {
        return [null, 'Tên sản phẩm là bắt buộc.'];
    }
    $name = trim($name);
    $len = mb_strlen($name, 'UTF-8');
    if ($len < 1 || $len > 100) {
        return [null, 'Tên sản phẩm phải có từ 1 đến 100 ký tự.'];
    }

    // Đơn giá: số nguyên > 0
    $price = toInt($data['price'] ?? null);
    if ($price === null || $price <= 0) {
        return [null, 'Đơn giá phải là số nguyên lớn hơn 0.'];
    }

    // Tồn kho: số nguyên >= 0
    $stock = toInt($data['stock'] ?? null);
    if ($stock === null || $stock < 0) {
        return [null, 'Số lượng tồn phải là số nguyên không âm.'];
    }

    // Không vượt quá giới hạn của kiểu INT trong MySQL
    if ($price > 2147483647 || $stock > 2147483647) {
        return [null, 'Giá trị vượt quá giới hạn cho phép.'];
    }

    return [['name' => $name, 'price' => $price, 'stock' => $stock], null];
}

// Lấy id từ URL (?id=1); trả về null nếu thiếu hoặc không hợp lệ
function getId(): ?int
{
    if (!isset($_GET['id'])) {
        return null;
    }
    $id = toInt($_GET['id']);
    return ($id !== null && $id > 0) ? $id : null;
}

// ---------- Kết nối CSDL ----------
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    fail(500, 'Không kết nối được cơ sở dữ liệu.');
}

// ---------- Xử lý theo phương thức ----------
try {
    switch ($_SERVER['REQUEST_METHOD']) {

        // GET: danh sách sản phẩm
        case 'GET':
            $rows = $pdo->query('SELECT id, name, price, stock FROM products ORDER BY id')->fetchAll();
            foreach ($rows as &$r) {
                $r['id']    = (int) $r['id'];
                $r['price'] = (int) $r['price'];
                $r['stock'] = (int) $r['stock'];
            }
            unset($r);
            respond(200, ['success' => true, 'data' => $rows]);
            break;

        // POST: thêm sản phẩm mới
        case 'POST':
            [$p, $error] = validateProduct();
            if ($error !== null) {
                fail(400, $error);
            }
            $stmt = $pdo->prepare('INSERT INTO products (name, price, stock) VALUES (:name, :price, :stock)');
            $stmt->execute($p);
            respond(201, [
                'success' => true,
                'message' => 'Thêm sản phẩm thành công.',
                'data'    => ['id' => (int) $pdo->lastInsertId()] + $p,
            ]);
            break;

        // PUT: cập nhật sản phẩm theo id
        case 'PUT':
            $id = getId();
            if ($id === null) {
                fail(400, 'Thiếu hoặc sai mã sản phẩm (id) trên URL.');
            }
            [$p, $error] = validateProduct();
            if ($error !== null) {
                fail(400, $error);
            }
            // Kiểm tra tồn tại (rowCount của UPDATE bằng 0 cả khi dữ liệu không đổi)
            $check = $pdo->prepare('SELECT 1 FROM products WHERE id = :id');
            $check->execute(['id' => $id]);
            if (!$check->fetchColumn()) {
                fail(404, 'Không tìm thấy sản phẩm cần sửa.');
            }
            $stmt = $pdo->prepare('UPDATE products SET name = :name, price = :price, stock = :stock WHERE id = :id');
            $stmt->execute($p + ['id' => $id]);
            respond(200, [
                'success' => true,
                'message' => 'Cập nhật sản phẩm thành công.',
                'data'    => ['id' => $id] + $p,
            ]);
            break;

        // DELETE: xóa sản phẩm theo id
        case 'DELETE':
            $id = getId();
            if ($id === null) {
                fail(400, 'Thiếu hoặc sai mã sản phẩm (id) trên URL.');
            }
            $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
            $stmt->execute(['id' => $id]);
            if ($stmt->rowCount() === 0) {
                fail(404, 'Không tìm thấy sản phẩm cần xóa.');
            }
            respond(200, ['success' => true, 'message' => 'Xóa sản phẩm thành công.']);
            break;

        default:
            header('Allow: GET, POST, PUT, DELETE');
            fail(405, 'Phương thức không được hỗ trợ.');
    }
} catch (PDOException $e) {
    fail(500, 'Lỗi cơ sở dữ liệu.');
}