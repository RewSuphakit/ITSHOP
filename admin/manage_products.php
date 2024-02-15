<?php
// Your existing PHP code for including menu_admin.php and checking admin session
include("../menu/menu_admin.php");

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] || $_SESSION['level'] !== 'A') {
    echo "ปฏิเสธการเข้าใช้. คุณต้องเป็นผู้ดูแลระบบจึงจะสามารถดูหน้านี้ได้.";
    exit();
}

// Number of items per page
$itemsPerPage = 4;

// Current page (default to 1 if not set)
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Your existing PHP code for fetching products from the database with pagination
$offset = ($current_page - 1) * $itemsPerPage;
$product_query = "SELECT products.*, categories.category_name
FROM products 
JOIN categories ON categories.category_id = products.product_category_id 
";

// Check if a search query is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $product_query .= " WHERE 
        product_name LIKE '%$search%' OR 
        product_brand LIKE '%$search%' OR 
        product_description LIKE '%$search%' OR 
        categories.category_name LIKE '%$search%'";
}

// Check if a product ID is provided for specific filtering
if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['product_id']);
    $product_query .= " WHERE products.product_id = '$product_id'";
}

// Add sorting functionality
$sort_column = isset($_GET['sort']) ? mysqli_real_escape_string($con, $_GET['sort']) : 'product_name';
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';
$product_query .= " ORDER BY $sort_column $sort_order";

// Add pagination
$product_query .= " LIMIT $itemsPerPage OFFSET $offset";

$product_result = mysqli_query($con, $product_query);

if (!$product_result) {
    echo "Error in query: " . mysqli_error($con);
    exit();
}
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-lY6+8CO+rXmKpzpfC3Ll9g6ZzLbwo8NTbPD1eYDJENhJlIiK/2h5K87P8LwWpMJp" crossorigin="anonymous">

<div class="mx-auto w-full max-w-screen-xl">
    <h1 class="text-3xl font-bold mb-5">Manage Products</h1>
    <div class="flex flex-col md:flex-row justify-between items-center mb-5">
    <a href='add_product.php' class='flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 md:mb-0 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800'>
        <i class="fas fa-plus-circle mr-2"></i> Add Product
    </a>

    <div class="flex items-center mt-2 md:mt-0">
        <form method="GET" action="" class="flex items-center">
            <input type="text"  autocomplete="off"  name="search" placeholder="ค้นหาชื่อสินค้าหรือแบรนด์" class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:border-blue-500">
            <button type="submit" class="ml-2 flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class="fas fa-search mr-2"></i> Search
            </button>
        </form>
    </div>
</div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3"><a href="?sort=product_id&order=<?php echo $sort_column === 'product_id' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product ID</a></th>
                    <th scope="col" class="px-6 py-3"><a href="?sort=product_img&order=<?php echo $sort_column === 'product_img' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product IMG</a></th>
                    <th scope="col" class="px-6 py-3"><a href="?sort=product_name&order=<?php echo $sort_column === 'product_name' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Name</a></th>
                    <th scope="col" class="px-6 py-3"><a href="?sort=product_brand&order=<?php echo $sort_column === 'product_brand' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Brand</a></th>
                    <th scope="col" class="px-6 py-3"><a href="?sort=product_description&order=<?php echo $sort_column === 'product_description' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Description</a></th>
                    <th scope="col" class="px-6 py-3"><a href="?sort=category_name&order=<?php echo $sort_column === 'category_name' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Category</a></th>
                    <th scope="col" class="px-6 py-3"><a href="?sort=product_stock&order=<?php echo $sort_column === 'product_stock' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Stock</a></th>
                    <th scope="col" class="px-6 py-3"><a href="?sort=product_price&order=<?php echo $sort_column === 'product_price' ? ($sort_order === 'ASC' ? 'desc' : 'asc') : 'asc'; ?>">Product Price</a></th>
                    <th scope="col" class="px-6 py-3">Edit</th>
                    <th scope="col" class="px-6 py-3">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($product_data = mysqli_fetch_assoc($product_result)) {
                ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="border px-9 py-4"><?= $product_data['product_id']; ?></td>
                        <td class="border px-9 py-4"> <img src='../product_image/<?php echo $product_data['product_img']; ?>' class="mx-auto" alt="Product Image" style="width:50px; height:50px;"></td>
                        <td class="border px-9 py-4"><?= $product_data['product_name']; ?></td>
                        <td class="border px-9 py-4"><?= $product_data['product_brand']; ?></td>
                        <td class="border px-9 py-4"><?= $product_data['product_description']; ?></td>
                        <td class="border px-9 py-4"><?= $product_data['category_name']; ?></td>
                        <td class="border px-9 py-4">   
                        <?php  if ($product_data["product_stock"] == 0) {
                        echo '<span style="color:red;">สินค้าหมด</span>';
                      } else {
                        echo $product_data["product_stock"];
                      } ?>
                    
                    </td>
                        <td class="border px-9 py-4"><?= $product_data['product_price']; ?></td>
                        <td class="border px-9 py-4">
                            <a href='edit_product.php?product_id=<?= $product_data['product_id']; ?>' class='focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900'><i class="fas fa-edit"></i></a>
                        </td>
                        <td class="border px-9 py-4">
                            <a href='delete_product.php?product_id=<?= $product_data['product_id']; ?>' class='focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900'><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add Pagination Links -->
    <div class="mt-4">
        <?php
        // Calculate total number of pages
        $total_pages_query = "SELECT COUNT(*) as total FROM products";
        $result = mysqli_query($con, $total_pages_query);
        $total_items = mysqli_fetch_assoc($result)['total'];
        $total_pages = ceil($total_items / $itemsPerPage);

        // Display pagination links
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='?page=$i' class='mx-2 px-4 py-2 bg-blue-500 text-white rounded'>$i</a>";
        }
        ?>
    </div>
</div>
<br>
<?php
// Your existing PHP code for freeing result set and closing database connection
mysqli_free_result($product_result);
mysqli_close($con);
?>

