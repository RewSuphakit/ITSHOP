<!-- checkout.php -->
<script src="sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
// Include database connection
include("../connection/connect.php");

echo "<h1>ชำระสินค้า</h1>";
$name = $_SESSION['first_name'] . " " . $_SESSION['last_name'];

// Check if the user has a valid address before proceeding to checkout
$user_id = $_SESSION['user_id'];
$address_query = "SELECT * FROM addresses WHERE user_id = $user_id";
$address_result = mysqli_query($con, $address_query);

if ($address_result) {
    if (mysqli_num_rows($address_result) > 0) {
        // User has at least one address, proceed to checkout
    } else {
        // Display an alert if the user has no address
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'ที่อยู่ที่ไม่ถูกต้อง',
                text: 'โปรดเพิ่มที่อยู่ในโปรไฟล์ของคุณก่อนดำเนินการชำระเงิน',
                allowOutsideClick:false,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'profile.php'; // เปลี่ยนเส้นทางไปยังหน้าโปรไฟล์
            });
        </script>";
        exit();
    }

    // Free result set
    mysqli_free_result($address_result);
} else {
    echo "Error querying user's address: " . mysqli_error($con);
    exit();
}

// ตรวจสอบว่ารถเข็นไม่ว่างเปล่า
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    // Assume the user is logged in (you may need to implement user authentication)
    $user_id = $_SESSION['user_id'];

    // Fetch user's current money from the database
    $user_query = "SELECT money FROM users WHERE user_id = $user_id";
    $user_result = mysqli_query($con, $user_query);

    if ($user_result) {
        if (mysqli_num_rows($user_result) > 0) {
            $user_data = mysqli_fetch_assoc($user_result);
            $user_money = $user_data['money'];

            // Calculate the total amount to be paid
            $total_amount = 0;

            // ตรวจสอบว่าผู้ใช้มีเงินเพียงพอที่จะชำระเงินหรือไม่
            foreach ($_SESSION['cart'] as $cart_item) {
                $product_id = $cart_item['product_id'];
                $quantity_in_cart = $cart_item['quantity'];

                // Fetch current stock from the database
                $stock_query = "SELECT product_stock, product_name, product_price FROM products WHERE product_id = $product_id";
                $stock_result = mysqli_query($con, $stock_query);

                if ($stock_result) {
                    $stock_data = mysqli_fetch_assoc($stock_result);
                    $current_stock = $stock_data['product_stock'];
                    $product_name = $stock_data['product_name'];
                    $product_price = $stock_data['product_price'];

                    // ตรวจสอบว่าสต็อกปัจจุบันเพียงพอหรือไม่
                    if ($current_stock < $quantity_in_cart) {
                        // Insufficient stock, show alert and exit
                        echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'สินค้าในสต็อกไม่เพียงพอ',
                                text: 'ไม่พอสำหรับการซื้อ $product_name',
                                allowOutsideClick:false,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = 'product.php';
                            });
                        </script>";
                        exit();
                    }

                    $subtotal = $quantity_in_cart * $product_price;
                    $total_amount += $subtotal;
                } else {
                    echo "Error fetching stock: " . mysqli_error($con);
                    exit();
                }
            }
            // ตรวจสอบว่าผู้ใช้มีเงินเพียงพอที่จะชำระเงินหรือไม่
            // Check if the user has enough money to make the payment
            if ($user_money >= $total_amount) {

                foreach ($_SESSION['cart'] as $cart_item) {
                    $product_id = $cart_item['product_id'];
                    $quantity_in_cart = $cart_item['quantity'];

                    // Fetch current stock from the database
                    $stock_query = "SELECT product_stock FROM products WHERE product_id = $product_id";
                    $stock_result = mysqli_query($con, $stock_query);

                    if ($stock_result) {
                        $stock_data = mysqli_fetch_assoc($stock_result);
                        $current_stock = $stock_data['product_stock'];
                        // ตรวจสอบว่าสต็อกปัจจุบันเพียงพอหรือไม่
                        // Check if the current stock is sufficient
                        if ($current_stock < $quantity_in_cart) {
                            // Insufficient stock, show alert and exit
                            echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'สินค้าในสต็อกไม่เพียงพอ',
                            text: 'ไม่พอสำหรับการซื้อ {$cart_item['product_name']}',
                            allowOutsideClick:false,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = 'product.php';
                        });
                      </script>";
                            exit();
                        }
                    } else {
                        echo "Error fetching stock: " . mysqli_error($con);
                        exit();
                    }
                }



                // หักจำนวนเงินทั้งหมดจากเงินของผู้ใช้
                $new_user_money = $user_money - $total_amount;

                // Update the user's money in the database
                $update_user_query = "UPDATE users SET money = $new_user_money WHERE user_id = $user_id";
                $update_user_result = mysqli_query($con, $update_user_query);

                if ($update_user_result) {

                    // Create a new order record
                    $insert_order_query = "INSERT INTO orders (user_id, total_amount, status) VALUES ($user_id, $total_amount, 'รอดำเนินการ')";
                    $insert_order_result = mysqli_query($con, $insert_order_query);

                    // Check if the order was created successfully
                    if ($insert_order_result) {
                        // Get the order ID
                        $order_id = mysqli_insert_id($con);

                        // Update product stock and insert items into order_details
                        foreach ($_SESSION['cart'] as $cart_item) {
                            $product_id = $cart_item['product_id'];
                            $quantity = $cart_item['quantity'];
                            $subtotal = $cart_item['quantity'] * $cart_item['product_price'];

                            // Update product stock in the database
                            $update_stock_query = "UPDATE products SET product_stock = product_stock - $quantity WHERE product_id = $product_id";
                            $update_stock_result = mysqli_query($con, $update_stock_query);

                            if (!$update_stock_result) {
                                echo "Error updating product stock: " . mysqli_error($con);
                                exit(); // Handle error and exit
                            }

                            // Insert items into order_details
                            $insert_order_detail_query = "INSERT INTO order_details (order_id, product_id, quantity, subtotal) VALUES ($order_id, $product_id, $quantity, $subtotal)";
                            $insert_order_detail_result = mysqli_query($con, $insert_order_detail_query);

                            if (!$insert_order_detail_result) {
                                echo "Error inserting item into order_details: " . mysqli_error($con);
                                exit(); // Handle error and exit
                            }
                        }

                        // Create a receipt record
                        $insert_receipt_query = "INSERT INTO receipts (user_id, total_amount) VALUES ($user_id, $total_amount)";
                        $insert_receipt_result = mysqli_query($con, $insert_receipt_query);

                        // Check if the receipt was created successfully
                        if ($insert_receipt_result) {
                            // Get the receipt ID
                            $receipt_id = mysqli_insert_id($con);

                            // Insert items into receipt_items
                            foreach ($_SESSION['cart'] as $cart_item) {
                                $product_id = $cart_item['product_id'];
                                $quantity = $cart_item['quantity'];

                                // Insert items into receipt_items
                                $insert_item_query = "INSERT INTO receipt_items (receipt_id, product_id, quantity, price_per_unit) VALUES ($receipt_id, $product_id, $quantity, {$cart_item['product_price']})";
                                $insert_item_result = mysqli_query($con, $insert_item_query);

                                if (!$insert_item_result) {
                                    echo "Error inserting item into receipt_items: " . mysqli_error($con);
                                    exit(); // Handle error and exit
                                }
                            }

                            // ... ส่วนที่เกี่ยวกับ Line Notify ควรถูกต้อง
                            $sToken = "eiEVby0Ng1bzNBQOVdpZ65ZjS7Pqb1aEJQLg3AKTC9k";
                            $sMessage = "มีรายการสั่งซื้อเข้ามา....\n";
                            $sMessage .= "ชื่อผู้ซื้อ:$name\n";
                            $sMessage .= "ราคารวม:" . number_format($total_amount) . "บาท\n";

                            foreach ($_SESSION['cart'] as $cart_item) {
                                $product_name = $cart_item['product_name'];
                                $product_price = $cart_item['product_price'];
                                $quantity = $cart_item['quantity'];

                                $sMessage .= "ชื่อสินค้า:$product_name\n";
                                $sMessage .= "ราคา:" . number_format($product_price) . "บาท\n";
                                $sMessage .= "จำนวน:" . number_format($quantity) . "ชิ้น\n";
                            }

                            // ... ส่วนที่เกี่ยวกับการส่ง Line Notify ควรถูกต้อง
                            $chOne = curl_init();
                            curl_setopt($chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                            curl_setopt($chOne, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($chOne, CURLOPT_SSL_VERIFYPEER, 0);
                            curl_setopt($chOne, CURLOPT_POST, 1);
                            curl_setopt($chOne, CURLOPT_POSTFIELDS, "message=" . $sMessage);
                            $headers = array('Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $sToken . '',);
                            curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($chOne, CURLOPT_RETURNTRANSFER, 1);
                            $result = curl_exec($chOne);

                            //Result error 
                            if (curl_error($chOne)) {
                                echo 'error:' . curl_error($chOne);
                            } else {
                                $result_ = json_decode($result, true);
                                echo "status : " . $result_['status'];
                                echo "message : " . $result_['message'];
                            }
                            curl_close($chOne);

                            // ... (รายละเอียดโค้ดเหมือนเดิม)
                            // Clear the cart after successful payment
                            unset($_SESSION['cart']);

                            // Show success message using sweetalert2
                            echo "<script>
                 Swal.fire({
                     icon: 'success',
                     title: 'Payment successful!',
                     text: 'สร้างใบเสร็จ.',
                     allowOutsideClick:false,
                     confirmButtonText: 'OK'
                 }).then(() => {
                     window.location.href = 'product.php';
                 });
               </script>";
                        } else {
                            echo "Error creating receipt: " . mysqli_error($con);
                        }
                    } else {
                        echo "Error creating order: " . mysqli_error($con);
                    }
                } else {
                    echo "Error updating user's money: " . mysqli_error($con);
                }
            } else {
                echo "Not enough money to make the payment.";
                echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Not Enough Money',
                        text: 'จำนวนเงินไม่เพียงพอสำหรับการชำระสินค้า',
                        allowOutsideClick:false,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'product.php';
                    });
                </script>";
            }
        } else {
            echo "User not found.";
        }

        // Free result set
        mysqli_free_result($user_result);
    } else {
        echo "Error querying user data: " . mysqli_error($con);
    }
} else {
    header('Location: product.php');
    exit();
}

// Close database connection
mysqli_close($con);
?>