<?php
// Include database connection
include("../menu/menu_admin.php");

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] || $_SESSION['level'] !== 'A') {
    echo "ปฏิเสธการเข้าใช้. คุณต้องเป็นผู้ดูแลระบบจึงจะสามารถดูหน้านี้ได้.";
    exit();
}

// Handle form submission to add a new product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $product_name = mysqli_real_escape_string($con, $_POST['product_name']);
    $product_brand = mysqli_real_escape_string($con, $_POST['product_brand']);
    $product_description = mysqli_real_escape_string($con, $_POST['product_description']);
    $product_stock = isset($_POST['product_stock']) ? intval($_POST['product_stock']) : 0;
    $product_price = isset($_POST['product_price']) ? floatval($_POST['product_price']) : 0.0;
    $product_category_id = isset($_POST['product_category_id']) ? $_POST['product_category_id'] : null;

    // Check if an image is uploaded via URL
    if (isset($_POST['product_image_url']) && !empty($_POST['product_image_url'])) {
        $product_image_url = $_POST['product_image_url'];

        // Download the image from the URL
        $target_dir = "../product_image/";
        $target_file = $target_dir . basename($product_image_url);
        file_put_contents($target_file, file_get_contents($product_image_url));

        // Compress the downloaded image
        compressImage($target_file);
    } elseif (isset($_FILES["product_image"]["name"]) && !empty($_FILES["product_image"]["name"])) {
        // Check if an image is uploaded via file input
        $target_dir = "../product_image/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);

        // Check for upload errors
        if ($_FILES["product_image"]["error"] === UPLOAD_ERR_OK) {
            // Check if the file is an image
            if (getimagesize($_FILES["product_image"]["tmp_name"]) !== false) {
                // Check for duplicates
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                // Generate a unique filename to avoid overwriting existing files
                $unique_filename = generateUniqueFilename($target_dir, $_FILES["product_image"]["name"]);
                $target_file = $target_dir . $unique_filename;

                // Upload and compress image
                move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file);
                compressImage($target_file);
            } else {
                echo "Invalid image file.";
                exit();
            }
        } else {
            echo "File upload error: " . $_FILES["product_image"]["error"];
            exit();
        }
    } else {
        echo "Product image is required.";
        exit();
    }

    // Check if category_id is provided
    if ($product_category_id !== null) {
        // Escape and use the value in the query
        $product_category_id = mysqli_real_escape_string($con, $product_category_id);

        // Use form data to add a product
        $insert_query = "INSERT INTO products (product_img, product_name, product_brand, product_description, product_stock, product_price, product_category_id) 
                         VALUES ('$target_file', '$product_name', '$product_brand', '$product_description', $product_stock, $product_price, $product_category_id)";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            echo "Product added successfully.";
        } else {
            echo "Error adding product: " . mysqli_error($con);
        }
    } else {
        echo "Product category is required.";
    }
}

// Close database connection
mysqli_close($con);

// Function to compress image (adjust quality as needed)
function compressImage($source)
{
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
        imagejpeg($image, $source, 75); // Adjust the quality (0-100) as needed
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
        imagepng($image, $source, 5); // Adjust the compression level (0-9) as needed
    }
}

// Function to generate a unique filename to avoid overwriting existing files
function generateUniqueFilename($target_dir, $filename)
{
    $unique_filename = $filename;
    $counter = 1;

    while (file_exists($target_dir . $unique_filename)) {
        $info = pathinfo($filename);
        $unique_filename = $info['filename'] . '_' . $counter . '.' . $info['extension'];
        $counter++;
    }

    return $unique_filename;
}
?>

<!-- HTML form as a bordered card with highlighted file input and image preview -->
<div class="max-w-md mx-auto my-8">
    <div class="border border-gray-300 bg-white rounded-md overflow-hidden shadow-md p-6">
        <h1 class="text-3xl font-semibold mb-6">เพิ่มสินค้า</h1>
        <form method="post" action="" enctype="multipart/form-data" class="space-y-4">
            <label for="product_name" class="block">ชื่อสินค้า:</label>
            <input type="text"  autocomplete="off"  name="product_name" required id="product_name" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500">

            <label for="product_image_url" class="block text-sm font-medium text-gray-700"> Product Image URL:</label>
            <input type="text"  autocomplete="off"  name="product_image_url" class="block w-full border p-2 rounded-md">

            <label for="product_image" class="block relative mt-4">
                <span class="block text-sm text-gray-500">อัปโหลดรูปภาพ:</span>
                <div class="flex items-center mt-1">
                    <label for="product_image_url" class="cursor-pointer bg-blue-500 text-white rounded-md py-2 px-4 transition duration-300 hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300">
                        <i class="fas fa-upload mr-2"></i> เลือกรูป
                    </label>
                    <input id="product_image_url" type="file" name="product_image" accept="image/*"  class="hidden focus:border-blue-500" onchange="previewImage(this)">
                </div>
            </label>

            <!-- Image preview -->
            <div id="imagePreview" class="mt-4"></div>

            <label for="product_brand" class="block">ยี่ห้อ:</label>
            <input type="text"  autocomplete="off"  name="product_brand" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500">

            <label for="product_description" class="block">รายละเอียด:</label>
            <textarea name="product_description" rows="4" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500"></textarea>

            <label for="product_category_id" class="block">หมวดหมู่:</label>
            <select name="product_category_id" id="product_category_id" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500">
                <option value="1">RAM</option>
                <option value="2">Mouse</option>
                <option value="3">Keyboard</option>
                <option value="4">Monitor</option>
                <option value="5">CPU</option>
                <option value="6">GPU</option>
                <option value="7">Mainboard</option>
                <option value="8">PowerSupply</option>
            </select>

            <label for="product_stock" class="block">จำนวนสินค้าในสต็อก:</label>
            <input type="number" name="product_stock" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500">

            <label for="product_price" class="block">ราคา:</label>
            <input type="number" name="product_price" step="0.01" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-blue-500">

            <button type="submit" class="w-full bg-blue-500 text-white rounded-md py-2 transition duration-300 hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300">เพิ่มสินค้า</button>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = '';

        const file = input.files[0];

        if (file) {
            const imageUrl = URL.createObjectURL(file);
            const img = document.createElement('img');
            img.src = imageUrl;
            img.classList.add('w-full', 'mt-2', 'rounded-md');
            imagePreview.appendChild(img);
        }
    }
</script>





