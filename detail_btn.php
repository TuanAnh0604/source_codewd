<?php
// Kết nối đến cơ sở dữ liệu
$connect = mysqli_connect('localhost', 'root', '', 'webfashion', '4306');
if (!$connect) {
    die('Lỗi kết nối cơ sở dữ liệu');
}

// Kiểm tra xem 'id' có trong URL không
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID sản phẩm không hợp lệ');
}

// Lấy giá trị 'id' từ URL và đảm bảo an toàn bằng intval()
$id = intval($_GET['id']); // intval sẽ chuyển id thành số nguyên

// Truy vấn cơ sở dữ liệu để lấy thông tin sản phẩm theo id
$sql = "SELECT * FROM product WHERE product_id = {$id}";
$result = mysqli_query($connect, $sql);

// Kiểm tra kết quả truy vấn
if (mysqli_num_rows($result) > 0) {
    // Lấy dữ liệu sản phẩm từ kết quả truy vấn
    $row = mysqli_fetch_assoc($result);
    $product_id = $row['id'];
    $product_name = $row['name'];
    $product_image = $row['image_ur;'];
    $price = $row['price'];
    $product_description = $row['description'];
    $saleprice = $row['sale_price'];
} else {
    die('Không tìm thấy sản phẩm');
}

// Đóng kết nối
mysqli_close($connect);
?>
