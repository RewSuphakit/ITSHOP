<!-- categories.php -->
<?php
// Start the session


// Include database connection
include("../connection/connect.php");
include '../menu/menu_user.php';

// Fetch all categories from the database
$categories_query = "SELECT * FROM categories";
$categories_result = mysqli_query($con, $categories_query);

?>

<h1>เลือกหมวดหมู่สินค้า</h1>

<ul>
    <?php
    if ($categories_result) {
        while ($category = mysqli_fetch_assoc($categories_result)) {
            echo "<li><a href='products_by_category.php?category_id=" . $category['category_id'] . "'>" . $category['category_name'] . "</a></li>";
        }

        // Free result set
        mysqli_free_result($categories_result);
    } else {
        echo "Error: " . mysqli_error($con);
    }
    ?>
</ul>

<a href="index.php">กลับสู่หน้าหลัก</a>

<?php
// Close database connection
mysqli_close($con);
?>
