<?php
// Include necessary files, configure database connection, etc.
include '../connection/connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $address_id = mysqli_real_escape_string($con, $_POST['address_id']);
    $address_line1 = mysqli_real_escape_string($con, $_POST['address_line1']);
    $address_line2 = mysqli_real_escape_string($con, $_POST['address_line2']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $district = mysqli_real_escape_string($con, $_POST['District']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $subdistrict = mysqli_real_escape_string($con, $_POST['Subdistrict']);

    // Perform the SQL UPDATE query
    $update_query = "UPDATE addresses
                     SET address_line1 = '$address_line1', address_line2 = '$address_line2',
                         city = '$city', District = '$district',
                         postal_code = '$postal_code', Subdistrict = '$subdistrict'
                     WHERE address_id = $address_id";

    $result = mysqli_query($con, $update_query);

    if ($result) {
        // Update successful, redirect or provide success message
        header("Location: profile.php");
        exit();
    } else {
        // Update failed, handle error (log, redirect, or display an error message)
        echo "Update failed. Please try again.";
    }

    // Close database connection and perform any necessary cleanup
    mysqli_close($con);
}
?>
