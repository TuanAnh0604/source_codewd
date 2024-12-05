<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

$username = $_SESSION['username'];
$connect = new mysqli('localhost', 'root', '', 'webfashion', 4306);

if ($connect->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Lấy user_id từ username
$sql_user = "SELECT id FROM users WHERE username = ?";
$stmt = $connect->prepare($sql_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_user = $stmt->get_result();

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $user_id = $row_user['id'];
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    exit;
}

// Lấy dữ liệu từ AJAX
$product_id = intval($_POST['product_id']);
$action = $_POST['action'];

if (!$product_id || !$action) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    exit;
}

// Cập nhật số lượng sản phẩm
if ($action === 'increase') {
    $update_sql = "UPDATE cart SET quantity = quantity + 1, updated_at = NOW() WHERE product_id = ? AND user_id = ?";
} elseif ($action === 'decrease') {
    $update_sql = "UPDATE cart SET quantity = quantity - 1, updated_at = NOW() WHERE product_id = ? AND user_id = ? AND quantity > 1";
}

$stmt_update = $connect->prepare($update_sql);
$stmt_update->bind_param("ii", $product_id, $user_id);

if ($stmt_update->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update quantity.']);
}
?>
