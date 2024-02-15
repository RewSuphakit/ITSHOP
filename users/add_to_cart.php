<?php

// Include database connection
include("../connection/connect.php");

if (!isset($_SESSION['cart'])) {
    // If cart is not set, initialize it as an empty array
    $_SESSION['cart'] = [];
}

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    // Fetch product details from the database
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Check if product is already in the cart
        $index = array_search($product_id, array_column($_SESSION['cart'], 'product_id'));

        if ($index !== false) {
            // Product is already in the cart, increase the quantity
            $_SESSION['cart'][$index]['quantity'] += $quantity;
        } else {
            // Product is not in the cart, add it
            $cart_item = [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'product_price' => $product['product_price'],
                'quantity' => $quantity,
                'product_img' => $product['product_img'] 
            ];

            $_SESSION['cart'][] = $cart_item;
        }

        // Redirect back to cart.php or product_detail.php
        $referer = $_SERVER['HTTP_REFERER'];
        header("Location: $referer");
        exit();
    } else {
        echo "Product not found.";
    }

    // Free result set
    mysqli_free_result($result);
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($con);
?>
