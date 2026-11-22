<?php
header('Content-Type: application/json; charset=utf-8');

const DB_HOST = 'localhost';
const DB_NAME = 'product_api';
const DB_USER = 'root';
const DB_PASS = '';

const MAX_SIZE = 2 * 1024 * 1024;

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

function deleteImageFile($path): void
{
    if (is_string($path) && preg_match('#^uploads/[A-Za-z0-9_.-]+$#', $path)) {
        $file = __DIR__ . '/../' . $path;
        if (is_file($file)) {
            @unlink($file);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    fail(405, 'Phương thức không được hỗ trợ.');
}

if (empty($_POST) && empty($_FILES) && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
    fail(413, 'Dữ liệu gửi lên quá lớn.');
}

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

try {
    $productId = $_POST['product_id'] ?? '';
    if (!is_string($productId) || !preg_match('/^\d+$/', $productId) || (int) $productId < 1) {
        fail(400, 'Mã sản phẩm không hợp lệ.');
    }
    $productId = (int) $productId;

    $sel = $pdo->prepare('SELECT image FROM products WHERE id = :id');
    $sel->execute(['id' => $productId]);
    $product = $sel->fetch();
    if (!$product) {
        fail(404, 'Không tìm thấy sản phẩm.');
    }

    if (!isset($_FILES['image']) || !is_array($_FILES['image'])) {
        fail(400, 'Chưa chọn file ảnh.');
    }
    $file = $_FILES['image'];

    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        fail(400, 'Ảnh lớn hơn dung lượng cho phép (tối đa 2 MB).');
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        fail(400, 'Upload ảnh thất bại (mã lỗi ' . $file['error'] . ').');
    }
    if ($file['size'] > MAX_SIZE) {
        fail(400, 'Ảnh lớn hơn 2 MB.');
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        fail(400, 'File tải lên không hợp lệ.');
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    if (!isset($allowed[$mime]) || @getimagesize($file['tmp_name']) === false) {
        fail(400, 'Chỉ chấp nhận ảnh JPG, JPEG hoặc PNG.');
    }

    $dir = __DIR__ . '/../uploads/';
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) {
        fail(500, 'Không tạo được thư mục uploads.');
    }
    $fileName = 'product_' . $productId . '_' . bin2hex(random_bytes(8)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . $fileName)) {
        fail(500, 'Không lưu được file ảnh.');
    }

    $path = 'uploads/' . $fileName;
    try {
        $upd = $pdo->prepare('UPDATE products SET image = :image WHERE id = :id');
        $upd->execute(['image' => $path, 'id' => $productId]);
    } catch (PDOException $e) {
        @unlink($dir . $fileName);
        fail(500, 'Không cập nhật được đường dẫn ảnh.');
    }

    deleteImageFile($product['image']);

    respond(200, [
        'success' => true,
        'message' => 'Upload ảnh thành công.',
        'data'    => ['id' => $productId, 'image' => $path],
    ]);
} catch (PDOException $e) {
    fail(500, 'Lỗi cơ sở dữ liệu.');
}