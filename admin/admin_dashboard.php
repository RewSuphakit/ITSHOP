<?php
include("../menu/menu_admin.php");

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] || $_SESSION['level'] !== 'A') {
    echo "ปฏิเสธการเข้าใช้. คุณต้องเป็นผู้ดูแลระบบจึงจะสามารถดูหน้านี้ได้.";
    exit();
}

// Count the number of users
$user_count_query = "SELECT COUNT(*) AS user_count FROM users";
$user_count_result = mysqli_query($con, $user_count_query);
$user_count = ($user_count_result) ? mysqli_fetch_assoc($user_count_result)['user_count'] : 0;

// Count the number of products
$product_count_query = "SELECT COUNT(*) AS product_count FROM products";
$product_count_result = mysqli_query($con, $product_count_query);
$product_count = ($product_count_result) ? mysqli_fetch_assoc($product_count_result)['product_count'] : 0;

// Count the number of orders
$order_count_query = "SELECT COUNT(*) AS order_count FROM receipts";
$order_count_result = mysqli_query($con, $order_count_query);
$order_count = ($order_count_result) ? mysqli_fetch_assoc($order_count_result)['order_count'] : 0;
$thaiMonthNames = [
    1 => 'มกราคม',
    2 => 'กุมภาพันธ์',
    3 => 'มีนาคม',
    4 => 'เมษายน',
    5 => 'พฤษภาคม',
    6 => 'มิถุนายน',
    7 => 'กรกฎาคม',
    8 => 'สิงหาคม',
    9 => 'กันยายน',
    10 => 'ตุลาคม',
    11 => 'พฤศจิกายน',
    12 => 'ธันวาคม'
];
$thaiDayNames = [
    'อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'
];
// Fetch daily sales data for the chart
$daily_sales_query = "SELECT DATE_FORMAT(timestamp, '%Y-%m') AS sale_month, SUM(total_amount) AS monthly_sales
                     FROM receipts
                     WHERE DATE(timestamp) >= CURDATE() - INTERVAL 6 MONTH
                     GROUP BY DATE_FORMAT(timestamp, '%Y-%m')
                     ORDER BY DATE_FORMAT(timestamp, '%Y-%m')";
$daily_sales_result = mysqli_query($con, $daily_sales_query);

// Extract data for the sales chart
$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($daily_sales_result)) {
    // Extract month number from the formatted month-year string
    $monthNumber = explode('-', $row['sale_month'])[1];

    // Use the Thai month name based on the mapping
    $labels[] = $thaiMonthNames[$monthNumber];
    $data[] = $row['monthly_sales'];
}

$chart_labels = json_encode($labels);
$chart_data = json_encode($data);
$daily_order_query = "SELECT DATE(order_date) AS order_day, COUNT(order_id) AS daily_orders
                      FROM orders
                      WHERE DATE(order_date) >= CURDATE() - INTERVAL 6 DAY
                      GROUP BY DATE(order_date)
                      ORDER BY DATE(order_date) desc";
$daily_order_result = mysqli_query($con, $daily_order_query);

// Extract data for the order chart
$order_labels = [];
$order_data = [];

while ($row = mysqli_fetch_assoc($daily_order_result)) {
    $dayNumber = date('w', strtotime($row['order_day'])); // Get day number (0-6)
    $order_labels[] = $thaiDayNames[$dayNumber] . ' ' . $row['order_day'];
    $order_data[] = $row['daily_orders'];
}

$chart_order_labels = json_encode($order_labels, JSON_UNESCAPED_UNICODE);
$chart_order_data = json_encode($order_data);

// Count the number of products in each category
$product_category_query = "SELECT c.category_name, COUNT(p.product_id) AS category_count 
                           FROM categories c 
                           LEFT JOIN products p ON c.category_id = p.product_category_id 
                           GROUP BY c.category_id";

$product_category_result = mysqli_query($con, $product_category_query);

