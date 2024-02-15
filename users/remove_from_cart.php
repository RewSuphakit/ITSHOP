<!-- remove_from_cart.php -->
<?php
include ('../connection/connect.php'); // Start the session
if (isset($_GET['index'])) {
    $index = $_GET['index'];

    if (isset($_SESSION['cart'][$index])) {
        // Remove the product from the cart
        $product_id = $_SESSION['cart'][$index]['product_id'];
        unset($_SESSION['cart'][$index]);

        // Reorder array keys
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    } else {
        echo "Invalid index.";
    }
} else {
    echo "Invalid request.";
}

// Close database connection


// Redirect back to shopping_cart.php
header('Location: cart.php');
exit();
?>
