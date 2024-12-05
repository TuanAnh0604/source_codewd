<?php
// Lấy tên file hiện tại
$current_page = basename($_SERVER['PHP_SELF']);
?>

<?php
    session_start();

    // Kiểm tra nếu người dùng chưa đăng nhập
    if (!isset($_SESSION['username'])) {
        header("Location: loginsrc.php");
        exit;
    }

    // Kết nối tới cơ sở dữ liệu
    $connect = new mysqli('127.0.0.1', 'root', '', 'webfashion', 4306);
    if ($connect->connect_error) {
        die("Kết nối thất bại: " . $connect->connect_error);
    }

    // Lấy thông tin người dùng từ session
    $user_id = $_SESSION['id'];

    // Lấy thông tin hiện tại của người dùng
    $sql = "SELECT username, email FROM users WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found. Please log in again.');</script>";
        header("Location: loginsrc.php");
        exit;
    }

    // Đóng kết nối
    $stmt->close();
    $connect->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Profile</title>
        <link rel="stylesheet" href="editprofile.css">
    </head>
    <body>
        <div class="profile-container">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="profile-avatar">
                    <img src="https://cellphones.com.vn/sforum/wp-content/uploads/2023/10/avatar-trang-4.jpg" alt="Profile Picture">
                    <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                </div>
                <ul class="menu">
                <li class="<?php echo ($current_page == 'account.php') ? 'active' : ''; ?>"><a href="account.php">Dashboard</a></li>
                <li><a href="account.php">Account Details</a></li>
                <li class="<?php echo ($current_page == 'editprofile.php') ? 'active' : ''; ?>"><a href="editprofile.php">Edit Profile</a></li>
                <li><a href="loginsrc.php">Logout</a></li>
                <li><a href="homepage.php">Back to homepage</a></li>

                </ul>
            </div>

            <!-- Main Content -->
            <div class="profile-content">
                <h2>Account Settings</h2>
                <form method="POST" action="updatein4.php" class="profile-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" required> <br> <br> <br>
                            <label>New Email</label>
                            <input type="email" name="email" placeholder="Enter new email" required>
                        </div> 
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" value="<?php echo $_SESSION['password']; ?>" required> <br> <br> <br>
                            <label>New Password</label>
                            <input type="password" name="password" placeholder="Enter new password" required>
                        </div> 
                    </div> <br> 
                    <button type="submit" class="save-button">Save Changes</button>
                </form>
            </div>
        </div>
    </body>
    </html>

