<?php
// Include necessary files, configure database connection, etc.
include '../connection/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $level = mysqli_real_escape_string($con, $_POST['level']);

    // Fetch user ID from the session or any other source
    $user_id = $_SESSION['user_id']; // Update this line based on how you fetch the user ID

    // Check if a new image is uploaded
    $upload = $_FILES['img'];
    if ($upload['name'] != '') {
        // Folder to upload files to
        $uploadPath = "IMG/";

        // Generate a unique name for the file
        $numrand = (mt_rand());
        $type = strrchr($upload['name'], ".");
        $newname = $numrand . $type;
        $path_copy = $uploadPath . $newname;

        // Check if there is an old image
        $queryOldImage = "SELECT img FROM users WHERE user_id = $user_id";
        $resultOldImage = mysqli_query($con, $queryOldImage);

        if ($resultOldImage && mysqli_num_rows($resultOldImage) > 0) {
            $oldImage = mysqli_fetch_assoc($resultOldImage)['img'];

            // Delete the old image
            if (file_exists($uploadPath . $oldImage)) {
                unlink($uploadPath . $oldImage);
            }
        }

        // Move the uploaded file to the designated folder
        move_uploaded_file($upload['tmp_name'], $path_copy);

        // Compress and resize the uploaded image
        $compressedImage = compressImage($uploadPath . $newname, 75); // 75 is the quality, you can adjust it

        // Perform the SQL UPDATE query
        $update_query = "UPDATE users
                         SET first_name = '$first_name', last_name = '$last_name',
                             username = '$username', password = '$password',
                             email = '$email', phone = '$phone', img = '$newname', level = '$level'
                         WHERE user_id = $user_id";

        $result = mysqli_query($con, $update_query);

        if ($result) {
            // Update successful, redirect or provide success message
            header("Location: profile.php");
            exit();
        } else {
            // Update failed, handle error (log, redirect, or display an error message)
            echo "Update failed. Please try again.";
        }
    } else {
        // Handle the case where no new image is uploaded
        // Perform the SQL UPDATE query without updating the image field
        $update_query = "UPDATE users
                         SET first_name = '$first_name', last_name = '$last_name',
                             username = '$username', password = '$password',
                             email = '$email', phone = '$phone', level = '$level'
                         WHERE user_id = $user_id";
        
        $result = mysqli_query($con, $update_query);

        if ($result) {
            // Update successful, redirect or provide success message
            header("Location: profile.php");
            exit();
        } else {
            // Update failed, handle error (log, redirect, or display an error message)
            echo "Update failed. Please try again.";
        }
    }

    // Close database connection and perform any necessary cleanup
    mysqli_close($con);
}

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
