<?php


include '../connection/connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "Invalid user ID. Please make sure you are logged in.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $user_id = intval($_SESSION['user_id']); // Use the session user_id
    $address_line1 = mysqli_real_escape_string($con, $_POST['address_line1']);
    $address_line2 = mysqli_real_escape_string($con, $_POST['address_line2']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $district = mysqli_real_escape_string($con, $_POST['District']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $subdistrict = mysqli_real_escape_string($con, $_POST['Subdistrict']);

    // Perform the SQL INSERT query
    $insert_query = "INSERT INTO addresses (user_id, address_line1, address_line2, city, District, postal_code, Subdistrict)
                     VALUES ('$user_id', '$address_line1', '$address_line2', '$city', '$district', '$postal_code', '$subdistrict')";

    $result = mysqli_query($con, $insert_query);

    if ($result) {
        // Insert successful, redirect or provide success message
        header("Location: profile.php");
        exit();
    } else {
        // Insert failed, handle error (log, redirect, or display an error message)
        echo "Insert failed. Please try again.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
    exit();
}

// Close database connection and perform any necessary cleanup
mysqli_close($con);
?>
