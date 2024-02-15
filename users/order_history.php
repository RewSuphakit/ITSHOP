<?php
include("../connection/connect.php");
include '../menu/menu_user.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['user_id']) {
    echo "Access denied. Please log in.";
    exit();
}

$user_id = $_SESSION['user_id'];

$order_history_query = "
SELECT
    orders.order_date,
    orders.status,
    orders.user_id,
    orders.order_id,
    order_details.product_id,
    order_details.quantity,
    order_details.subtotal,
    products.product_name AS product_name,
    products.product_stock,
    products.product_img,
    products.product_price,
    products.dateup,
    products.product_category_id
FROM orders
LEFT JOIN order_details ON orders.order_id = order_details.order_id
LEFT JOIN products ON order_details.product_id = products.product_id
WHERE orders.user_id = ?
ORDER BY orders.order_id DESC";


if ($order_history_stmt = mysqli_prepare($con, $order_history_query)) {
    mysqli_stmt_bind_param($order_history_stmt, "i", $user_id);
    mysqli_stmt_execute($order_history_stmt);

    $order_history_result = mysqli_stmt_get_result($order_history_stmt);

    if (!$order_history_result) {
        echo "Error in query: " . mysqli_error($con);
        exit();
    }

    if ($order_history_result && mysqli_num_rows($order_history_result) > 0) {
?>

<div class="container">
    <h1>ประวัติการสั่งซื้อ</h1>
    <div class="row">
        <?php while ($order_history_data = mysqli_fetch_assoc($order_history_result)) : ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100" style="box-shadow: rgba(50, 50, 105, 0.15) 0px 2px 5px 0px, rgba(0, 0, 0, 0.05) 0px 1px 1px 0px;">
                    <img src='../product_image/<?php echo $order_history_data['product_img']; ?>' class="card-img-top product-img" alt="Product Image" style='height: 200px; object-fit: contain;'>
                    <div class="card-body">
                        <h6 class="card-title" style="min-height: 40px;"><?= $order_history_data['product_name']; ?></h6>
                        <p class="card-text">จำนวน: x<?= $order_history_data['quantity']; ?></p>
                        <p class="card-text">ราคาต่อหน่วย: <?= $order_history_data['product_price']; ?></p>
                        <p class="card-text">ยอดรวม: <?= $order_history_data['subtotal']; ?></p>
                        <p class="card-text">
                            <span class="<?php
                                            switch ($order_history_data['status']) {
                                                case 'รอดำเนินการ':
                                                    echo 'badge rounded-pill text-bg-warning';
                                                    break;
                                                case 'กำลังจัดส่ง':
                                                    echo 'badge rounded-pill text-bg-primary';
                                                    break;
                                                case 'ได้รับสินค้าแล้ว':
                                                    echo 'badge rounded-pill text-bg-success';
                                                    break;
                                                default:
                                                    echo 'badge rounded-pill text-bg-dark';
                                                    break;
                                            }
                                            ?>"><?= $order_history_data['status']; ?>
                            </span>
                        </p>
                        <div class="text-center">
                            <?php if ($order_history_data['status'] === 'กำลังจัดส่ง') : ?>
                                <form method="post" action="update_status.php">
                                    <input type="hidden" name="order_id" value="<?= $order_history_data['order_id']; ?>">
                                    <button type="submit" class="btn btn-outline-success">ได้รับสินค้าแล้ว</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>




<?php
    } else {
        echo "<div class='container'><p>ไม่มีประวัติการสั่งซื้อ</p></div>";
    }

    mysqli_free_result($order_history_result);
    mysqli_stmt_close($order_history_stmt);
}

mysqli_close($con);
?>