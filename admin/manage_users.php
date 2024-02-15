<?php
include("../menu/menu_admin.php");

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'] || $_SESSION['level'] !== 'A') {
    echo "ปฏิเสธการเข้าใช้. คุณต้องเป็นผู้ดูแลระบบจึงจะสามารถดูหน้านี้ได้.";
    exit();
}

// Fetch all users from the database
$user_query = "SELECT * FROM users where level NOT LIKE 'A' ";
$user_result = mysqli_query($con, $user_query);

// Check for errors
if (!$user_result) {
    echo "Error in query: " . mysqli_error($con);
    exit();
}
?>
<style>
    .zoom {
  padding: 50px;
  transition: transform .2s; /* Animation */
  width: 200px;
  height: 200px;
  margin: 0 auto;
}

.zoom:hover {
  transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Manage Users</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php
        while ($user_data = mysqli_fetch_assoc($user_result)) {
            ?>
            <div class="bg-white rounded-lg p-4 shadow-md">
                <img src="../users/img/<?= $user_data['img']; ?>" alt="User Image" class="zoom object-cover h-20 w-20 mx-auto mb-4 rounded-full">
                <p class="text-lg font-semibold mb-2">User ID: <?= $user_data['user_id']; ?></p>
                <p class="mb-2"><span class="font-semibold">Name:</span> <?= $user_data['first_name'] . ' ' . $user_data['last_name']; ?></p>
                <p class="mb-2"><span class="font-semibold">Username:</span> <?= $user_data['username']; ?></p>
                <p class="mb-2"><span class="font-semibold">Password:</span> <?= $user_data['password']; ?></p>
                <p class="mb-2"><span class="font-semibold">Email:</span> <?= $user_data['email']; ?></p>
                <p class="mb-2"><span class="font-semibold">Role:</span> <?= $user_data['level']; ?></p>
                <p class="mb-2"><span class="font-semibold">Money:</span> <?= $user_data['money']; ?></p>
                <p class="mb-2"><span class="font-semibold">Phone:</span> <?= $user_data['phone']; ?></p>
                <div class="flex justify-end mt-4">
                    <a href='edit_user.php?user_id=<?= $user_data['user_id']; ?>' class='text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900'>Edit</a>
                    &nbsp;
                    <a href='delete_user.php?user_id=<?= $user_data['user_id']; ?>' class='text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900'>Delete</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>


<?php
// Free result set
mysqli_free_result($user_result);

// Close database connection
mysqli_close($con);
?>
