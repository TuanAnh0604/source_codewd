<?php
session_start();

// Kết nối tới cơ sở dữ liệu
$connect = mysqli_connect('localhost', 'root', '', 'webfashion', '4306');
if (!$connect) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Kiểm tra nếu người dùng đăng nhập
if (!isset($_SESSION['id'])) {
    header('Location: loginsrc.php');
    exit();
}

$userID = $_SESSION['id']; // Lấy user_id từ session
$productID = isset($_POST['product_id']) ? $_POST['product_id'] : null; // Lấy product_id từ form

if ($productID) {
    // Xóa sản phẩm khỏi bảng cart
    $delete_query = "DELETE FROM cart WHERE user_id = $userID AND product_id = $productID";
    if (mysqli_query($connect, $delete_query)) {
        // Chuyển hướng lại trang giỏ hàng sau khi xóa
        header('Location: cart.php');
        exit();
    } else {
        echo 'Error deleting product: ' . mysqli_error($connect);
    }
} else {
    echo 'Invalid product ID';
}

mysqli_close($connect);
?>
