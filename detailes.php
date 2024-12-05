<?php
// Kết nối cơ sở dữ liệu
$connect = mysqli_connect('localhost', 'root', '', 'webfashion', '4306');
if (!$connect) {
    die('Lỗi kết nối cơ sở dữ liệu');
}

// Kiểm tra nếu 'id' có trong URL không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID sản phẩm không hợp lệ');
}

// Lấy giá trị 'id' từ URL và đảm bảo an toàn bằng intval()
$id = intval($_GET['id']); // intval giúp bảo vệ chống SQL Injection

// Truy vấn cơ sở dữ liệu để lấy thông tin sản phẩm theo id
$sql = "SELECT * FROM products WHERE id = {$id}";
$result = mysqli_query($connect, $sql);

// Kiểm tra nếu có dữ liệu trả về
if (mysqli_num_rows($result) > 0) {
    // Lấy dữ liệu sản phẩm
    $row = mysqli_fetch_assoc($result);
    $product_name = $row['name'];
    $product_description = $row['description'];
    $price = $row['price'];
    $saleprice = $row['sale_price'];
    $image_url = $row['image_url']; // Lấy URL hình ảnh từ trường 'img_url'
} else {
    die('Không tìm thấy sản phẩm');
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="detailes.css">
</head>
<body>

    <div class="product-container">
        <!-- Product Image -->
        <div class="product-image">
            <?php if (!empty($image_url)): ?>
                <img src="product.img/<?php echo $image_url; ?>" alt="<?php echo $product_name; ?>" style="width:600px;height:500px;">
            <?php else: ?>
                <p>Hình ảnh sản phẩm không có</p>
            <?php endif;?>
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <h2><?php echo $product_name; ?></h2>
            <p class="price">Giá: <?php echo number_format($price, 2) . " $"; ?></p>
            <?php if ($saleprice > 0 && $saleprice < $price): ?>
                <p class="sale-price">Giảm giá: <?php echo number_format($saleprice, 2) . " $"; ?></p>
            <?php endif;?>



            <div class="product-description">
                <h3>Description:</h3>
                <p><?php echo $product_description; ?></p>
            </div>
           <!-- Nút "Quay về trang chủ" -->
<div class="back-to-home">
    <a href="homepage.php">
        <button class="back-to-home-btn">Back to homepage</button>
    </a>
    
</div>
        </div>
    </div>

</body>
</html>


<?php
// Đóng kết nối
mysqli_close($connect);
?>
