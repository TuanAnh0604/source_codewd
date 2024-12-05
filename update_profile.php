<?php
session_start();  // Bắt buộc phải gọi session_start() trước khi truy cập $_SESSION

// Kiểm tra nếu người dùng đã đăng nhập (kiểm tra sự tồn tại của $_SESSION['username'])
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, bạn có thể chuyển hướng đến trang đăng nhập
    header("Location: loginsrc.php");
    exit;
}

// Kết nối đến cơ sở dữ liệu
$connect = mysqli_connect('127.0.0.1', 'root', '', 'webfashion', '4306');
if (!$connect) {
    die('Kết nối thất bại: ' . mysqli_connect_error());
}

// Lấy thông tin người dùng từ form
$newUsername = mysqli_real_escape_string($connect, $_POST['username']);
$newEmail = mysqli_real_escape_string($connect, $_POST['email']);
$newPassword = mysqli_real_escape_string($connect, $_POST['password']);

// Cập nhật thông tin người dùng trong cơ sở dữ liệu
$sql = "UPDATE users SET username = '$newUsername', email = '$newEmail', password = '$newPassword' WHERE id = " . $_SESSION['id'];

// Thực thi câu lệnh SQL
if (mysqli_query($connect, $sql)) {
    // Cập nhật lại thông tin trong session
    $_SESSION['username'] = $newUsername;
    $_SESSION['email'] = $newEmail;
    $_SESSION['password'] = $newPassword;

    // Điều hướng về trang chủ và thông báo thành công
    header("Location: homepage.php?success=1");
    exit;
} else {
    echo "<script>alert('Error updating profile. Please try again.');</script>";
}

// Đóng kết nối
mysqli_close($connect);
?>
