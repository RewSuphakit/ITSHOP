<!-- products_by_category.php -->
<?php
// Start the session


// Include database connection
include("../connection/connect.php");
include '../menu/menu_user.php';

// Get category ID from the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

// Fetch products based on the selected category
$products_query = "SELECT products.*, categories.category_name 
                  FROM products
                  LEFT JOIN categories ON products.product_category_id = categories.category_id
                  WHERE products.product_category_id = $category_id";
$products_result = mysqli_query($con, $products_query);

?>

<h1>สินค้าในหมวดหมู่ที่เลือก</h1>

<?php
if ($products_result) {
    while ($product = mysqli_fetch_assoc($products_result)) {
        echo "<div>";
        echo "<h3>" . $product['product_name'] . "</h3>";
        echo "<p>ราคา: $" . $product['product_price'] . "</p>";
        echo "<p>คงเหลือ: " . $product['product_stock'] . " ชิ้น</p>";
        echo "<p>หมวดหมู่: " . $product['category_name'] . "</p>";
        echo "<a href='add_to_cart.php?product_id=" . $product['product_id'] . "'>เพิ่มลงในตะกร้า</a>";
        echo "</div>";
    }

    // Free result set
    mysqli_free_result($products_result);
} else {
    echo "Error: " . mysqli_error($con);
}
?>

<a href="categories.php">กลับสู่หน้าเลือกหมวดหมู่</a>

<?php
// Close database connection
mysqli_close($con);
?>
