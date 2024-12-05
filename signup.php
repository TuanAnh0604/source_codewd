<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Sign Up</title>
    <link rel="stylesheet" href="Registersrc.css">
</head>

<body>
    <div class="signup-container">
        <h2>Create account</h2>
        <div class="signup-box">
            <form id="signup-form" action="" method="POST">
                <div class="input-box">
                    <label for="username" class="icon-label">
                        <i class="fas fa-user"></i>
                    </label>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="input-box">
                    <label for="email" class="icon-label">
                        <i class="fas fa-envelope"></i>
                    </label>
                    <input type="email" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-box">
                    <label for="password" class="icon-label">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="input-box">
                    <label for="confirm-password" class="icon-label">
                        <i class="fas fa-lock"></i>
                    </label>
                    <input type="password" id="confirm-password" placeholder="Confirm Password" required>
                </div>
                <div class="input-box">
                    <label for="role" class="icon-label">
                        <i class="fas fa-user-tag"></i>
                    </label>
                    <select id="role" name="role" required>
                        <option value="1">Admin</option>
                        <option value="2">Customer</option>
                        <option value="3">Staff</option>
                    </select>
                </div>
                <div class="checkbox">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">I Agree To The Terms & Conditions</label>
                </div>
                <div>
                    <button type="submit" class="signup-button">SIGN UP</button>
                </div>
                <br>
                <p>Already have an Account? <a href="Loginsrc.php">Login Now!</a></p>
            </form>
        </div>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Thông tin kết nối cơ sở dữ liệu
        $servername = '127.0.0.1'; // Địa chỉ IP
        $username = 'root';
        $password = '';
        $dbname = 'webfashion';
        $port = 4306; // Cổng MySQL của bạn

        // Kết nối cơ sở dữ liệu
        $conn = mysqli_connect($servername, $username, $password, $dbname, $port);

        if ($conn) {
            echo "<script>alert('Kết nối thành công!');</script>";
        } else {
            echo "<script>alert('Kết nối thất bại!');</script>";
            exit(); // Ngừng mã nếu kết nối thất bại
        }

        // Lấy dữ liệu từ form
        $userName = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Thực hiện truy vấn INSERT
        $sql = "INSERT INTO users (username, password, email, role) VALUES ('$userName', '$password', '$email', '$role')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Bạn đã đăng ký thành công!');
                    window.location.href = 'Loginsrc.php'; // Chuyển đến trang Loginsrc.php
                  </script>";
            exit();
        } else {
            echo "<script>alert('Đăng ký thất bại! Lỗi: " . mysqli_error($conn) . "');</script>";
        }

        // Đóng kết nối
        mysqli_close($conn);
    }
    ?>

    <script>
        // Kiểm tra mật khẩu và xác nhận mật khẩu
        document.getElementById('signup-form').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirm-password').value;

            // Kiểm tra nếu mật khẩu và xác nhận mật khẩu không khớp
            if (password !== confirmPassword) {
                alert('Password and confirm password do not match!');
                event.preventDefault(); // Ngừng gửi form
            }
        });
    </script>
</body>

</html>
