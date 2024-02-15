<script src="https://kit.fontawesome.com/64d58efce2.js"crossorigin="anonymous"></script>

<?php 
include("../menu/menu_user.php");
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    // Redirect to the login page or display an error message
    header("Location: ../login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
?>

<style>
   
    .box {
        width: 20%;
        margin: 10px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .user-info {
        float: left;
        width: 60%;
    }
  .btn-edit {
    padding: 30px;
   }
    .edit-button {
        float: right;
        width: 30%;
        text-align: right;
    }
    .alb img {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 50%;

    }
   
</style>


<?php
// Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id']) {
    echo "Access denied. Please log in.";
    exit();
}
ini_set('display_errors', 1);
error_reporting(~0);

// Fetch user information from the database
$user_id = $_SESSION['user_id'];
$query = "SELECT users.*, addresses.*
          FROM users
          LEFT JOIN addresses ON addresses.user_id = users.user_id
          
          WHERE users.user_id = $user_id";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
    ?>
    <div class="container">
        <div class="row g-3">
            <div class="col-sm-6 .col-md-8">
                <div class="card " style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; padding: 10px;margin-bottom:20px;border-radius: 8px;">
                    <div class="card-body">
                        <div class="edit-button">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#profile"><i class="fas fa-edit"></i>แก้ไข</a>
                        </div>
                       <h5 class="card-title text-start"><b><i class="fas fa-user-cog"></i> จัดการข้อมูลส่วนตัว</b></h5>
                        <p class="card-text text-start"><strong>ชื่อ:</strong> <?php echo $user_data['first_name']; ?> <?php echo $user_data['last_name']; ?></p>
                        <p class="card-text text-start"><strong>อีเมล:</strong> <?php echo $user_data['email']; ?></p>
                        <p class="card-text text-start"><strong>เบอร์:</strong> <?php echo $user_data['phone']; ?></p>
                        <p class="card-text text-start"><strong>เงินคงเหลือ:</strong> ฿<?php echo number_format($user_data['money']); ?> บาท</p>
                        <br>
                      </div>         
                </div>
            </div>
            <div class="col-sm-6 .col-md-8">
                <div class="card" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px; padding: 10px;border-radius: 8px;">
                    <div class="card-body">
                        <h5 class="card-title text-start"><b><i class="fas fa-address-card"></i> จัดการที่อยู่จัดส่ง</b></h5>
                        <?php if ($user_data["address_id"] > 0) { ?>
                          <div class="edit-button">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="position-absolute top-0 end-0 btn-edit btn-edit"><i class="fas fa-edit "></i>แก้ไข</a>
                        </div>
                        <div class="text-center">
               
                        <p class="card-text text-start"><strong>ที่อยู่บรรทัด 1 : </strong> <?php echo $user_data['address_line1']; ?></p>
                        <p class="card-text text-start"><strong>ที่อยู่บรรทัด 2 : </strong> <?php echo $user_data['address_line2']; ?></p>
                        <p class="card-text text-start"><strong>ตำบล: </strong> <?php echo $user_data['Subdistrict']; ?>&nbsp;<strong>อำเภอ:</strong> <?php echo $user_data['District']; ?> </p>
                        <p class="card-text text-start"><strong>จังหวัด: </strong>&nbsp;<?php echo $user_data['city']; ?></p>
                        <p class="card-text text-start"><strong>รหัสไปรษณีย์: </strong> <?php echo $user_data['postal_code']; ?></p>
                    <?php } else { ?>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addAddressModal" class="btn btn-outline-primary  "><i class="fas fa-plus "></i> เพิ่มที่อยู่</a>
                    <?php } ?>
                </div>
               </div>
              </div>
            </div>
            <?php
} else {
    echo "User not found.";
}

