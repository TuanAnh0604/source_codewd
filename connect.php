<?php
session_start();

// Kiểm tra nếu user đã đăng nhập
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: loginsrc.php");
    exit;
}

// Kết nối cơ sở dữ liệu
$servername = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'webfashion';
$port = 4306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý dữ liệu form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $user_id = $_POST['user_id'];
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    // Thêm dữ liệu vào bảng contact_us
    $sql = "INSERT INTO contact_us (user_id, user_name, email, subject, message) 
            VALUES ('$user_id', '$user_name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng đến trang thông báo thành công
        header("Location: submit_contact.php");
        exit;
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
