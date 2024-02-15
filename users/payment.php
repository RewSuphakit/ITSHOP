<?php
include '../menu/menu_user.php';

// Additional code to display selected items or cart details
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ชำระเงิน</title>
   <!-- Add your CSS links or stylesheets here -->
   <!-- Include Bootstrap CSS -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
</head>
<body>

   <div class="container mt-5">
      <div class="card">
         <div class="card-header">
            <h1 class="mb-0">ชำระเงิน</h1>
         </div>
         <div class="card-body">
            <form action="process_payment.php" method="post">
               <div class="mb-3">
                  <label for="payment_method" class="form-label fs-2">เลือกวิธีการชำระเงิน:</label>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="payment_method" id="website" value="website">
                     <label class="form-check-label fs-3" for="website">ชำระทางเว็บ</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="payment_method" id="GBPrimePay" value="GBPrimePay">
                     <label class="form-check-label fs-3" for="GBPrimePay">GBPrimePay</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card">
                     <label class="form-check-label fs-3" for="credit_card">บัตรเครดิต</label>
                  </div>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                     <label class="form-check-label fs-3" for="paypal">PayPal</label>
                  </div>
                  <!-- Add more payment methods as needed -->
               </div>

               <div class="mb-3">
                  <!-- You can add more fields here if needed -->
               </div>

               <button type="submit" class="btn btn-primary fs-4">ชำระเงิน</button>
            </form>
         </div>
      </div>
   </div>

   <!-- Add your additional scripts or JS links here -->

   <!-- Include Bootstrap JS and Popper.js -->
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
