<?php
include("../connection/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีการส่งค่า order_id มาหรือไม่
    if (isset($_POST["order_id"])) {
        $order_id = $_POST["order_id"];

        // ตรวจสอบว่าคำสั่งซื้อนี้มีอยู่จริงในฐานข้อมูลหรือไม่
        $check_order_query = "SELECT * FROM orders WHERE order_id = ?";
        if ($check_order_stmt = mysqli_prepare($con, $check_order_query)) {
            mysqli_stmt_bind_param($check_order_stmt, "i", $order_id);
            mysqli_stmt_execute($check_order_stmt);

            $check_order_result = mysqli_stmt_get_result($check_order_stmt);

            if ($check_order_result && mysqli_num_rows($check_order_result) > 0) {
                // อัปเดตสถานะเป็น 'ได้รับสินค้าแล้ว'
                $update_status_query = "UPDATE orders SET status = 'ได้รับสินค้าแล้ว' WHERE order_id = ?";
                if ($update_status_stmt = mysqli_prepare($con, $update_status_query)) {
                    mysqli_stmt_bind_param($update_status_stmt, "i", $order_id);
                    mysqli_stmt_execute($update_status_stmt);
                    
                    // สามารถเพิ่มโค้ดเพิ่มเติมได้ตามต้องการ เช่น การส่งอีเมลหรือการทำงานอื่น ๆ ที่ต้องการ
                    header("Location: order_history.php");
                    echo "สถานะถูกอัปเดตเป็น 'ได้รับสินค้าแล้ว' เรียบร้อยแล้ว";
                } else {
                    echo "Error in update query: " . mysqli_error($con);
                }
                
                mysqli_stmt_close($update_status_stmt);
            } else {
                echo "ไม่พบคำสั่งซื้อที่ตรงกับ order_id ที่ระบุ";
            }

            mysqli_free_result($check_order_result);
            mysqli_stmt_close($check_order_stmt);
        } else {
            echo "Error in check order query: " . mysqli_error($con);
        }
    } else {
        echo "ไม่ได้รับ order_id จากฟอร์ม";
    }
}

mysqli_close($con);
?>
