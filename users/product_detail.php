<!-- product_detail.php -->

<?php
// Start the session

// Include database connection
include '../menu/menu_user.php';

// Function to escape user inputs for security
function escape($con, $value) {
    return mysqli_real_escape_string($con, $value);
}

// Check if product_id is provided in the URL
if (isset($_GET['product_id'])) {
    $product_id = escape($con, $_GET['product_id']);

    // Fetch product details from the database using Prepared Statements
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>
    <style>
        /* เพิ่มส่วนนี้ใน CSS */
@media only screen and (max-width: 600px) {
    .box {
        flex-direction: column;
    }

    .product-img {
        max-width: 100%;
        margin-right: 0;
        border-radius: 8px 8px 0 0;
    }

    .product-info {
        padding-top: 10px;
        padding-bottom: 20px;
    }

    .product-name {
        font-size: 24px;
    }

    .product-description {
        font-size: 16px;
    }

    .product-price {
        font-size: 20px;
    }

    .product-stock {
        font-size: 16px;
    }

    .date-up {
        font-size: 14px;
    }

    .btn {
        font-size: 16px;
        padding: 8px 16px;
    }
}

   

.box {
    max-width: 1000px;
    margin: 50px auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 20px ;
    display: flex;
}

.product-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px 0 0 8px;
    margin-right: 20px;
    
}

.product-info {
    flex-grow: 1;
    font-size: 15px;
    color: #888;
    padding-top: 20px;
    
}

.product-name {
    font-size: 20px;
    font-weight: bold;
    color: #1e1e1e;
    margin-bottom: 10px;
    padding-top: 10px;
   
}   
 .product-brand {
    font-size: 16px;
    color: #888;
    
}
.product-description {
    font-size: 18px;
    color: #555;
    margin-bottom: 20px;
   
}

.product-price {
    font-size: 24px;
    color: #e44d26;
    margin-bottom: 10px;
}

.product-stock {
    font-size: 18px;
    color: #1e1e1e;
    margin-bottom: 20px;
}

.date-up {
    font-size: 15px;
    color: #888;
    display: inline-flex;

   
}



.button-group-cart {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 15px;
    background-color: #fff;
    box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
}


/* เพิ่มส่วนนี้ใน CSS */
.quantity {
    display: flex;
    align-items: center;
    margin-top: 10px;

}



.quantity-input {
    width: 50px;
    text-align: center;
    font-size: 16px;
    margin: 0 10px;
    border-radius: 5px;
}

    </style>
</head>
<body>

    <div class="box container">
        <div class="product-img">
            <img src='../product_image/<?php echo $product['product_img']; ?>' class="product-img" alt="Product Image" style='width: 80rem; max-height: 400px;'">
        </div>
        <div class="product-details">
            <div class="product-name text-start"><?php echo $product['product_name']; ?></div>
            <div class="product-brand text-start">แบรนด์: <?php echo $product['product_brand']; ?></div>
            <div class="product-description text-start">รายละเอียด: <?php echo $product['product_description'];?></div>
            <div class="product-price text-start text-start">ราคา<?php echo number_format($product['product_price']);?>บาท</div>
            <div class="quantity">
            <button class="btn btn-outline-dark " id="decrease" ><i class="fas fa-minus"></i></button>
            <input type="text" class="quantity-input btn btn-outline-dark" id="quantity" value="1" >
            <button class="btn btn-outline-dark" id="increase"><i class="fas fa-plus"></i></button>
</div>
<div class="product-info text-start">สินค้าคงเหลือ <?php echo $product['product_stock']; ?> ชิ้น</div>
<div class="text-center">
                                    <?php if ($product["product_stock"] > 0) { ?>
                                        <a href='product_detail.php?product_id=<?php echo $product["product_id"]; ?>' class="btn btn-outline-primary">หยิ่บใส่ตะกร้า<i class="fas fa-cart-plus"></i></a>
                                    <?php } else { ?>
                                        <button class="btn btn-outline-danger" disabled>สินค้าหมด</button>
                                    <?php } ?>
                                </div>
                            
            <div class="date-up text-right ">อัพเดทล่าสุด <?php echo $product['dateup']; ?></div>
            
        </div>
    </div> 

</body>
</html>
<script src="https://kit.fontawesome.com/64d58efce2.js"crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   $(document).ready(function () {
    var quantityInput = $('#quantity');
    var addToCartBtn = $('.btn-outline-primary');

    $('#increase').click(function () {
        var currentValue = parseInt(quantityInput.val());
        quantityInput.val(currentValue + 1);
    });

    $('#decrease').click(function () {
        var currentValue = parseInt(quantityInput.val());
        if (currentValue > 1) {
            quantityInput.val(currentValue - 1);
        }
    });

    addToCartBtn.click(function (event) {
        event.preventDefault();

        var quantity = quantityInput.val();
        var product_id = <?php echo $product['product_id']; ?>;

        $.ajax({
            type: 'GET',
            url: 'add_to_cart.php',
            data: {
                product_id: product_id,
                quantity: quantity
            },
            success: function (response) {
                // Notify the user that the item was added to the cart
               
                Swal.fire({
                              title: 'Success',
                              text: 'เพิ่มลงตะกร้าสินค้าแล้ว!',
                              icon: 'success',
                              timer: 2000,
                              allowOutsideClick:false,
                              showConfirmButton: false
                            });
                            setTimeout(function(){
                                location.reload();
                          }, 2000);
                       
                console.log(response);

                // Refresh the page after successful addition
               
            },
            error: function (error) {
                // Handle errors, show user-friendly messages if needed
                alert('Error adding item to cart. Please try again.');
                console.error(error);
            }
        });
    });
});

</script>



       
  <?php
    } else {
        echo "Product not found.";
    }

    // Free result set
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request.";
}

// Close database connection
mysqli_close($con);
?>