?>

            <div class="col-auto .col-md-8">
                <div class="card" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;margin-top:10px; border-radius: 8px;">
                    <div class="card-body">
                        <h5 class="card-title text-start"><b><i class="fas fa-receipt"></i> จัดการใบเสร็จ</b></h5>
                       
                       <?php 
                       $order_query = "SELECT 
                    receipts.receipt_id, 
                    receipts.timestamp, 
                    products.product_name,
                    receipt_items.quantity,
                    products.product_price * receipt_items.quantity AS price,
                    receipts.total_amount
                FROM 
                    receipts
                LEFT JOIN 
                    receipt_items ON receipts.receipt_id = receipt_items.receipt_id
                LEFT JOIN 
                    products ON receipt_items.product_id = products.product_id
                WHERE 
                    receipts.user_id = ?
                ORDER BY 
                    receipts.timestamp DESC";

if ($order_stmt = mysqli_prepare($con, $order_query)) {
    mysqli_stmt_bind_param($order_stmt, "i", $user_id);
    mysqli_stmt_execute($order_stmt);

    $order_result = mysqli_stmt_get_result($order_stmt);

    if (!$order_result) {
        echo "Error in query: " . mysqli_error($con);
        exit();
    }

    if ($order_result && mysqli_num_rows($order_result) > 0) {
        ?>              <div class="table-responsive">
                        <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">ชื่อสินค้า</th>
                        <th scope="col">จำนวน</th>
                        <th scope="col">ราคา</th>
                        <th scope="col">ดูใบเสร็จ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($order_data = mysqli_fetch_assoc($order_result)) {
                        ?>
                        <tr>
                            <td><?= $order_data['product_name']; ?></td>
                            <td class="text-center"><?= $order_data['quantity']; ?></td>
                            <td>฿<?= number_format($order_data['price']); ?></td>
                            <td>
                                <a href='receipt.php?receipt_id=<?= $order_data['receipt_id']; ?>' class='btn btn-primary'>
                                    ดูใบเสร็จ
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
                        </div>
            <?php
    } else {
        echo "<div class='container'><p>ไม่มีรายการคำสั่งซื้อ</p></div>";
    }
    
    mysqli_free_result($order_result);
    mysqli_stmt_close($order_stmt);
}

mysqli_close($con);
?>
                    </div>
                </div>
            </div>
        </div>
    </div>












<!-- จัดการข้อมูลส่วนตัว -->                                                                                                                
<!-- Modal -->
<div class="modal fade " id="profile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="profileLabel" aria-hidden="true" >
  <div class="modal-dialog " >
    <div class="modal-content" >
      <div class="modal-header">
        <h5 class="modal-title" id="profileLabel"><i class="fas fa-user-cog"></i> จัดการข้อมูลส่วนตัว</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="update_profile.php" method="POST" enctype="multipart/form-data" name="upfile" id="upfile">
      <div class="modal-body">
      <div class="mb-3">
            <div  class="col-form-label">รูปภาพ:</div>
               <center>
            <img src="img/<?php echo $row['img']; ?>" alt="" width="250px" height="250px" style="border-radius: 100%; object-fit: cover;" class="lab">
               </center>
          </div>
      <div class="row">
      <div class="col-8 col-sm-6">
            <div  class="text-start col-form-label">ชื่อ:</div>
            <input type="text" class="form-control"  name="first_name" value="<?php echo $user_data['first_name']; ?>" required>
    </div>
    <div class="col-4 col-sm-6">
            <div  class="text-start col-form-label">นามสกุล:</div>
            <input type="text" class="form-control"  name="last_name" value="<?php echo $user_data['last_name']; ?>" required>
    </div>
      </div>
    <div class="mb-3">
            <div class="text-start col-form-label">ชื่อผู้ใช่:ไม่สามารถแก้ไข้ได้</div>
            <div class="form-control text-start"><?php echo $user_data['username']; ?></div>
            <input type="hidden" class="form-control"  name="username" value="<?php echo $user_data['username']; ?>" required >
    </div>
    <div class="mb-3">
            <div  class="text-start col-form-label">รหัสผ่าน:</div>
            <input type="text" class="form-control"  name="password" value="<?php echo $user_data['password']; ?>" required>
    </div>
    <div class="mb-3">
            <div  class="text-start col-form-label">อีเมล:</div>
            <input type="email" class="form-control"  name="email" value="<?php echo $user_data['email']; ?>" required>
    </div>
    <div class="mb-3">
            <div  class="text-start col-form-label">เบอร์:</div>
            <input type="text" class="form-control"  name="phone" value="<?php echo $user_data['phone']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="img" class="form-label">เพิ่ม รูปภาพ</label>
        <input class="form-control" type="file" name="img" id="imgInput">
        <img width="50%" id="previewImg" alt="">
    </div>
      </div>
      <input type="hidden" value="U" name="level">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="submit" value="update" name="update"  class="btn btn-primary">ยืนยัน</button> 
      </div>
    </form>
      </div>
     
    </div>
  </div>
</div>
<script>
    let imgInput = document.getElementById('imgInput');
    let previewImg = document.getElementById('previewImg');

    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file);
        }
    }
