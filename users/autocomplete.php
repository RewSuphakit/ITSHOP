<?php
include('../connection/connect.php');

if (isset($_POST['query'])) {
    $search_query = $_POST['query'];

    $autocomplete_query = "SELECT product_name, product_id FROM products WHERE product_name LIKE '%$search_query%' LIMIT 5";
    $autocomplete_result = mysqli_query($con, $autocomplete_query);

    if ($autocomplete_result) {
        echo '<ul class="list-group z-1 position-absolute ">';
        while ($row = mysqli_fetch_assoc($autocomplete_result)) {
            $product_id = $row['product_id'];
            echo '<a href="product_detail.php?product_id=' . $product_id . '" class="list-group-item list-group-item-action  ">' . $row['product_name'] . '</a>';
        }
        echo '</ul>';
    } else {
        echo 'Error: ' . mysqli_error($con);
    }
}

mysqli_close($con);
?>