// Extract data for the product distribution chart
$category_labels = [];
$category_data = [];
while ($row = mysqli_fetch_assoc($product_category_result)) {
    $category_labels[] = $row['category_name'];
    $category_data[] = $row['category_count'];
}

$chart_category_labels = json_encode($category_labels);
$chart_category_data = json_encode($category_data);

// Free result sets
if ($user_count_result) mysqli_free_result($user_count_result);
if ($product_count_result) mysqli_free_result($product_count_result);
if ($order_count_result) mysqli_free_result($order_count_result);
if ($daily_sales_result) mysqli_free_result($daily_sales_result);



// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>

<body>
    <div class="mx-auto w-full max-w-screen-xl">
    <h1 class="text-3xl font-semibold my-4">Admin Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="border border-blue-500 bg-blue-500 text-white p-4 shadow-md rounded-md flex items-center justify-between">
        <div>
            <h5 class="text-lg font-semibold mb-2">รายการสมาชิก</h5>
            <p><?= $user_count; ?></p>
        </div>
        <i class="fas fa-users text-4xl"></i>
    </div>
    <div class="border border-green-500 bg-green-500 text-white p-4 shadow-md rounded-md flex items-center justify-between">
        <div>
            <h5 class="text-lg font-semibold mb-2">รายการสินค้า</h5>
            <p><?= $product_count; ?></p>
        </div>
        <i class="fas fa-box text-4xl"></i>
    </div>
    <div class="border border-pink-500 bg-pink-500 text-white p-4 shadow-md rounded-md flex items-center justify-between">
        <div>
            <h5 class="text-lg font-semibold mb-2">รายการออเดอร์</h5>
            <p><?= $order_count; ?></p>
        </div>
        <i class="fas fa-shopping-cart text-4xl"></i>
    </div>
    <div class="border border-yellow-500 bg-yellow-500 text-white p-4 shadow-md rounded-md flex items-center justify-between">
        <div>
            <h5 class="text-lg font-semibold mb-2">ยอดขาย</h5>
            <p><?= number_format(array_sum($data)); ?></p>
        </div>
        <i class="fa fa-btc fa-2x text-4xl"></i>
        
    </div>
</div>


        <!-- Sales Chart -->
        <div class="mt-8">
            <div class="bg-white p-4 shadow-md rounded-md">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <!-- Product Distribution Chart -->
        <div class="mt-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 shadow-md rounded-md">
                    <canvas id="productChart"></canvas>
                </div>
                <div class="bg-white p-4 shadow-md rounded-md">
                <canvas id="orderChart"></canvas>
            </div>
        </div>
      </div>
   
        <!-- Order Chart -->
        <div class="mt-8">
            <div class="bg-white p-4 shadow-md rounded-md">
            <?php include('table_o.php')?>
            </div>
        </div>

   
    </div>
<br>
    <script>
        var salesChart = document.getElementById('salesChart').getContext('2d');
        var productChart = document.getElementById('productChart').getContext('2d');

        var thaiMonthNames = [
            'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
        ];

        var myBarChart = new Chart(salesChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels, JSON_UNESCAPED_UNICODE); ?>,
                datasets: [{
                    label: 'ยอดขายรายเดือน',
                    data: <?= $chart_data; ?>,
                    backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgba(255,99,132,1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)'
                                                ],
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });     



        var myDoughnutChart = new Chart(productChart, {
            type: 'doughnut',
            data: {
                labels: <?= $chart_category_labels; ?>,
                datasets: [{
                    
                    data: <?= $chart_category_data; ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#9C27B0', '#FF9800','#DCBFFF','#87C4FF'],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Order Chart
        var orderChart = document.getElementById('orderChart').getContext('2d');

        var myOrderChart = new Chart(orderChart, {
            type: 'bar',
            data: {
                labels: <?= $chart_order_labels; ?>,
                datasets: [{
                    label: 'จำนวนคำสั่งซื้อรายวัน',
                    data: <?= $chart_order_data; ?>,
                    backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgba(255,99,132,1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)'
                                                ],
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <?php include '../components/footer.php'?>
</body>

</html>