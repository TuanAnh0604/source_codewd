<?php
session_start(); // Đảm bảo session được khởi động

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    // Kết nối cơ sở dữ liệu
    $connect = mysqli_connect('localhost', 'root', '', 'webfashion', '4306');
    if (!$connect) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    // Kiểm tra session để lấy user_id
    if (!isset($_SESSION['username'])) {
        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        header("Location: loginsrc.php");
        exit;
    }
    $userID = $_SESSION['id']; // lưu `id` trong session khi đăng nhập
    $ProductID = $_POST['ProductID'];
    $ProductName = mysqli_real_escape_string($connect, $_POST['ProductName']);
    $Description = mysqli_real_escape_string($connect, $_POST['Description']);
    $Price = $_POST['Price'];
    $SalePrice = isset($_POST['SalePrice']) ? $_POST['SalePrice'] : 0; // Giá giảm (nếu có)
    $Price = ($SalePrice > 0) ? $SalePrice : $_POST['Price']; // Ưu tiên giá giảm nếu có, nếu không thì giá gốc
    $ImageURL = mysqli_real_escape_string($connect, $_POST['ImageURL']);
    $Quantity = 1; // Mặc định số lượng khi thêm là 1
    $currentTime = date('Y-m-d H:i:s');

    // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
    $check_query = "SELECT * FROM cart WHERE user_id = $userID AND product_id = $ProductID";
    $check_result = mysqli_query($connect, $check_query);
    // //    // Kiểm tra giá: nếu có SalePrice thì dùng, nếu không dùng Price
    // $price = isset($_POST['SalePrice']) && $_POST['SalePrice'] > 0
    // ? $_POST['SalePrice']
    // : $_POST['Price'];
    if (mysqli_num_rows($check_result) > 0) {
        // Nếu sản phẩm đã tồn tại, tăng số lượng
        $update_query = "UPDATE cart
        SET quantity = quantity + 1, updated_at = '$currentTime'
        WHERE user_id = $userID AND product_id = $ProductID";
        mysqli_query($connect, $update_query);
    } else {
        // Nếu sản phẩm chưa tồn tại, thêm mới
        $insert_query = "INSERT INTO cart (user_id, product_id, product_name, quantity, created_at, updated_at)
        VALUES ($userID, $ProductID, '$ProductName', $Quantity, '$currentTime', '$currentTime')";
        mysqli_query($connect, $insert_query);
    }

    mysqli_close($connect);
    // Chuyển hướng lại trang hiện tại hoặc giỏ hàng
    header("Location: cart.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Fashion Homepage</title>
<link rel="stylesheet" href="homepage.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQS2Vbaq3BSscVWdKIlL0VSghW5_N9SxKDdA&s" alt="Logo">
        <h4>Tuan Anh Shop</h4>
        </div>
        <nav class="menu">
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="sales.php">Sales</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="account.php">Account</a></li>
            </ul>

        </nav>
        <div class="header-icons">
        <!-- Khi người dùng click vào Profile sẽ mở modal chỉnh sửa -->
        <a href="#" onclick="openProfileModal()"><i class="fas fa-user"></i></a>
        <a href="#"><i class="fas fa-heart"></i></a>
        <a href="#"><i class="fas fa-shopping-cart"></i><span class="cart-count">0</span></a>
    </div>
    <!-- Modal chỉnh sửa thông tin người dùng -->
<div class="modal-overlay" id="modalOverlay" onclick="closeProfileModal()"></div>
<div class="profile-modal" id="profileModal">
    <h2>Edit Profile</h2>
    <form method="POST" action="update_profile.php">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" required><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" required><br>
        <label>Password:</label>
        <input type="text" name="password" value="<?php echo $_SESSION['password']; ?>" required><br>
        <button type="submit">Update</button>
    </form>
</div>



    </header>
<!-- Hiển thị thông báo thành công -->
<?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Profile updated successfully!
        </div>
    <?php endif;?>
    <!-- Hero Section with Carousel -->
    <section id="hero-carousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://brandsego.com/cdn/shop/collections/Screenshot_42_1200x.progressive.png.jpg?v=1696060836" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Summer Sale</h5>
                    <p>Enjoy up to 50% off on selected items!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://scontent.fhan14-4.fna.fbcdn.net/v/t39.30808-6/242733993_332677781982396_5289096665470154803_n.jpg?_nc_cat=107&ccb=1-7&_nc_sid=cc71e4&_nc_ohc=kOgL8rSgcQwQ7kNvgHGZ_NQ&_nc_zt=23&_nc_ht=scontent.fhan14-4.fna&_nc_gid=AG-Q5MhxbdHtgQ0UxOFCa4V&oh=00_AYBH_dssAhorX2437kxGzfGwNwEYoEgUdOxh_60TaIf3YQ&oe=67491A05" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>New Collection</h5>
                    <p>Check out the latest trends and arrivals.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://png.pngtree.com/template/20220318/ourlarge/pngtree-tmall-taobao-men-s-clothing-men-s-god-s-day-poster-image_895178.jpg" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Free Shipping</h5>
                    <p>Free shipping on orders over $100.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>

    <script>
       // Hàm mở modal khi người dùng click vào Profile
function openProfileModal() {
    document.getElementById('modalOverlay').style.display = 'block';
    document.getElementById('profileModal').style.display = 'block';
}

// Hàm đóng modal khi người dùng click ngoài modal hoặc đóng nút
function closeProfileModal() {
    document.getElementById('modalOverlay').style.display = 'none';
    document.getElementById('profileModal').style.display = 'none';
}
    </script>
    </section>

    <!-- Display Products -->
    <section id="products" class="container">
    <h2>Products</h2>
    <div class="row">
        <div class="products_box">

<?php
$connect = mysqli_connect('localhost', 'root', '', 'webfashion', '4306');
if (!$connect) {
    echo 'Error';
}

$sql = "SELECT * FROM products LIMIT 16";
$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result) > 0) {

    while ($row_product = mysqli_fetch_assoc($result)) {

        $ProductID = $row_product['id'];
        $ProductName = $row_product['name'];
        $Description = $row_product['description'];
        $Price = $row_product['price'];
        $ImageURL = $row_product['image_url'];
        ?>
                    <!-- Hiển thị sản phẩm -->
                    <form class="single_product" action="product.php" method="POST">
                    <h3><?php echo htmlspecialchars($ProductName); ?></h3>
                    <img src="<?php echo htmlspecialchars("product.img/$ImageURL"); ?>" alt="<?php echo htmlspecialchars($ProductName); ?>">
                    <p style="margin: 10px;"><?php echo htmlspecialchars($Description); ?></p>
                    <p><b>Price: <?php echo number_format($Price, 0, ',', '.'); ?>$</b></p>
                    <div class="btn-container">
                    <a href="detailes.php?id=<?php echo $ProductID ?>" class="btn btn-info">Details</a>
                    <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
                    <!-- Truyền các giá trị cần thiết qua POST -->
                    <input type="hidden" name="ProductID" value="<?php echo $ProductID; ?>">
                    <input type="hidden" name="ProductName" value="<?php echo htmlspecialchars($ProductName); ?>">
                    <input type="hidden" name="Description" value="<?php echo htmlspecialchars($Description); ?>">
                    <input type="hidden" name="Price" value="<?php echo $Price; ?>">
                    <input type="hidden" name="ImageURL" value="<?php echo htmlspecialchars($ImageURL); ?>">
                    </div>
                    </form>


                    <?php
}
} else {
    echo "<p class='text-center'>No products found.</p>";
}
mysqli_close($connect);

