<?php


$con = mysqli_connect("localhost","root","123456asdzxc","itshop") or die("Error:   " . mysqli_error($conn));
mysqli_query($con,"SET NAMES 'utf8'");


// Fetch all orders using prepared statement
$fetch_orders_query = "SELECT orders.*, users.first_name,users.phone, products.product_name, products.product_price, order_details.quantity, order_details.subtotal, addresses.*
                       FROM orders
                       JOIN users ON orders.user_id = users.user_id
                       JOIN order_details ON orders.order_id = order_details.order_id
                       JOIN products ON order_details.product_id = products.product_id
                       JOIN addresses ON orders.user_id = addresses.user_id
                       WHERE orders.status LIKE 'รอดำเนินการ'
                       ORDER BY orders.order_date DESC ";

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
        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>

    <div class="container mx-auto mt-8">
        <h5 class="text-2xl font-bold mb-4">รายการคำสั่งซื้อ</h5>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $index = 0; ?>
            <?php while ($order_data = mysqli_fetch_assoc($orders_result)) { ?>
                <div class="bg-white dark:bg-gray-700 rounded-md overflow-hidden shadow-md slide-in" style="animation-delay: <?= $index * 0.1 ?>s;">
                    <div class="p-4">
                        <h2 class="text-lg font-bold mb-2"><?= $order_data['first_name'] ?></h2>
                        <p class="text-sm text-gray-500 mb-2"><?= $order_data['order_date'] ?></p>
                        <p class="text-sm text-<?=getStatusColor($order_data['status']) ?> font-semibold mb-2"><?= $order_data['status'] ?></p>
                        <p class="text-sm mb-2"><?= $order_data['quantity'] ?> items</p>
                        <p class="text-sm font-bold"><?= $order_data['total_amount'] ?></p>
                        <p class="text-sm mt-2"><?= $order_data['address_line1'] ?><?= $order_data['address_line2'] ?> อ.<?= $order_data['District'] ?> จ.<?= $order_data['city'] ?> ต.<?= $order_data['Subdistrict'] ?> <?= $order_data['postal_code'] ?></p>
                        <p class="text-sm mt-2"><?= $order_data['phone'] ?></p>
                    </div>
                </div>
                <?php $index++; ?>
            <?php } ?>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            animateCards();
        });

        function animateCards() {
            var cards = document.querySelectorAll('.slide-in');
            cards.forEach(function (card, index) {
                card.style.animationDelay = index * 0.1 + "s";
            });
        }
    </script>

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
