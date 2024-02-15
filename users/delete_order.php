<?php
// Include the connection file
include("../connection/connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the order_id is set in the POST data
    if (isset($_POST['order_id'])) {
        // Sanitize and get the order_id
        $order_id = mysqli_real_escape_string($con, $_POST['order_id']);

        // Query to delete the order details first
        $delete_order_details_query = "DELETE FROM order_details WHERE order_id = ?";

        if ($delete_order_details_stmt = mysqli_prepare($con, $delete_order_details_query)) {
            mysqli_stmt_bind_param($delete_order_details_stmt, "i", $order_id);

            if (mysqli_stmt_execute($delete_order_details_stmt)) {
                // Now, prepare and delete the order
                $delete_order_query = "DELETE FROM orders WHERE order_id = ?";

                if ($delete_order_stmt = mysqli_prepare($con, $delete_order_query)) {
                    mysqli_stmt_bind_param($delete_order_stmt, "i", $order_id);

                    if (mysqli_stmt_execute($delete_order_stmt)) {
                        header('Location: order_history.php');
                        echo "Order and related details deleted successfully.";
                    } else {
                        echo "Error deleting order: " . mysqli_error($con);
                    }

                    mysqli_stmt_close($delete_order_stmt);
                } else {
                    echo "Error in delete order query preparation: " . mysqli_error($con);
                }
            } else {
                echo "Error deleting order details: " . mysqli_error($con);
            }

            mysqli_stmt_close($delete_order_details_stmt);
        } else {
            echo "Error in delete order details query preparation: " . mysqli_error($con);
        }
    }
}

// Close the database connection
mysqli_close($con);
?>