?>
<!-- m cho t nghich bai m ko
=)) m muốn nghịch cái gì như chat của hoi
vấn đề là cái add to cart này t có bảng kết nối rồi -->
<!-- vấn đề nó đéo lưu vào cở sở dữ liệu kia kìa ?? m có đeo bảng cart đâu mà? luu
 tao có ?? Lỗi đang ở phần add to carrt kia kìa khi bấm vô nó đ lưu được vào csdl ?? -->
<!-- /// đăng nhập cái id 1 thì nó hiện ra cart  sang mấy id khác thì không hiện -->

</div>

    <!-- Add Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="morepro.js"></script>
    <!-- Footer Section -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- Dịch vụ khách hàng -->
            <div class="col-md-4">
                <h5>Dịch vụ khách hàng</h5>
                <ul>
                    <li><a href="#">Chính sách khách hàng thân thiết</a></li>
                    <li><a href="#">Chính sách đổi trả</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                    <li><a href="#">Chính sách thanh toán, giao nhận</a></li>
                    <li><a href="#">Chính sách đơn đồng phục</a></li>
                    <li><a href="#">Hướng dẫn chọn size</a></li>
                    <li><a href="#">Đăng ký đối tác</a></li>
                </ul>
            </div>

            <!-- Về Julie Shop -->
            <div class="col-md-4">
                <h5>Về Julie Shop</h5>
                <ul>
                    <li><a href="#">Giới thiệu</a></li>
                    <li><a href="#">Liên hệ</a></li>
                    <li><a href="#">Tuyển dụng</a></li>
                    <li><a href="#">Tin tức</a></li>
                    <li><a href="#">Hệ thống cửa hàng</a></li>
                    <li><a href="#">Tin khuyến mãi</a></li>
                </ul>
                <p>Địa chỉ: 303 / 40/ 19 Xuân Phương - Nam Từ Liêm</p>
            </div>

            <!-- Liên hệ -->
            <div class="col-md-4">
                <h5>Julie Shop lắng nghe bạn</h5>
                <p>Chúng tôi luôn trân trọng và mong đợi nhận được mọi ý kiến đóng góp từ khách hàng để có thể nâng cấp trải nghiệm dịch vụ và sản phẩm tốt hơn nữa.</p>
                <ul>
                    <li><i class="fas fa-phone"></i> Liên hệ đặt hàng: 035 552 2000 </li>
                    <li><i class="fas fa-headset"></i> Góp ý khiếu nại: 1800 2086</li>
                    <li><i class="fas fa-envelope"></i> Email: chamsockhachhang@julieshop.vn</li>
                </ul>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-zalo"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 Công ty Thời Trang Julie Shop. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</footer>

</body>
</html>