</script>




<!-- จัดการที่อยู่จัดส่ง -->
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-address-card"></i> จัดการที่อยู่จัดส่ง</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="update_address.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="address_id" value="<?php echo $user_data['address_id']; ?>">
        <div class="mb-3">
            <div class="text-start col-form-label">ที่อยู่บรรทัด 1 : </div>
            <input type="text" class="form-control"  name="address_line1" value="<?php echo $user_data['address_line1']; ?>" required>
        </div>
        <div class="mb-3">
    <div class="text-start col-form-label">ที่อยู่บรรทัด 2 (ถ้ามี) : </div>
    <input type="text" class="form-control" name="address_line2" value="<?php echo $user_data['address_line2']; ?>">
</div>
        <div class="row">
        <div class="col-8 col-sm-6">
        <div class="text-start col-form-label">ตำบล : </div>
        <input type="text" class="form-control"  name="Subdistrict" value="<?php echo $user_data['Subdistrict']; ?>" required>
        </div>
        <div class="col-4 col-sm-6">
        <div class="text-start col-form-label">อำเภอ : </div>
        <input type="text" class="form-control"  name="District" value="<?php echo $user_data['District']; ?>" required>
        </div>
        <div class="col-4 col-sm-6">
        <div class="text-start col-form-label">จังหวัด : </div>
        <input type="text" class="form-control"  name="city" value="<?php echo $user_data['city']; ?>" required>
        </div>
        </div>
        <div class="col-4">
            <div class="text-start col-form-label">รหัสไปรษณีย์ : </div>
            <input type="text" class="form-control"  name="postal_code" value="<?php echo $user_data['postal_code']; ?>" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary">ตกลง</button>
    </form>
      </div>
    </div>
  </div>
</div>



<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAddressModalLabel"><i class="fas fa-address-card"></i> เพิ่มที่อยู่ใหม่</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="add_address.php" method="post" enctype="multipart/form-data">
            <!-- Inside your form on profile.php -->
          <div class="mb-3">
            <div class="text-start col-form-label">ที่อยู่บรรทัด 1 : </div>
            <input type="text" class="form-control" name="address_line1" required>
          </div>
          
          <div class="mb-3">
            <div class="text-start col-form-label">ที่อยู่บรรทัด 2 (ถ้ามี) : </div>
            <input type="text" class="form-control" name="address_line2">
          </div>
          <div class="row">
            <div class="col-8 col-sm-6">
              <div class="text-start col-form-label">ตำบล : </div>
              <input type="text" class="form-control" name="Subdistrict" required>
            </div>
            <div class="col-4 col-sm-6">
              <div class="text-start col-form-label">อำเภอ : </div>
              <input type="text" class="form-control" name="District" required>
            </div>
            <div class="col-4 col-sm-6">
              <div class="text-start col-form-label">จังหวัด : </div>
              <input type="text" class="form-control" name="city" required>
            </div>
          </div>
          <div class="col-4">
            <div class="text-start col-form-label ">รหัสไปรษณีย์ : </div>
            <input type="text" class="form-control " name="postal_code" required>
          </div>
          <input type="hidden" name="user_id" value="<?php echo isset($user_data['user_id']) ? $user_data['user_id'] : ''; ?>">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary">ตกลง</button>
      </form>
      </div>
    </div>
  </div>
</div>
