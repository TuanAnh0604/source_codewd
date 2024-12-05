<?php
session_start();

// Kiểm tra nếu user đã đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: loginsrc.php");
    exit;
}

// Kết nối tới cơ sở dữ liệu
$connect = new mysqli('127.0.0.1', 'root', '', 'webfashion', '4306');
if ($connect->connect_error) {
    die("Kết nối thất bại: " . $connect->connect_error);
}

// Lấy dữ liệu từ form
$user_id = $_SESSION['id'] ?? null;  // user_id là số nguyên, có thể giữ lại intval() nếu cần
$username = $_SESSION['username'] ?? null;
$email = $_POST['email'] ?? null;
$subject = $_POST['subject'] ?? null;
$mesage = $_POST['mesage'] ?? null;  // Sửa từ 'message' thành 'mesage'

// // Kiểm tra dữ liệu
// if (!$user_id || !$username || !$email || !$subject || !$mesage) {
//     die("Dữ liệu không đầy đủ.");
// }

// Chèn dữ liệu vào bảng contact_us
$sql = "INSERT INTO contact_us (user_id, user_name, email, subject, mesage, created_at) 
        VALUES (?, ?, ?, ?, ?, NOW())";
$stmt = $connect->prepare($sql);

if ($stmt) {
    // Sử dụng bind_param để đảm bảo dữ liệu được truyền đúng kiểu
    $stmt->bind_param("issss", $user_id, $username, $email, $subject, $mesage);  // Sửa 'message' thành 'mesage'

    if ($stmt->execute()) {
        // Thành công, chuyển hướng đến trang thông báo
        header("Location: successent.php");
        exit;
    } else {
        echo "Lỗi: Không thể thêm dữ liệu. " . $stmt->error;
    }
} else {
    echo "Lỗi: Không thể chuẩn bị câu lệnh SQL. " . $connect->error;
}

// Đóng kết nối
$stmt->close();
$connect->close();
?>
