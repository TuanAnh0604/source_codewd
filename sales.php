<?php
session_start(); // Bắt buộc phải gọi session_start() trước khi truy cập $_SESSION

// Kiểm tra nếu người dùng đã đăng nhập (kiểm tra sự tồn tại của $_SESSION['username'])
if (!isset($_SESSION['username'])) {
    // Nếu chưa đăng nhập, bạn có thể chuyển hướng đến trang đăng nhập
    header("Location: loginsrc.php");
    exit;
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
    <div class="products_box">
<?php
// Kết nối tới cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "webfashion";
$port = 4306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy dữ liệu sản phẩm có giảm giá
$sql = "SELECT id, name, description, price, sale_price, image_url
        FROM products
        WHERE sale_price < price AND sale_price > 0";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ProductID = $row['id'];
        $ProductName = $row['name'];
        $Description = $row['description'];
        $OriginalPrice = $row['price'];
        $SalePrice = $row['sale_price'];
        $ImageURL = $row['image_url'];

        // Giá hiển thị (ưu tiên giá giảm nếu có)
        $DisplayPrice = $SalePrice && $SalePrice < $OriginalPrice ? $SalePrice : $OriginalPrice;

        // Tính phần trăm giảm giá
        $Discount = $SalePrice && $SalePrice < $OriginalPrice
        ? round((($OriginalPrice - $SalePrice) / $OriginalPrice) * 100)
        : 0;
        ?>
    <form class="single_product" action="product.php" method="POST">
    <h3><?php echo htmlspecialchars($ProductName); ?></h3>
    <img src="<?php echo htmlspecialchars("product.img/$ImageURL"); ?>" alt="<?php echo htmlspecialchars($ProductName); ?>">
    <p class="product-description"><?php echo htmlspecialchars($Description); ?></p>
    <div class="price-section">
        <span class="current-price"><?php echo number_format($DisplayPrice, 2, '.', ','); ?>$</span>
        <?php if ($SalePrice && $SalePrice < $OriginalPrice): ?>
            <span class="original-price"><?php echo number_format($OriginalPrice, 2, '.', ','); ?>$</span>
        <?php endif;?>
        <?php if ($Discount > 0): ?>
            <span class="discount-tag">-<?php echo $Discount; ?>%</span>
        <?php endif;?>
    </div>
    <div class="btn-container">
        <button type="submit" name="add_to_cart" class="btn btn-success">Add to Cart</button>
        <input type="hidden" name="ProductID" value="<?php echo $ProductID; ?>">
        <input type="hidden" name="ProductName" value="<?php echo htmlspecialchars($ProductName); ?>">
        <input type="hidden" name="Description" value="<?php echo htmlspecialchars($Description); ?>">
        <input type="hidden" name="Price" value="<?php echo $OriginalPrice; ?>"> <!-- Giá gốc -->
        <input type="hidden" name="SalePrice" value="<?php echo $SalePrice; ?>"> <!-- Giá giảm -->
        <input type="hidden" name="ImageURL" value="<?php echo htmlspecialchars($ImageURL); ?>">
    </div>
</form>


        <?php
}
} else {
    echo "<p>No products found.</p>";
}
$conn->close();
?>
</div>
</body>
</html>
