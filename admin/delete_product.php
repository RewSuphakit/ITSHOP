<?php
// Include necessary files and establish database connection
include '../connection/connect.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] || $_SESSION['level'] !== 'A') {
    echo "Access denied. You must be an admin to perform this action.";
    exit();
}

// Check if the product_id parameter is set
if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['product_id']);

    // Fetch the product details, including the image file name
    $select_query = "SELECT product_img FROM products WHERE product_id = '$product_id'";
    $select_result = mysqli_query($con, $select_query);

    if ($select_result) {
        $product_data = mysqli_fetch_assoc($select_result);

        // Perform the delete operation
        $delete_query = "DELETE FROM products WHERE product_id = '$product_id'";
        $delete_result = mysqli_query($con, $delete_query);

        if ($delete_result) {
            // Delete the associated image file
            $image_path = "../product_image/" . $product_data['product_img'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            header('Location: manage_products.php');
        } else {
            echo "Error in delete operation: " . mysqli_error($con);
        }
    } else {
        echo "Error in fetching product details: " . mysqli_error($con);
    }
} else {
    echo "Product ID not provided.";
}

// Close the database connection
mysqli_close($con);
?>
