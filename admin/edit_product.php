<?php
// Include necessary files and establish database connection
include("../menu/menu_admin.php");

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] || $_SESSION['level'] !== 'A') {
    echo "Access denied. You must be an admin to perform this action.";
    exit();
}

// Check if the product_id parameter is set
if (isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['product_id']);

    // Fetch the product details from the database
    $select_query = "SELECT product_id, product_img, product_name, product_brand, product_description, product_stock, product_price FROM products WHERE product_id = '$product_id'";
    $select_result = mysqli_query($con, $select_query);

    if ($select_result) {
        $product_data = mysqli_fetch_assoc($select_result);
    } else {
        echo "Error in fetching product details: " . mysqli_error($con);
        exit();
    }
} else {
    echo "Product ID not provided.";
    exit();
}

// Check if the form is submitted for updating product details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $updated_product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $updated_product_brand = mysqli_real_escape_string($con, $_POST['product_brand']);
    $updated_product_description = mysqli_real_escape_string($con, $_POST['product_description']);
    $updated_product_stock = mysqli_real_escape_string($con, $_POST['product_stock']);
    $updated_product_price = mysqli_real_escape_string($con, $_POST['product_price']);

    // Check if there is an old image
    $old_image_path = "../product_image/" . $product_data['product_img'];

    // Check if the product name is changed
    if ($updated_product_name !== $product_data['product_name']) {
        // Product name is changed, update without changing the image
        $update_query = "UPDATE products SET 
            product_name = '$updated_product_name',
            product_brand = '$updated_product_brand',
            product_description = '$updated_product_description',
            product_stock = '$updated_product_stock',
            product_price = '$updated_product_price'
            WHERE product_id = '$product_id'";
    } else {
        // Product name is not changed
        // Handle file upload
        if (!empty($_POST['new_product_img_url'])) {
            // Handle file upload from URL
            $image_url = $_POST['new_product_img_url'];
            $image_extension = pathinfo($image_url, PATHINFO_EXTENSION);
            $target_file = "../product_image/" . uniqid('product_img_') . "." . $image_extension;

            if (copy($image_url, $target_file)) {
                compressImage($target_file, 75);

                // Delete the old image
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            } else {
                echo "Error downloading and saving image from URL.";
                exit();
            }

            // Update query when a new image is uploaded
            $update_query = "UPDATE products SET 
                product_name = '$updated_product_name',
                product_brand = '$updated_product_brand',
                product_description = '$updated_product_description',
                product_stock = '$updated_product_stock',
                product_price = '$updated_product_price',
                product_img = '" . basename($target_file) . "'
                WHERE product_id = '$product_id'";
        } elseif (isset($_FILES['new_product_img']) && $_FILES['new_product_img']['error'] === 0) {
            // Handle file upload from local file
            $target_dir = "../product_image/";
            $target_file = $target_dir . basename($_FILES["new_product_img"]["name"]);
            move_uploaded_file($_FILES["new_product_img"]["tmp_name"], $target_file);
            compressImage($target_file, 75);

            // Delete the old image
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }

            // Update query when a new image is uploaded
            $update_query = "UPDATE products SET 
                product_name = '$updated_product_name',
                product_brand = '$updated_product_brand',
                product_description = '$updated_product_description',
                product_stock = '$updated_product_stock',
                product_price = '$updated_product_price',
                product_img = '" . basename($target_file) . "'
                WHERE product_id = '$product_id'";
        } else {
            // No new image uploaded
            // Update the product details in the database without changing the image path
            $update_query = "UPDATE products SET 
                product_name = '$updated_product_name',
                product_brand = '$updated_product_brand',
                product_description = '$updated_product_description',
                product_stock = '$updated_product_stock',
                product_price = '$updated_product_price'
                WHERE product_id = '$product_id'";
        }
    }

    $update_result = mysqli_query($con, $update_query);

    if ($update_result) {
        echo "<script>
            Swal.fire({
                title: 'success',
                text: 'Product details updated successfully!',
                icon: 'success',
                timer: 5000,
                showConfirmButton: false
            });
        </script>";
        header("refresh:2; url=manage_products.php");
    } else {
        echo "Error in updating product details: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);

// Function to compress image
function compressImage($source, $quality) {
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    }

    imagejpeg($image, $source, $quality);

    return $source;
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Add your CSS links here -->
</head>

<body>
    <!-- Your HTML form for editing product details -->
    <div class="mx-auto w-full max-w-md p-8 bg-white border rounded shadow-md">
        <?php
        if (isset($product_data['product_img'])) {
            echo '<img src="../product_image/' . $product_data['product_img'] . '" class="mx-auto mb-4" alt="Product Image" style="width: 250px; height: 250px; object-fit: cover; border-radius: 8px;">';
        } else {
            echo 'Product Image Not Available';
        }
        ?>

        <form method="POST" action="" class="space-y-4" enctype="multipart/form-data">
            <label for="new_product_img_url" class="block text-sm font-medium text-gray-700">New Product Image URL:</label>
            <input type="text"  autocomplete="off" name="new_product_img_url" class="block w-full border p-2 rounded-md">

            <label for="new_product_img" class="block text-sm font-medium text-gray-700">New Product Image (or upload from URL):</label>
            <input type="file" name="new_product_img" accept="image/*" class="block w-full border p-2 rounded-md">

            <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name:</label>
            <input type="text" name="product_name" value="<?= $product_data['product_name']; ?>" required class="block w-full border p-2 rounded-md">

            <label for="product_brand" class="block text-sm font-medium text-gray-700">Product Brand:</label>
            <input type="text" name="product_brand" value="<?= $product_data['product_brand']; ?>" required class="block w-full border p-2 rounded-md">

            <label for="product_description" class="block text-sm font-medium text-gray-700">Product Description:</label>
            <textarea name="product_description" required class="block w-full border p-2 rounded-md"><?= $product_data['product_description']; ?></textarea>

            <label for="product_stock" class="block text-sm font-medium text-gray-700">Product Stock:</label>
            <input type="number" name="product_stock" value="<?= $product_data['product_stock']; ?>" required class="block w-full border p-2 rounded-md">

            <label for="product_price" class="block text-sm font-medium text-gray-700">Product Price:</label>
            <input type="text" name="product_price" value="<?= $product_data['product_price']; ?>" required class="block w-full border p-2 rounded-md">

            <button type="submit" class="block w-full p-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300">
                Update Product
            </button>
        </form>
    </div>

    <!-- Add your additional HTML content or include necessary scripts -->
</body>

</html>
