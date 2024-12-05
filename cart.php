<?php
session_start(); // Khởi động session

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<script>alert('You must log in to view your cart.');</script>";
    echo "<script>window.location.href='loginsrc.php';</script>";
    exit;
}

$username = $_SESSION['username']; // Lấy username từ session
$connect = new mysqli('localhost', 'root', '', 'webfashion', 4306);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Lấy user_id từ username
$sql_user = "SELECT id FROM users WHERE username = ?";
$stmt = $connect->prepare($sql_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_user = $stmt->get_result();

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $user_id = $row_user['id']; // Lấy user_id
} else {
    echo "<script>alert('User not found. Please log in again.');</script>";
    echo "<script>window.location.href='loginsrc.php';</script>";
    exit;
}

// Xử lý xóa sản phẩm khi bấm nút Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (isset($_POST['product_id']) && isset($user_id)) {
        $product_id = intval($_POST['product_id']); // Lấy ID sản phẩm cần xóa

        // Xóa sản phẩm từ bảng cart
        $delete_query = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
        $stmt_delete = $connect->prepare($delete_query);
        $stmt_delete->bind_param("ii", $product_id, $user_id);

        if ($stmt_delete->execute()) {
            echo "<script>alert('Product removed successfully!');</script>";
        } else {
            echo "<script>alert('Failed to remove product.');</script>";
        }

        $stmt_delete->close();

        // Reload lại trang để cập nhật danh sách sản phẩm
        echo "<script>window.location.href='cart.php';</script>";
        exit;
    }
}

// Truy vấn dữ liệu giỏ hàng của người dùng
$sql_cart = "SELECT c.product_id, 
                    c.product_name, 
                    IF(p.sale_price > 0, p.sale_price, p.price) AS final_price, 
                    c.quantity, 
                    (IF(p.sale_price > 0, p.sale_price, p.price) * c.quantity) AS total_price 
             FROM cart c
             JOIN products p ON c.product_id = p.id
             WHERE c.user_id = ?";

$stmt_cart = $connect->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div class="cart-container">
        <div class="cart-items">
            <h2>Your Cart</h2>
            <?php if ($result_cart && $result_cart->num_rows > 0): ?>
                <?php
                $total_cost = 0;
                while ($row = $result_cart->fetch_assoc()):
                    $total_cost += $row['total_price'];
                ?>
                <div class="cart-item">
                    <div class="item-details">
                        <h4><?php echo htmlspecialchars($row['product_name']); ?></h4>
                        <p><strong>Price:</strong> <?php echo number_format($row['final_price'], 2); ?>$</p>
                        <p><strong>Quantity:</strong> <?php echo $row['quantity']; ?></p>
                    </div>
                    <div class="item-total">
                        <p><strong>Total:</strong> <?php echo number_format($row['total_price'], 2); ?>$</p>
                    </div>
                    <form method="POST" action="cart.php" class="delete-form">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>
        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <div class="cart-total">
                <p><strong>Total Cost:</strong> <?php echo isset($total_cost) ? number_format($total_cost, 2) : 0; ?>$</p>
            </div>
            <a href="homepage.php" class="rollback-btn">Back to homepage</a>
        </div>
    </div>
</body>
</html>

<?php
// Đóng kết nối
$stmt_cart->close();
$stmt->close();
$connect->close();
?>
