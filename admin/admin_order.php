<?php
include("../menu/menu_admin.php");

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] || $_SESSION['level'] !== 'A') {
    echo "ปฏิเสธการเข้าใช้. คุณต้องเป็นผู้ดูแลระบบจึงจะสามารถดูหน้านี้ได้.";
    exit();
}


// Check if a status update has been submitted
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    // Update status in the orders table using prepared statement
    $update_order_query = "UPDATE orders SET status = ? WHERE order_id = ?";
    $update_order_stmt = mysqli_prepare($con, $update_order_query);

    mysqli_stmt_bind_param($update_order_stmt, "si", $new_status, $order_id);
    $update_order_result = mysqli_stmt_execute($update_order_stmt);

    if (!$update_order_result) {
        echo "Error updating order status: " . mysqli_error($con);
    }

    // Check if the update was successful
    if ($update_order_result) {
        // Insert into order_history and delete from orders if status is 'ได้รับสินค้าแล้ว'
        if ($new_status === 'ได้รับสินค้าแล้ว') {
            // Use a transaction for atomic operations
            mysqli_autocommit($con, false);

            // Insert into order_history
            $insert_history_query = "INSERT INTO order_history (order_id, status, update_date) VALUES (?, ?, NOW())";
            $insert_history_stmt = mysqli_prepare($con, $insert_history_query);

            mysqli_stmt_bind_param($insert_history_stmt, "is", $order_id, $new_status);
            $insert_history_result = mysqli_stmt_execute($insert_history_stmt);

            if (!$insert_history_result) {
                echo "Error inserting into order_history: " . mysqli_error($con);
                mysqli_rollback($con);
            } else {
                // Delete the order from orders table
                $delete_order_query = "DELETE FROM orders WHERE order_id = ?";
                $delete_order_stmt = mysqli_prepare($con, $delete_order_query);

                mysqli_stmt_bind_param($delete_order_stmt, "i", $order_id);
                $delete_order_result = mysqli_stmt_execute($delete_order_stmt);

                if (!$delete_order_result) {
                    echo "Error deleting order: " . mysqli_error($con);
                    mysqli_rollback($con);
                } else {
                    // Commit the transaction if both operations were successful
                    mysqli_commit($con);
                }
            }
        }

        // Redirect to admin_order.php
        echo "<script>
                window.location.href = 'admin_order.php';
              </script>";
    } else {
        echo "Error updating status in orders.";
    }

    mysqli_stmt_close($update_order_stmt);
    mysqli_stmt_close($insert_history_stmt);
    mysqli_stmt_close($delete_order_stmt);
}

// Fetch all orders using prepared statement
$fetch_orders_query = "SELECT orders.*, users.first_name, products.product_name, products.product_price, order_details.quantity, order_details.subtotal, addresses.*
                       FROM orders
                       JOIN users ON orders.user_id = users.user_id
                       JOIN order_details ON orders.order_id = order_details.order_id
                       JOIN products ON order_details.product_id = products.product_id
                       JOIN addresses ON orders.user_id = addresses.user_id
                       WHERE orders.status != 'ได้รับสินค้าแล้ว'
                       ORDER BY orders.order_date DESC";

$fetch_orders_stmt = mysqli_prepare($con, $fetch_orders_query);
mysqli_stmt_execute($fetch_orders_stmt);
$orders_result = mysqli_stmt_get_result($fetch_orders_stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order</title>
    <link rel="stylesheet" href="path/to/tailwind.css"> <!-- Make sure to include the correct path -->

    <style>
        /* Custom styles can go here */
    </style>
</head>

<body>

    <div class="mx-auto w-full max-w-screen-xl">
        <h1 class="text-2xl font-bold mb-4">รายการคำสั่งซื้อทั้งหมด</h1>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">ที่อยู่</th>
                        <th scope="col" class="px-6 py-3">ชื่อ</th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">ชื่อสินค้า</th>
                        <th scope="col" class="px-6 py-3">จำนวน</th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">ราคารวม</th>
                        <th scope="col" class="px-6 py-3">สถานะ</th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">เวลา</th>
                        <th scope="col" class="px-6 py-3">จัดการ</th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">ยืนยัน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order_data = mysqli_fetch_assoc($orders_result)) { ?>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-9 py-4 bg-gray-50 dark:bg-gray-800"><?= $order_data['address_line1'] ?><?= $order_data['address_line2'] ?>อ.<?= $order_data['District'] ?>จ.<?= $order_data['city'] ?>ต.<?= $order_data['Subdistrict'] ?><?= $order_data['postal_code'] ?></td>
                            <td class="px-9 py-4"><?= $order_data['first_name'] ?></td>
                            <td class="px-9 py-4 bg-gray-50 dark:bg-gray-800"><?= $order_data['product_name'] ?></td>
                            <td class="px-9 py-4"><?= $order_data['quantity'] ?></td>
                            <td class="px-9 py-4 bg-gray-50 dark:bg-gray-800"><?= $order_data['total_amount'] ?></td>
                            <td class="px-9 py-4 text-<?= getStatusColor($order_data['status']) ?>"><?= $order_data['status'] ?></td>
                            <td class="px-9 py-4 bg-gray-50 dark:bg-gray-800"><?= $order_data['order_date'] ?></td>
                            <td class="px-9 py-4">
                                <form method='post' action='admin_order.php'>
                                    <input type='hidden' name='order_id' value='<?= $order_data['order_id'] ?>'>
                                    <select name='new_status' class='border rounded p-1' <?= ($order_data['status'] !== 'รอดำเนินการ' ? 'disabled' : '') ?>>
                                        <option value='กำลังจัดส่ง' <?= ($order_data['status'] === 'กำลังจัดส่ง' ? 'selected' : '') ?>>กำลังจัดส่ง</option>
                                    </select>
                            </td>
                            <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                <button type='submit' name='update_status' class='bg-blue-500 text-white px-4 py-2 rounded-full' <?= ($order_data['status'] !== 'รอดำเนินการ' ? 'disabled' : '') ?>>
                                    ยืนยัน
                                </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
            
        </div>
    </div>

</body>

</html>


<?php
// Free result set
mysqli_free_result($orders_result);

// Close database connection
mysqli_close($con);

// Function to determine status color
function getStatusColor($status)
{
    switch ($status) {
        case 'รอดำเนินการ':
            return 'orange';
        case 'กำลังจัดส่ง':
            return 'blue';
        case 'ได้รับสินค้าแล้ว':
            return 'green';
        default:
            return 'black';
    }
}
?>
