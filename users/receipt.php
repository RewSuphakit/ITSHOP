<?php
include("../menu/menu_user.php");

// ตรวจสอบว่ามีการรับค่า receipt_id ผ่านทาง URL หรือไม่
if (isset($_GET['receipt_id'])) {
    $receipt_id = $_GET['receipt_id'];

    // Query เพื่อดึงข้อมูลใบเสร็จและสินค้า
    $receipt_query = "SELECT receipts.*, users.*, addresses.*
                      FROM receipts
                      JOIN users ON receipts.user_id = users.user_id
                      JOIN addresses ON addresses.user_id = users.user_id
                      WHERE receipt_id = ?";
    $stmt_receipt = mysqli_prepare($con, $receipt_query);

    if (!$stmt_receipt) {
        die("Error in receipt query preparation: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt_receipt, "i", $receipt_id);
    mysqli_stmt_execute($stmt_receipt);
    $receipt_result = mysqli_stmt_get_result($stmt_receipt);

    if (!$receipt_result) {
        die("Error in receipt query execution: " . mysqli_error($con));
    }

    if ($receipt_data = mysqli_fetch_assoc($receipt_result)) {
        // แสดงแบบฟอร์มสำหรับปริ้นใบเสร็จ
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Print Receipt</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            
            <style>
               

               

                h1 {
                    text-align: center;
                }

                .receipt-info {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 20px;
                }

                .left-info {
                    text-align: left;
                }

                .right-info {
                    text-align: right;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }

                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }

                tfoot td {
                    font-weight: bold;
                }

                .print-button {
                    background-color: #4CAF50;
                    color: white;
                    padding: 10px;
                    border: none;
                    cursor: pointer;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>ใบเสร็จหมายเลข <?php echo $receipt_data['receipt_id']; ?></h1>
                <div class="receipt-info">
                    <div class="left-info">
                        <p><b>เว็ปจำหน่ายอุปกรณ์คอมพิวเตอร์ออนไลน์</b></p>
                        <p><b>ชื่อผู้ซื้อ:</b> <?php echo $receipt_data['first_name']; ?> <?php echo $receipt_data['last_name']; ?></p>
                        <p><b>อีเมล: </b><?php echo $receipt_data['email']; ?></p>
                        <p><b>เบอร์: </b><?php echo $receipt_data['phone']; ?></p>
                        <p><b>ที่อยู่: </b><?php echo $receipt_data['address_line1'],'ต.', $receipt_data['Subdistrict'], 'อ.', $receipt_data['District'], 'จ.', $receipt_data['city'], $receipt_data['postal_code']; ?></p>
                    </div>
                    <div class="right-info">
                        <p>วันที่: <?php echo $receipt_data['timestamp']; ?></p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"class="text-center">ชื่อสินค้า</th>
                            <th scope="col"class="text-center">ราคาต่อหน่วย</th>
                            <th scope="col"class="text-center">จำนวน</th>
                            <th scope="col"class="text-center">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query ดึงข้อมูลสินค้าจากตาราง receipt_items
                        $items_query = "SELECT products.product_name, receipt_items.quantity, receipt_items.price_per_unit
                                        FROM receipt_items
                                        JOIN products ON receipt_items.product_id = products.product_id
                                        WHERE receipt_items.receipt_id = ?";
                        $stmt_items = mysqli_prepare($con, $items_query);

                        if (!$stmt_items) {
                            die("Error in items query preparation: " . mysqli_error($con));
                        }

                        mysqli_stmt_bind_param($stmt_items, "i", $receipt_id);
                        mysqli_stmt_execute($stmt_items);
                        $items_result = mysqli_stmt_get_result($stmt_items);

                        if (!$items_result) {
                            die("Error in items query execution: " . mysqli_error($con));
                        }

                        $total_amount = 0;
                        while ($item_data = mysqli_fetch_assoc($items_result)) {
                            $total = $item_data['price_per_unit'] * $item_data['quantity'];
                            $total_amount += $total;
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($item_data['product_name']) . "</td>";
                            echo "<td class=text-center>" . number_format($item_data['price_per_unit'], 2) . "</td>";
                            echo "<td class=text-center>" . htmlspecialchars($item_data['quantity']) . "</td>";
                            echo "<td class=text-center>" . number_format($total, 2) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot class='thead-dark'>
                        <tr>
                            <td colspan='3'>รวมทั้งหมด</td>
                            <td id='total-amount'>฿<?php echo number_format($total_amount, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Add the print button with Bootstrap style -->
                <button class="btn btn-success print-button" onclick="printReceipt()">ใบเสร็จ</button>

                <!-- Add the JavaScript function to handle printing -->
                <script>
                    function printReceipt() {
                        // Check if the page is being printed
                        if (window.matchMedia('print').matches) {
                            // Hide the print button when printing
                            document.querySelector('.print-button').style.display = 'none';
                            // Automatically close the window after printing
                            window.onafterprint = function () {
                                window.close();
                            };
                        } else {
                            // Show the print button for normal view
                            document.querySelector('.print-button').style.display = 'block';
                        }

                        window.print();
                    }
                </script>
            </div>
        </body>
        </html>
        <?php

        // Free result sets
        mysqli_stmt_close($stmt_items);
    } else {
        echo "Receipt not found.";
    }

    // Free result sets
    mysqli_stmt_close($stmt_receipt);
} else {
    echo "Invalid receipt ID.";
}

// Close database connection
mysqli_close($con);
?>
