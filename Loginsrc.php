<?php
session_start(); // Khởi tạo session

// Kết nối đến cơ sở dữ liệu
$connect = mysqli_connect('127.0.0.1', 'root', '', 'webfashion', '4306');
if (!$connect) {
    echo "<script>alert('Kết nối thất bại!');</script>";
    exit();
}

// Xử lý form đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);

    // Truy vấn kiểm tra username và password
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connect, $sql);

    // Xử lý kết quả
    $check_login = mysqli_num_rows($result);

    if ($check_login == 0) {
        echo "<script>alert('Password or username is incorrect, please try again!');</script>";
    } else {
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        
        $user = mysqli_fetch_assoc($result);
        // Lưu thông tin người dùng vào session
        $_SESSION['username'] = $user['username']; // Lưu username vào session
        // print_r ($_SESSION['username']);
        $_SESSION['email'] = $user['email']; // Lưu email vào session
        $_SESSION['password'] = $user['password']; // Lưu password vào session
        $_SESSION['id'] = $user['id']; // Lưu ID người dùng nếu cần
        // Điều hướng đến trang homepage sau khi đăng nhập thành công
        echo "<script>
            alert('You have logged in successfully!');
            window.location.href = 'homepage.php';
        </script>";
        exit(); // Dừng script sau khi điều hướng
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Login Form</title>
    <!-- Link Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="background">
        <div class="login-box">
            <h2>Login</h2>
            <form method="POST" action="">
                <div class="input-box">
                    <label for="username" class="icon-label">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-box">
                    <label for="password" class="icon-label">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
                <a href="signup.php" class="Register">Do you have an account yet?</a>
            </form>
            <p>or login with</p>
            <div class="social-buttons">
                <button class="facebook">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
                <button class="twitter">
                    <i class="fab fa-twitter"></i> Twitter
                </button>
                <button class="google">
                    <i class="fab fa-google"></i> Google
                </button>
            </div>
        </div>
    </div>

   <!-- giờ log tài khoản khác thì đ hiện ?? bây giờ t thêm 1 sản phẩm id là 6 vào csdl r đăng nhập
   vô bằng id đó xem cart có hiển thị sản phẩm vừa in ra từ csdl k  -->
    <!-- // // session_start();
    // // if ($row > 0) {
    // //     $_SESSION['username'] = $username;
    // //     $_SESSION['id'] = $row_id ['id'];
    // }
    ?> -->
    <!-- tức là vẫn in từ csdl nhưng cái add thì nó đ lưu vào -->
     <!-- vừa t in ra thì có hình như vấn đề là nó chỉ addtocart lưu vào id 1 thôi kt bt r
      cái m nghĩ t cũng thử rồi lúc đầu tương do role admin mà đ phải đâu xoá cj thế ? csdl lồn đêó kết nối với nhau, user nó liên kết với cart bởi cột nào đó 
      thì khả năng nó lỗi từ in giá trị từ chỗ này này .....
</html>
