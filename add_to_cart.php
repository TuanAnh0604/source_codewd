<!-- <?php
if (isset($_GET["add_cart"])) {
    $product_id = intval($_GET['add_cart']); // Lấy product_id từ URL

    if (isset($_SESSION['username']) && $_SESSION['username'] != null) {
        $username = $_SESSION['username'];

        // Kết nối cơ sở dữ liệu
        $connect = new mysqli('127.0.0.1', 'root', '', 'webfashion', 4306);
        if ($connect->connect_error) {
            die("Kết nối cơ sở dữ liệu thất bại: " . $connect->connect_error);
        }
        // Lấy user_id trực tiếp từ session
        if (isset($_SESSION['id'])) {
            $user_id = $_SESSION['id']; // Lấy user_id từ session

        } else {
            echo "<script>alert('You need to log in to perform this action');</script>";
            echo "<script>window.open('loginsrc.php', '_self');</script>";
            exit;
        }

        // Lấy thông tin sản phẩm từ bảng products
        $sql_product = "SELECT name FROM products WHERE id = ?";
        $stmt_product = $connect->prepare($sql_product);
        $stmt_product->bind_param("i", $product_id);
        $stmt_product->execute();
        $result_product = $stmt_product->get_result();

        if ($result_product->num_rows > 0) {
            $row_product = $result_product->fetch_assoc();
            $product_name = $row_product['name']; // Lấy tên sản phẩm

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $sql_check = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?";
            $stmt_check = $connect->prepare($sql_check);
            $stmt_check->bind_param("ii", $product_id, $user_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                // Nếu sản phẩm đã tồn tại, tăng số lượng
                $sql_update = "UPDATE cart SET quantity = quantity + 1, updated_at = NOW() WHERE product_id = ? AND user_id = ?";
                $stmt_update = $connect->prepare($sql_update);
                $stmt_update->bind_param("ii", $product_id, $user_id);
                if ($stmt_update->execute()) {
                    echo "<script>alert('Product quantity updated successfully!');</script>";
                    echo "<script>window.open('index.php', '_self');</script>";
                } else {
                    echo "<script>alert('Error updating product quantity.');</script>";
                }
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $sql_insert = "INSERT INTO cart (id, product_id, user_id, product_name, quantity, created_at, updated_at)
                               VALUES (NULL, ?, ?, ?, 1, NOW(), NOW())";
                $stmt_insert = $connect->prepare($sql_insert);

                if ($stmt_insert) {
                    $stmt_insert->bind_param("iis", $product_id, $user_id, $product_name);
                    if ($stmt_insert->execute()) {
                        echo "<script>alert('Product added to the cart successfully!');</script>";
                        echo "<script>window.open('index.php', '_self');</script>";
                    } else {
                        echo "<script>alert('Error adding product to the cart.');</script>";
                    }
                } else {
                    echo "<script>alert('Error preparing the insert query.');</script>";
                }
            }
        } else {
            echo "<script>alert('Product not found.');</script>";
        }

        // Đóng kết nối cơ sở dữ liệu
        $connect->close();
    } else {
        echo "<script>alert('You need to be logged in to perform this action');</script>";
        echo "<script>window.open('loginsrc.php', '_self');</script>";
    }
}

// khả năng do đoạn kết nối này ? cái cart kia thì nó nhận giá trị rồi  -->
