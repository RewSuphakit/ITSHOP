<?php
// update_cart.php

session_start();

if (isset($_GET['index']) && isset($_GET['quantity'])) {
    $index = $_GET['index'];
    $quantity = $_GET['quantity'];

    // อัปเดตจำนวนในเซสชัน
    $_SESSION['cart'][$index]['quantity'] = $quantity;

    // นำทางกลับไปยังหน้าตะกร้า
    header("Location: cart.php");
    exit();
}
?>
