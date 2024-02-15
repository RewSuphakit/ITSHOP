
<?php
// Start the session


// Include database connection
include("../connection/connect.php");
include '../menu/menu_user.php';
?>

<div class="container">
    <h1 class="mb-4 text-center"><script src="https://cdn.lordicon.com/lordicon-1.1.0.js"></script>
<lord-icon
    src="https://cdn.lordicon.com/pbrgppbb.json"
    trigger="hover"
    >
</lord-icon> ตะกร้าสินค้า</h1>

    <?php
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        // Display the shopping cart
        echo "<form method='post' action=''>";
        echo "<div class='table-responsive-md'>";
        echo "<table class='table table-hover'>";
        echo "<thead class='thead-dark'>";
        // echo "<tr><th>รูป</th></th><th>สินค้า</th><th>ราคาสินค้า</th><th>ราคารวม</th><th>จำนวน</th><th>การจัดการ</th></tr>";
        echo "</thead><tbody>";

        $total_amount = 0;

        foreach ($_SESSION['cart'] as $index => $cart_item) {
            echo "<tr>";
        
            // Check if the required indexes exist in $cart_item
            $product_name = isset($cart_item['product_name']) ? $cart_item['product_name'] : "N/A";
            $quantity = isset($cart_item['quantity']) ? $cart_item['quantity'] : 0;
            $product_price = isset($cart_item['product_price']) ? $cart_item['product_price'] : 0.00;
            $product_img = isset($cart_item['product_img']) ? $cart_item['product_img'] : "default.jpg"; // กำหนดภาพเริ่มต้น
        
            echo "<td><img src='../product_image/$product_img'  style='max-width: 50px; max-height: 50px;'></td>";
            echo "<td>" . $product_name . "</td>";
            echo "<td>฿" . number_format($product_price) . "</td>";
            echo "<td id='total-$index'>฿" .number_format($quantity * $product_price) . "</td>";
            echo "<td>";
            echo "<div class='btn-group' role='group'>";
            echo "<button  class='btn btn-outline-dark btn-quantity' data-index='$index' data-action='decrease'>-</button>";
            echo "<span class='quantity btn btn-outline-dark' id='quantity-$index'>$quantity</span>";
            echo "<button  class='btn btn-outline-dark btn-quantity' data-index='$index' data-action='increase'>+</button>";
            echo "</div>";
            echo "</td>";
            echo "<td><a  class='btn btn-outline-danger ' href='remove_from_cart.php?index=$index'><i class='far fa-trash-alt'></i></a></td>";
            echo "</tr>";
         
            $total_amount += $quantity * $product_price;
        }
        

        echo "</tbody>";
        echo "<tfoot class='thead-dark'>";
        echo "<tr><td colspan='3'>รวมทั้งหมด</td><td id='total-amount'>฿" . number_format($total_amount) . " </td><td></td><td></td></tr>";
      
        echo "</tfoot>";
        echo "</table>";
        echo "</div>";
        echo "<p><a class='btn btn-primary' href='payment.php'>ดำเนินการชำระเงิน</a></p>";
    } else {
        echo "  
        <h4><p class='alert alert-secondary'>ไม่มีสินค้าในตะกร้า <i class='bi bi-cart-x'></i></p></h4>
      <p class='alert alert-secondary'> คุณไม่มีสินค้าในตะกร้า โปรดเลือกหยิบสินค้าที่ต้องการซื้อลงตะกร้า</p>";
      
    }

    // Close database connection
    mysqli_close($con);
    ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const quantityButtons = document.querySelectorAll('.btn-quantity');

    quantityButtons.forEach(button => {
        button.addEventListener('click', function () {
            const index = this.dataset.index;
            const action = this.dataset.action;
            const quantitySpan = document.getElementById(`quantity-${index}`);
            const totalCell = document.getElementById(`total-${index}`);

            let currentQuantity = parseInt(quantitySpan.innerText);

            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity--;
            }

            // Update the quantity in the span
            quantitySpan.innerText = currentQuantity;

            // Send AJAX request to update_cart.php
            const updateUrl = `update_cart.php?index=${index}&quantity=${currentQuantity}`;
            fetch(updateUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    // Optionally handle success response
                    // You might want to update other UI elements as well
                })
                .catch(error => console.error('Error updating cart:', error));

            // Update the total price in the cell
            const productPrice = parseFloat(<?php echo json_encode(end($_SESSION['cart'])['product_price']); ?>);
            const totalAmount = currentQuantity * productPrice;
            totalCell.innerText = "$" + totalAmount.toFixed(2);

            // Update the total amount in the summary row
            updateTotalAmount();
        });
    });

    function updateTotalAmount() {
        const totalCells = document.querySelectorAll('[id^="total-"]');
        let newTotalAmount = 0;

        totalCells.forEach(cell => {
            const cellAmount = parseFloat(cell.innerText.replace('$', ''));
            newTotalAmount += cellAmount;
        });

        // Update the total amount in the summary row
        const totalAmountElement = document.getElementById('total-amount');
        totalAmountElement.innerText = "$" + newTotalAmount.toFixed(2);
    }
});
</script>
