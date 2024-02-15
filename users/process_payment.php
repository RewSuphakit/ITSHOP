<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $payment_method = $_POST["payment_method"];

   // Process payment based on the selected payment method
   if ($payment_method === "website") {
      // Include checkout.php for website payment
      include 'checkout.php';
   } elseif ($payment_method === "GBPrimePay") {
      // Redirect to GBPrimePay for payment
      header("Location: gbprimepay.php");
      exit;
   } else {
      // Invalid payment method
      echo "Invalid payment method.";
   }
}
?>
