<?php
session_start();

// Kiểm tra nếu user đã đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: loginsrc.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <div class="contact-container">
        <!-- Hình ảnh bên trái -->
        <div class="contact-image">
            <img src="https://jobs.kidsplaza.vn/wp-content/uploads/2023/04/mo-ta-cong-viec-cham-soc-khach-hang.jpg" alt="Contact Image">
        </div>

        <!-- Form bên phải -->
        <div class="contact-form">
            <h2>Contact Us</h2>
            <form action="submit_contact.php" method="POST">
                <!-- Ẩn user_id để gửi -->
                <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
                <div class="form-row">
                    <label for="email">Email <span>*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-row">
                    <label for="subject">Subject <span>*</span></label>
                    <input type="text" id="subject" name="subject" placeholder="Enter your subject" required>
                </div>
                <div class="form-row">
                    <label for="mesage">Message <span>*</span></label>
                    <textarea id="mesage" name="mesage" rows="5" placeholder="Write something" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
            
        </div>
    </div>
</body>
</html>
